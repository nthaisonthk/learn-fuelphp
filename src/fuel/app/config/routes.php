<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'blog/index',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	'_404_' => 'welcome/404',

	/**
	 * -------------------------------------------------------------------------
	 *  Example for Presenter
	 * -------------------------------------------------------------------------
	 *
	 *  A route for showing page using Presenter
	 *
	 */

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),

    // Auth routes
    'auth/login' => 'auth/login',
    'auth/register' => 'auth/register',
    'auth/logout' => 'auth/logout',
    
    // Blog routes
    'blog' => 'blog/index',
    'blog/view/(:id)' => 'blog/view/$1',
    'blog/comment/(:id)' => 'blog/comment/$1',
    
    // Dashboard routes
    'dashboard' => 'dashboard/index',
    
    // Author routes
    'author/posts' => 'author/posts',
    'author/post_create' => 'author/post_create',
    'author/post_edit/(:id)' => 'author/post_edit/$1',
    'author/post_delete/(:id)' => 'author/post_delete/$1',
    
    // Admin routes
    'admin/users' => 'admin/users',
    'admin/user_edit/(:id)' => 'admin/user_edit/$1',
    'admin/user_delete/(:id)' => 'admin/user_delete/$1',
    'admin/posts' => 'admin/posts',
    'admin/post_edit/(:id)' => 'admin/post_edit/$1',
    'admin/post_delete/(:id)' => 'admin/post_delete/$1',
    'admin/comments' => 'admin/comments',
    'admin/comment_approve/(:id)' => 'admin/comment_approve/$1',
    'admin/comment_reject/(:id)' => 'admin/comment_reject/$1',
    
    // API routes
    'api/user' => 'api/user/index',
    'api/user/(:id)' => 'api/user/view/$1',
);
