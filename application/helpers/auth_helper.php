<?php
/* -------------------------------------------------------
Auth Helper by Ronald A. Richardson
---------------------------------------------------------*/


function isValidUser() {
	// returns true of logged in
	$CI =& get_instance();
	$CI->load->library('tank_auth');		
	return $CI->tank_auth->is_logged_in();
}

function isLoggedIn(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');	
	if ($CI->tank_auth->is_logged_in()){
		return true;
	}
	else{
		return false;
	}
}

function isAdminUser(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');
	$user_id = $CI->tank_auth->get_user_id();
	$CI->load->database();
	$query = $CI->db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user = $query->row();
	if($user->role==2){
		return true;
	}
	return false;
}

function getUserID()
{
	$CI =& get_instance();
	$CI->load->library('tank_auth');
	return $CI->session->userdata('DX_user_id');
}

function getUser($id=null) {
	//returns user session data
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/users');	
	$user = $CI->users->get_user_by_id($user_id);	
	return $user->row();
}

function getUserProfile($id=null) {
	//returns user session data
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/user_profile');	
	$user = $CI->user_profile->get_profile($user_id);	
	return $user->row();
}

function getUserFirstName($id=null) {
	//returns user session data
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/user_profile');	
	$user = $CI->user_profile->get_profile($user_id);	
	$profile = $user->row();
	return $profile->first_name;
}


// given a user id, get correct profile 
function getProfile($id=null) {
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/user_profile');	
	$user = getUser($user_id);
	return getUserProfile($user_id);
	
}

function getUserEmail($id=null){
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/users');	
	$user = $CI->users->get_user_by_id($user_id);	
	$user = $user->row();
	return $user->email;
}
function getUserPhone($id=null){
	$CI =& get_instance();
	if (!empty($id)) {
		$user_id = $id;
	} else {
		$user_id= $CI->session->userdata('DX_user_id');
	}
	$CI->load->model('tank_auth/users');	
	$user = $CI->users->get_user_by_id($user_id);	
	$user = $user->row();
	return $user->username;
}


function auth_check(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');		
	if (!$CI->tank_auth->is_logged_in()) { 
		flashmsg('Please Sign In or Sign Up');
		redirect('/signin',"location");
	} 

}

function auth_check_acc(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');		
	if (!$CI->tank_auth->is_logged_in()) { 
		flashmsg('Please Sign or Register');
		redirect('/signin',"location");
	} 

}


function admin_auth_check(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');
	$user_id = $CI->tank_auth->get_user_id();
	$CI->load->database();
	$query = $CI->db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user = $query->row();
	if($user->role==2){
		return true;
	} else {
		redirect('');
	}
}

function admin_auth_check_bool(){
	$CI =& get_instance();
	$CI->load->library('tank_auth');		
	if ($CI->session->userdata('DX_role_name') != "Admin") { 
		return false;
	} 
}