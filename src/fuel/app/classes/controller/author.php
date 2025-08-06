<?php

class Controller_Author extends Controller
{
    public function before()
    {
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
        
        $user = Auth::get_user();
        if ($user->group_id != 4) {
            Session::set_flash('error', 'You do not have permission to access this page!');
            Response::redirect('dashboard');
        }
    }
    
    public function action_posts()
    {
        $user = Auth::get_user();
        $posts = Model_Post::query()
            ->where('user_id', $user->id)
            ->order_by('created_at', 'DESC')
            ->get();
        
        $view = View::forge('author/posts');
        $view->set('posts', $posts);
        $view->set_global('title', 'Post management');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_create()
    {
        $user = Auth::get_user();
        if (Input::method() == 'POST') {
            $post = Model_Post::forge();
            $post->title = Input::post('title');
            $post->content = Input::post('content');
            $post->excerpt = Input::post('excerpt');
            $post->status = Input::post('status');
            $post->user_id = $user->id;
            $post->featured_image = '';
            $post->slug = $this->create_slug(Input::post('title'));

            if ($post->save()) {
                Session::set_flash('success', 'Created post successfully!');
                Response::redirect('author/posts');
            } else {
                Session::set_flash('error', 'An error occurred!');
            }
        }
        
        $view = View::forge('author/post_create');
        $view->set_global('title', 'New post');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_edit($id = null)
    {
        if (!$id) {
            Response::redirect('author/posts');
        }

        $user = Auth::get_user();
        $post = Model_Post::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->get_one();
        
        if (!$post) {
            Response::redirect('author/posts');
        }
        
        if (Input::method() == 'POST') {
            $post->title = Input::post('title');
            $post->content = Input::post('content');
            $post->excerpt = Input::post('excerpt');
            $post->status = Input::post('status');
            $post->slug = $this->create_slug(Input::post('title'));
            
            if ($post->save()) {
                Session::set_flash('success', 'Updated post successfully!');
                Response::redirect('author/posts');
            } else {
                Session::set_flash('error', 'An error occurred!');
            }
        }
        
        $view = View::forge('author/post_edit');
        $view->set('post', $post);
        $view->set_global('title', 'Edit post');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_delete($id = null)
    {
        if (!$id) {
            Response::redirect('author/posts');
        }
        
        $post = Model_Post::query()
            ->where('id', $id)
            ->where('user_id', Auth::get_user_id())
            ->get_one();
        
        if ($post) {
            $post->delete();
            Session::set_flash('success', 'Xóa bài viết thành công!');
        }
        
        Response::redirect('author/posts');
    }
    
    private function create_slug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }
} 