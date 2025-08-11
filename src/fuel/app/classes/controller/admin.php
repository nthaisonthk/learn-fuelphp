<?php

class Controller_Admin extends Controller
{
    public function before()
    {
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
        
        $user = Auth::get_user();
        if ($user->group_id != ROLE_ADMIN) {
            Session::set_flash('error', 'You do not have permission to access this page!');
            Response::redirect('dashboard');
        }
    }
    
    // User Management
    public function action_users()
    {
        $users = Model_User::query()->order_by('created_at', 'ASC')->get();
        
        $view = View::forge('admin/users');
        $view->set('users', $users);
        $view->set_global('title', 'User management');
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
            $user->group_id = Input::post('group');
            if ($user->save()) {
                Session::set_flash('success', 'Updated successfully!');
                Response::redirect('admin/users');
            } else {
                Session::set_flash('error', 'An error occurred!');
            }
        }
        
        $view = View::forge('admin/user_edit');
        $view->set('user', $user);
        $view->set_global('title', 'Edit user');
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
            Session::set_flash('success', 'Deleted successfully!');
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
        $view->set_global('title', 'Posts Management');

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
            
            // Handle file upload
            $uploaded_file = $this->handle_file_upload('featured_image');
            if ($uploaded_file) {
                // Delete old image if exists
                if ($post->featured_image && file_exists(DOCROOT . 'assets/uploads/' . $post->featured_image)) {
                    unlink(DOCROOT . 'assets/uploads/' . $post->featured_image);
                }
                $post->featured_image = $uploaded_file;
            }
            
            if ($post->save()) {
                Session::set_flash('success', 'Updated Successfully!');
                Response::redirect('admin/posts');
            } else {
                Session::set_flash('error', 'An error occurred!');
            }
        }
        
        $view = View::forge('admin/post_edit');
        $view->set('post', $post);
        $view->set_global('title', 'Edit post');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_post_delete($id = null)
    {
        if (!$id) {
            Response::redirect('admin/posts');
        }
        
        $post = Model_Post::query()->where('id', $id)->get_one();
        if ($post) {
            // Delete associated image
            if ($post->featured_image && file_exists(DOCROOT . 'assets/uploads/' . $post->featured_image)) {
                unlink(DOCROOT . 'assets/uploads/' . $post->featured_image);
            }
            
            $post->delete();
            Session::set_flash('success', 'Deleted successfully');
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
        $view->set_global('title', 'Comments Management');
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
            Session::set_flash('success', 'Approved comment!');
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
            Session::set_flash('success', 'Rejected this comment!');
        }
        
        Response::redirect('admin/comments');
    }
    
    private function create_slug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }
    
    private function handle_file_upload($field_name)
    {
        if (!isset($_FILES[$field_name]) || $_FILES[$field_name]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $file = $_FILES[$field_name];
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($file['type'], $allowed_types)) {
            Session::set_flash('error', 'Invalid file type. Only JPG, PNG are allowed.');
            return false;
        }
        
        // Validate file size (2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            Session::set_flash('error', 'File size must be less than 2MB.');
            return false;
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $upload_path = DOCROOT . 'assets/uploads/' . $filename;
        
        // Create uploads directory if it doesn't exist
        $uploads_dir = DOCROOT . 'assets/uploads/';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0755, true);
        }
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            return $filename;
        } else {
            Session::set_flash('error', 'Failed to upload file.');
            return false;
        }
    }
} 