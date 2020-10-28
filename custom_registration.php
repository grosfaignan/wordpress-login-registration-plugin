<?php
/*
Plugin Name: Custom registration
Plugin URI: #
Description: registration
Version: 1.0
Author: Grosfaignan
Author URI: #
 */

/**
 * fonction d'appel et d'affichage du formulaire
 * @param username text user_login
 * @param email email address user_email
 * @param password password type user_password
 * @param password2 second password for verification
 * @param reg_errors display error inside form
 */
function registration_form($username, $email, $password, $password2, $reg_errors)
{

	require 'registration_form.php';
}

/**
 * fonction de verification des entrées utilisateur
 * @param username text user_login
 * @param email email address user_email
 * @param password password type user_password
 * @param password2 second password for verification
 *
 * @return reg_errors and pass them to registration_form() by custom_registration_fucntion
 */ 
function registration_validation($username, $email, $password, $password2)
{

	global $reg_errors;
	$reg_errors = new WP_Error();

	//username already present in database
	if (username_exists($username)) {
		$reg_errors->add('username', 'Sorry, that username already exists!');
	}

	//insername not valid
	if (!validate_username($username)) {
		$reg_errors->add('username_invalid', 'Sorry, the username you entered is not valid');
	}

	//is not email 
		if (!is_email($email)) {
		$reg_errors->add('email_invalid', 'Email is not valid');
	}
	// password dont match
	if ($password2 != $password) {
		$reg_errors->add('pwd_error', 'password don\'t match');
	}
	return $reg_errors;

}

/**
 * process to registration
 * @return true in success false in other ways
 */ 
function complete_registration()
{
	global $reg_errors, $username, $password, $email;

	// wihtout reg_errors
	if (1 > count($reg_errors->get_error_messages())) {
		
		//format data
		$userdata = array(
			'user_login' => $username,
			'user_email' => $email,
			'user_pass'  => $password,
		);

		//insert user
		$user = wp_insert_user($userdata);

		// without user insertion errors
		if (!is_wp_error($user)) {
			$user = get_user_by('login', $username);
			echo 'Registration complete';
			// set the new user as current user
			$login = wp_set_current_user(null, $username);
			wp_set_auth_cookie($user->ID);
			return true;
		} else {
			return false;
		}

	}
}

/**
 * main function
 */ 

function custom_registration_function()
{
	// POST Action
	if (isset($_POST['register_submit'])) {
		$validation = registration_validation(
			$_POST['username'],
			$_POST['email'],
			$_POST['password'],
			$_POST['password_2'],
		);

		// sanitize user form input
		global $username, $email, $password, $password2;
		$username = sanitize_user($_POST['username']);
		$email    = sanitize_email($_POST['email']);
		$password = esc_attr($_POST['password']);

		// call @function complete_registration to create the user
		// only when no WP_error is found
		$registered = complete_registration();
		
	}

	registration_form(
		$username,
		$email,
		$password,
		$password2,
		$validation,
	);
}


// Register a new shortcode: [cr_custom_registration]
add_shortcode('cr_custom_registration', 'custom_registration_shortcode');

// The callback function that will replace [book]
function custom_registration_shortcode()
{
	ob_start();
	custom_registration_function();
	return ob_get_clean();
}

//add init action to place the function earlier in the wordpress loading
add_action('init', 'custom_registration_shortcode');
