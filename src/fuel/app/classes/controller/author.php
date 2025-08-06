<?php

class Controller_Author extends Controller
{
    public function before()
    {
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
        
        $user = Auth::get_user();
        if ($user->group_id < 2) {
            Session::set_flash('error', 'Bạn không có quyền truy cập trang này!');
            Response::redirect('dashboard');
        }
    }
    
    public function action_posts()
    {
        $posts = Model_Post::query()
            ->where('user_id', Auth::get_user_id())
            ->order_by('created_at', 'DESC')
            ->get();
        
        $view = View::forge('author/posts');
        $view->set('posts', $posts);
        $view->set_global('title', 'Quản lý bài viết');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_create()
    {
        if (Input::method() == 'POST') {
            $post = Model_Post::forge();
            $post->title = Input::post('title');
            $post->content = Input::post('content');
            $post->excerpt = Input::post('excerpt');
            $post->status = Input::post('status', 'draft');
            $post->user_id = Auth::get_user_id();
            $post->slug = $this->create_slug(Input::post('title'));
            
            if ($post->save()) {
                Session::set_flash('success', 'Tạo bài viết thành công!');
                Response::redirect('author/posts');
            } else {
                Session::set_flash('error', 'Có lỗi xảy ra khi tạo bài viết!');
            }
        }
        
        $view = View::forge('author/post_create');
        $view->set_global('title', 'Tạo bài viết mới');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_edit($id = null)
    {
        if (!$id) {
            Response::redirect('author/posts');
        }
        
        $post = Model_Post::query()
            ->where('id', $id)
            ->where('user_id', Auth::get_user_id())
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
                Session::set_flash('success', 'Cập nhật bài viết thành công!');
                Response::redirect('author/posts');
            } else {
                Session::set_flash('error', 'Có lỗi xảy ra khi cập nhật!');
            }
        }
        
        $view = View::forge('author/post_edit');
        $view->set('post', $post);
        $view->set_global('title', 'Chỉnh sửa bài viết');
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