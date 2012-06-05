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
	return $user->id;
}