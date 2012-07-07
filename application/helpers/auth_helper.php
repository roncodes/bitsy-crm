<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function logged_in()
{
	$CI =& get_instance();
	return $CI->ion_auth->logged_in();
}

function is_admin()
{
	$CI =& get_instance();
	return $CI->ion_auth->is_admin();
}

function user_id()
{
	$CI =& get_instance();
	$user = $CI->ion_auth->get_user();
	if(isset($user->id)){
		return $user->id;
	} else {
		return false;
	}
}

function check_user_permissions()
{
	if(logged_in()){
		return true;
	} else {
		flashmsg('You must be logged in to access this', 'error');
		redirect('auth/login');
	}
}

function admin_auth_check()
{
	if(!is_admin()){
		flashmsg('You must be admin to access this', 'error');
		redirect('auth/login');
	}
}