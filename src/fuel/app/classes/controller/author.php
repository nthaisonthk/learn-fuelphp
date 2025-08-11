<?php

class Controller_Author extends Controller
{
    public function before()
    {
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
        
        $user = Auth::get_user();
        if ($user->group_id != ROLE_AUTHOR) {
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

            // Handle file upload
            $uploaded_file = $this->handle_file_upload('featured_image');
            if ($uploaded_file) {
                $post->featured_image = $uploaded_file;
            }

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
            // Delete associated image
            if ($post->featured_image && file_exists(DOCROOT . 'assets/uploads/' . $post->featured_image)) {
                unlink(DOCROOT . 'assets/uploads/' . $post->featured_image);
            }
            
            $post->delete();
            Session::set_flash('success', 'Deleted successfully!');
        }
        
        Response::redirect('author/posts');
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
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            Session::set_flash('error', 'Invalid file type. Only JPG, PNG, and GIF are allowed.');
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