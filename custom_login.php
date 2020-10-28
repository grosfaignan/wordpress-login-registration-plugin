<?php
/*
Plugin Name: Custom login
Plugin URI: #
Description: login
Version: 1.0
Author: Grosfaignan
Author URI: #
 */


 /**
 * display login form
 * @param username text user_login
 * @param password password type user_password
 * @param reg_errors display error inside form
 */
function login_form($username, $password, $reg_errors)
{
	require 'login_form.php';
}

 /**
 * login input validation 
 * @param username text user_login
 * @param password password type user_password
 * 
 * @return auth in WP_user/WP_error format
 */
function login_validation($username, $password)
{
	global $reg_errors;
	$reg_errors = new WP_Error();
	$cred       = array($username, $password);

	//authenticate user

	$auth = wp_authenticate($username, $password);
	if (!is_wp_error($auth)) {
		// without authenticate error, set the user as current
		$user  = get_user_by('login', $username);
		$login = wp_set_current_user(null, $username);
		wp_set_auth_cookie($user->ID);
	}
	return $auth;
}

 /**
 * main function
 */

function custom_login_function()
{
	global $username, $password;

	//validate and log user after submit form
	if (isset($_POST['login_submit'])) {
		$validation=login_validation(
			$_POST['user_login'],
			$_POST['user_password']
		);
	}
	//display form
	login_form(
		$username,
		$password,
		$validation,
	);
}

// Register a new shortcode: [cr_custom_login]
add_shortcode('cr_custom_login', 'custom_login_shortcode');

// The callback function that will replace [book]
function custom_login_shortcode()
{
	ob_start();
	custom_login_function();
	return ob_get_clean();
}
//add init action do place login function earlier in the wordpress loading
add_action('init', 'custom_login_shortcode');
