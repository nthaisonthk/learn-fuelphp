<?php

class Controller_Auth extends Controller
{
    public function action_login()
    {
        if (Auth::check()) {
            Response::redirect('dashboard');
        }
        
        if (Input::method() == 'POST') {
            $username = Input::post('username');
            $password = Input::post('password');
            
            if (Auth::login($username, $password)) {
                Session::set_flash('success');
                Response::redirect('dashboard');
            } else {
                Session::set_flash('error', 'Username or password incorrect');
            }
        }

        $view = View::forge('auth/login');
        $view->set_global('title', 'Login');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_register()
    {
        if (Auth::check()) {
            Response::redirect('dashboard');
        }
        
        if (Input::method() == 'POST') {
            $username = Input::post('username');
            $email = Input::post('email');
            $password = Input::post('password');
            $confirm_password = Input::post('confirm_password');

            // Validation
            $val = Validation::forge();
            $val->add_field('username', 'Username', 'required|min_length[3]|max_length[50]');
            $val->add_field('email', 'Email', 'required|valid_email');
            $val->add_field('password', 'Password', 'required|min_length[6]');
            $val->add_field('confirm_password', 'Confirmed Password', 'required|match_field[password]');
            
            if ($val->run()) {
                // Check if username exists
                $existing_user = Model_User::query()->where('username', $username)->get_one();
                if ($existing_user) {
                    Session::set_flash('error', 'Username exist!');
                    $view = View::forge('auth/register');
                    $view->set_global('title', 'Register');
                    return Response::forge(View::forge('template')->set('content', $view, false));
                }
                
                // Check if email exists
                $existing_email = Model_User::query()->where('email', $email)->get_one();
                if ($existing_email) {
                    Session::set_flash('error', 'Email exist!');
                    $view = View::forge('auth/register');
                    $view->set_global('title', 'Đăng ký');
                    return Response::forge(View::forge('template')->set('content', $view, false));
                }
                
                // Create user using Auth
                try {
                    $created = Auth::create_user($username, $password, $email, 3); //default group: normal user
                    if ($created) {
                        Session::set_flash('success', 'Success! Please login.');
                        Response::redirect('auth/login');
                    } else {
                        Session::set_flash('error', 'An error occurred!');
                    }
                } catch (Exception $e) {
                    Session::set_flash('error', 'An error occurred: ' . $e->getMessage());
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }
        
        $view = View::forge('auth/register');
        $view->set_global('title', 'Register');
        return Response::forge(View::forge('template')->set('content', $view, false));
    }
    
    public function action_logout()
    {
        Auth::logout();
        Session::set_flash('success', 'Logout!');
        Response::redirect('/');
    }
} 