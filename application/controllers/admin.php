<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('tank_auth');
		admin_auth_check();
		$this->post_handler($_POST);
		$this->get_handler($_GET);
	}
	
	public function post_handler($post)
	{
		$this->data['new_post_success'] = false;
		$this->data['edit_post_success'] = false;
		$this->data['new_page_success'] = false;
		$this->data['edit_page_success'] = false;
		$this->data['new_page_link'] = '';
		if(isset($post)){
			if(isset($post['new_cat'])){ // Create new client
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->library('security');
				$this->load->library('tank_auth');
				$this->lang->load('tank_auth');
			}
		}
	}
	
	public function get_handler($get)
	{
		if(isset($get)){
			if(isset($get['delete_user'])){ // Delete client
				$this->load->database();
				$this->db->query("DELETE FROM users WHERE id = '$get[user_id]'");
			}
		}
	}
	
	public function index()
	{
		$data['num_pages'] = count($this->_get_pages());
		$data['num_templates'] = count($this->_get_templates());
		$data['num_posts'] = count($this->_get_posts());
		$data['num_categories'] = count($this->_get_categories());
		$this->display('admin/dashboard', $data);
	}
	
	public function clients()
	{
		$data['users'] = $this->_get_users();
		$this->display('admin/clients', $data);
	}
	
	public function new_client()
	{
		$data['new_client_success'] = false;
		$this->display('admin/new_client', $data);
	}
	
	public function display($view, $data=array())
	{
		$data['page'] = $this->uri->segment(2);
		$this->load->view('wrappers/admin_header', $data);
		$this->load->view($view, $data);
		// $this->load->view('wrappers/footer', $data);
	}
	
	/* Data methods */
	
	private function _get_categories($categories=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM categories");
		foreach($query->result() as $row){
			if($row->cat_parent>0){
				$row->parent_title = $this->_get_cat_title($row->cat_parent);
			} else {
				$row->parent_title = "No Parent";
			}
			$categories[] = $row;
		}
		return $categories;
	}
	
	private function _get_cat_title($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM categories WHERE id = '$id'");
		return $query->row()->cat_title;
	}
	
	private function _get_page_title($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM pages WHERE id = '$id'");
		if(count($query->row())>0){
			return $query->row()->page_title;
		} else {
			return "None";
		}
	}
	
	private function _get_posts($posts=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM posts");
		foreach($query->result() as $row){
			if($row->post_category>0){
				$row->post_category_title = $this->_get_cat_title($row->post_category);
			} else {
				$row->post_category_title = "Not Categorized";
			}
			$posts[] = $row;
		}
		return $posts;
	}
	
	private function _get_post($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM posts WHERE id = '$id'");
		foreach($query->result() as $row){
			if($row->post_category>0){
				$row->post_category_title = $this->_get_cat_title($row->post_category);
			} else {
				$row->post_category_title = "Not Categorized";
			}
			$post = $row;
		}
		return $post;
	}
	
	private function _get_templates($templates=array())
	{
		$count = 0;
		foreach(glob("application/views/page_templates/*.php") as $template){
			$template_title = explode('/', $template);
			$template_title = $template_title[count($template_title)-1];
			$templates[$count]['url'] = $template;
			$templates[$count]['title'] = $template_title;
			$templates[$count]['data'] = $this->_get_template_info($template);
			$count++;
		}
		return $templates;
	}
	
	private function _get_template_info($template)
	{
		$temp_file = $template.'.txt';
		copy($template, $temp_file);
		$f = fopen($temp_file, 'r');
		$line = htmlspecialchars(fgets($f));
		fclose($f);
		$line = str_replace('&lt;!--', '', $line);
		$line = str_replace('--&gt;', '', $line);
		$info = explode('|', $line);
		return $info;
	}
	
	private function _get_pages($pages=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM pages");
		foreach($query->result() as $row){
			if($row->page_parent>0){
				$row->page_parent_title = $this->_get_page_title($row->page_parent);
			} else {
				$row->page_parent_title = "No page parent";
			}
			$pages[] = $row;
		}
		return $pages;
	}
	
	private function _get_page($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM pages WHERE id = '$id'");
		foreach($query->result() as $row){
			if($row->page_parent>0){
				$row->page_parent_title = $this->_get_page_title($row->page_parent);
			} else {
				$row->page_parent_title = "No page parent";
			}
			$page = $row;
		}
		return $page;
	}
	
	private function _get_users($users=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users");
		foreach($query->result() as $row){
			$users[] = $row;
		}
		return $users;
	}
	
	private function _get_page_uri_by_id($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM pages WHERE id = '$id'");
		foreach($query->result() as $row){
			$page = $row;
		}
		return $page->page_uri;
	}
	
	private function _get_parent($id)
	{
		$page = $this->_get_page($id);
		if($page->page_parent>0){
			return $page->page_parent;
		}
	}
	
	private function _get_full_uri($parent, $uri="")
	{
		while($this->_get_parent($parent)>0){
			$page = $this->_get_page($parent);
			$uri = $page->page_uri.'/'.$uri;
			$parent = $this->_get_parent($parent);
		}
		$page = $this->_get_page($parent);
		$uri = $page->page_uri.'/'.$uri;
		return $uri;
	}
}
