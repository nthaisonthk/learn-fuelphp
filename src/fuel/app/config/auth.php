<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010-2025 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(
	'driver' => 'Ormauth',
	'verify_multiple_logins' => false,
	'ormauth' => array(
		'table_name' => 'users',
		'username' => 'user',
		'password' => 'password',
		'email' => 'email',
		'group' => 'group',
		'profile_fields' => 'profile_fields',
		'last_login' => 'last_login',
		'login_hash' => 'login_hash',
		'salt' => 'salt',
	),
);
