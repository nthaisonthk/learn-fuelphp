<?php

class Controller_Blog extends Controller
{
    public function action_index()
    {
        $search = Input::get('search', '');
        
        $query = Model_Post::query()
            ->where('status', 'published');
        
        // Thêm điều kiện tìm kiếm nếu có
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }
        
        $posts = $query->order_by('created_at', 'DESC')->get();
        
        $view = View::forge('blog/index');
        $view->set('posts', $posts);
        $view->set('search', $search);
        $view->set_global('title', 'Blog - Home page');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_search()
    {
        // Chỉ xử lý AJAX request
        if (!Input::is_ajax()) {
            Response::redirect('blog');
        }
        
        $search = Input::get('search', '');
        $query = Model_Post::query()
            ->where('status', 'published');
        
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }
        
        $posts = $query->order_by('created_at', 'DESC')->get();
        
        // Trả về JSON response
        $response = array(
            'success' => true,
            'posts' => array(),
            'total' => count($posts),
            'search' => $search
        );
        
        foreach ($posts as $post) {
            $response['posts'][] = array(
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->get_excerpt(100),
                'author' => $post->user->username,
                'date' => date('d/m/Y', $post->created_at),
                'comments_count' => count($post->comments),
                'featured_image' => $post->featured_image,
                'url' => Uri::base() . 'blog/view/' . $post->id,
                'is_published' => $post->is_published()
            );
        }
        
        return Response::forge(json_encode($response), 200, array(
            'Content-Type' => 'application/json'
        ));
    }
    
    public function action_view($id = null)
    {
        if (!$id) {
            Response::redirect('blog');
        }
        
        $post = Model_Post::query()
            ->where('id', $id)
            ->where('status', 'published')
            ->get_one();
        
        if (!$post) {
            Response::redirect('blog');
        }
        
        $comments = $post->get_approved_comments();
        
        $view = View::forge('blog/view');
        $view->set('post', $post);
        $view->set('comments', $comments);
        $view->set_global('title', $post->title . ' - Blog');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_comment($post_id = null)
    {
        if (!Auth::check()) {
            Session::set_flash('error', 'Must login to comment!');
            Response::redirect('auth/login');
        }
        
        if (!$post_id || Input::method() != 'POST') {
            Response::redirect('blog');
        }
        
        $post = Model_Post::query()
            ->where('id', $post_id)
            ->where('status', 'published')
            ->get_one();
        
        if (!$post) {
            Response::redirect('blog');
        }
        
        $content = Input::post('content');
        $parent_id = Input::post('parent_id', null);
        
        if (empty($content)) {
            Session::set_flash('error', 'Comment content cannot be blank!');
            Response::redirect('blog/view/' . $post_id);
        }

        $user = Auth::get_user();
        $comment = Model_Comment::forge();
        $comment->content = $content;
        $comment->post_id = $post_id;
        $comment->user_id = $user->id;
        $comment->parent_id = $parent_id;
        $comment->status = 'pending'; // Default to pending for moderation
        
        if ($comment->save()) {
            Session::set_flash('success', 'Comment successfully');
        } else {
            Session::set_flash('error', 'Comment cant not be send');
        }
        
        Response::redirect('blog/view/' . $post_id);
    }
} 