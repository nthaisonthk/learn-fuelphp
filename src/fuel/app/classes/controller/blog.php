<?php

class Controller_Blog extends Controller
{
    public function action_index()
    {
        $posts = Model_Post::query()
            ->where('status', 'published')
            ->order_by('created_at', 'DESC')
            ->get();
        
        $view = View::forge('blog/index');
        $view->set('posts', $posts);
        $view->set_global('title', 'Trang chủ - Blog System');
        return Response::forge(View::forge('template')->set('content', $view, false));
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
        $view->set_global('title', $post->title . ' - Blog System');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_comment($post_id = null)
    {
        if (!Auth::check()) {
            Session::set_flash('error', 'Bạn cần đăng nhập để bình luận!');
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
            Session::set_flash('error', 'Nội dung bình luận không được để trống!');
            Response::redirect('blog/view/' . $post_id);
        }
        
        $comment = Model_Comment::forge();
        $comment->content = $content;
        $comment->post_id = $post_id;
        $comment->user_id = Auth::get_user_id();
        $comment->parent_id = $parent_id;
        $comment->status = 'pending'; // Default to pending for moderation
        
        if ($comment->save()) {
            Session::set_flash('success', 'Bình luận đã được gửi và đang chờ duyệt!');
        } else {
            Session::set_flash('error', 'Có lỗi xảy ra khi gửi bình luận!');
        }
        
        Response::redirect('blog/view/' . $post_id);
    }
} 