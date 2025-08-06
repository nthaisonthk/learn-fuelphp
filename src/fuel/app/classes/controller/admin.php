<?php

class Controller_Admin extends Controller
{
    public function before()
    {
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
        
        $user = Auth::get_user();
        if ($user->group_id != 3) {
            Session::set_flash('error', 'Bạn không có quyền truy cập trang này!');
            Response::redirect('dashboard');
        }
    }
    
    // User Management
    public function action_users()
    {
        $users = Model_User::query()->order_by('created_at', 'DESC')->get();
        
        $view = View::forge('admin/users');
        $view->set('users', $users);
        $view->set_global('title', 'Quản lý người dùng');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_user_edit($id = null)
    {
        if (!$id) {
            Response::redirect('admin/users');
        }
        
        $user = Model_User::query()->where('id', $id)->get_one();
        if (!$user) {
            Response::redirect('admin/users');
        }
        
        if (Input::method() == 'POST') {
            $user->username = Input::post('username');
            $user->email = Input::post('email');
            $user->group = Input::post('group');
            
            if ($user->save()) {
                Session::set_flash('success', 'Cập nhật người dùng thành công!');
                Response::redirect('admin/users');
            } else {
                Session::set_flash('error', 'Có lỗi xảy ra khi cập nhật!');
            }
        }
        
        $view = View::forge('admin/user_edit');
        $view->set('user', $user);
        $view->set_global('title', 'Chỉnh sửa người dùng');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_user_delete($id = null)
    {
        if (!$id) {
            Response::redirect('admin/users');
        }
        
        $user = Model_User::query()->where('id', $id)->get_one();
        if ($user && $user->id != Auth::get_user_id()) {
            $user->delete();
            Session::set_flash('success', 'Xóa người dùng thành công!');
        }
        
        Response::redirect('admin/users');
    }
    
    // Post Management
    public function action_posts()
    {
        $posts = Model_Post::query()
            ->related('user')
            ->order_by('created_at', 'DESC')
            ->get();
        
        $view = View::forge('admin/posts');
        $view->set('posts', $posts);
        $view->set_global('title', 'Quản lý bài viết');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_edit($id = null)
    {
        if (!$id) {
            Response::redirect('admin/posts');
        }
        
        $post = Model_Post::query()->where('id', $id)->get_one();
        if (!$post) {
            Response::redirect('admin/posts');
        }
        
        if (Input::method() == 'POST') {
            $post->title = Input::post('title');
            $post->content = Input::post('content');
            $post->excerpt = Input::post('excerpt');
            $post->status = Input::post('status');
            $post->slug = $this->create_slug(Input::post('title'));
            
            if ($post->save()) {
                Session::set_flash('success', 'Cập nhật bài viết thành công!');
                Response::redirect('admin/posts');
            } else {
                Session::set_flash('error', 'Có lỗi xảy ra khi cập nhật!');
            }
        }
        
        $view = View::forge('admin/post_edit');
        $view->set('post', $post);
        $view->set_global('title', 'Chỉnh sửa bài viết');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_delete($id = null)
    {
        if (!$id) {
            Response::redirect('admin/posts');
        }
        
        $post = Model_Post::query()->where('id', $id)->get_one();
        if ($post) {
            $post->delete();
            Session::set_flash('success', 'Xóa bài viết thành công!');
        }
        
        Response::redirect('admin/posts');
    }
    
    // Comment Management
    public function action_comments()
    {
        $comments = Model_Comment::query()
            ->related('user')
            ->related('post')
            ->order_by('created_at', 'DESC')
            ->get();
        
        $view = View::forge('admin/comments');
        $view->set('comments', $comments);
        $view->set_global('title', 'Quản lý bình luận');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_comment_approve($id = null)
    {
        if (!$id) {
            Response::redirect('admin/comments');
        }
        
        $comment = Model_Comment::query()->where('id', $id)->get_one();
        if ($comment) {
            $comment->status = 'approved';
            $comment->save();
            Session::set_flash('success', 'Duyệt bình luận thành công!');
        }
        
        Response::redirect('admin/comments');
    }
    
    public function action_comment_reject($id = null)
    {
        if (!$id) {
            Response::redirect('admin/comments');
        }
        
        $comment = Model_Comment::query()->where('id', $id)->get_one();
        if ($comment) {
            $comment->status = 'spam';
            $comment->save();
            Session::set_flash('success', 'Từ chối bình luận thành công!');
        }
        
        Response::redirect('admin/comments');
    }
    
    private function create_slug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }
} 