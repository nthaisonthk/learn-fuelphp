<?php

class Controller_Dashboard extends Controller
{
    public function before()
    {
        // check nếu không đăng nhập sẽ back về trang login
        if (!Auth::check()) {
            Response::redirect('auth/login');
        }
    }
    
    public function action_index()
    {
        $user = Auth::get_user();
        $group_id = $user->group_id;
        $group = Model_UserGroup::find($group_id);
        $group_name = $group ? $group->name : 'Unknown';

        if ($group_id == 6) {
            // Admin dashboard
            $total_users = Model_User::query()->count();
            $total_posts = Model_Post::query()->count();
            $total_comments = Model_Comment::query()->count();
            $pending_comments = Model_Comment::query()->where('status', 'pending')->count();
            
            $view = View::forge('dashboard/admin');
            $view->set('user', $user);
            $view->set('total_users', $total_users);
            $view->set('total_posts', $total_posts);
            $view->set('total_comments', $total_comments);
            $view->set('pending_comments', $pending_comments);
            $view->set('role', $group_name);
            $view->set_global('title', 'Admin Dashboard');
        } elseif ($group_id >= 2) {
            // Author dashboard
            $posts = Model_Post::query()
                ->where('user_id', $user->id)
                ->order_by('created_at', 'DESC')
                ->get();
            
            $view = View::forge('dashboard/author');
            $view->set('user', $user);
            $view->set('posts', $posts);
            $view->set('role', $group_name);
            $view->set_global('title', 'Author Dashboard');
        } else {
            // Normal user dashboard
            $comments = Model_Comment::query()
                ->where('user_id', $user->id)
                ->order_by('created_at', 'DESC')
                ->limit(10)
                ->get();
            $view = View::forge('dashboard/user');
            $view->set('user', $user);
            $view->set('comments', $comments);
            $view->set('role', $group_name);
            $view->set_global('title', 'User Dashboard');
        }

        return Response::forge(View::forge('template')->set('content', $view, false));
    }
} 