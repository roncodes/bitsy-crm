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
			if(isset($post['new_cat'])){ // Create new category
				$this->load->database();
				$this->db->query("INSERT INTO categories (cat_title, cat_parent) VALUES ('$post[cat_title]', '$post[cat_parent]')");
			} else if(isset($post['new_post'])){ // Create new post
				$this->load->database();
				$q = $this->db->query("INSERT INTO posts (post_title, post_category, post_content) VALUES ('$post[post_title]', '$post[post_category]', '$post[post_content]')");
				if($q){
					$this->data['new_post_success'] = true;
				}
			} else if(isset($post['edit_post'])){ // Edit post
				$this->load->database();
				$q = $this->db->query("UPDATE posts SET post_title = '$post[post_title]', post_category = '$post[post_category]', post_content = '$post[post_content]' WHERE id = '$post[post_id]'");
				if($q){
					$this->data['edit_post_success'] = true;
				}
			} else if(isset($post['new_page'])){ // Create new page
				$this->load->database();
				$page_uri = preg_replace("/[^a-zA-Z_]/", "", strtolower(str_replace(' ', '_', $post['page_title'])));
				$page_full_uri = $this->_get_full_uri($post['page_parent']).$page_uri;
				$q = $this->db->query("INSERT INTO pages (page_title, page_content, page_parent, page_template, page_uri, page_full_uri) VALUES ('$post[page_title]', '$post[page_content]', '$post[page_parent]', '$post[page_template]', '$page_uri', '$page_full_uri')");
				if($q){
					$this->data['new_page_success'] = true;
					$this->data['new_page_link'] = $page_full_uri;
				}
			} else if(isset($post['edit_page'])){ // Edit page
				$this->load->database();
				$q = $this->db->query("UPDATE pages SET page_title = '$post[page_title]', page_category = '$post[page_category]', page_parent = '$post[page_parent]', page_content = '$post[page_content]', page_template = '$post[page_template]' WHERE id = '$post[page_id]'");
				if($q){
					$this->data['edit_page_success'] = true;
				}
			}
		}
	}
	
	public function get_handler($get)
	{
		if(isset($get)){
			if(isset($get['delete_cat'])){ // Delete category
				$this->load->database();
				$this->db->query("DELETE FROM categories WHERE id = '$get[cat_id]'");
			} else if(isset($get['delete_post'])){ // Delete post
				$this->load->database();
				$this->db->query("DELETE FROM posts WHERE id = '$get[post_id]'");
			} else if(isset($get['delete_page'])){ // Delete page
				$this->load->database();
				$this->db->query("DELETE FROM pages WHERE id = '$get[page_id]'");
			} else if(isset($get['delete_user'])){ // Delete user
				$this->load->database();
				$this->db->query("DELETE FROM users WHERE id = '$get[user_id]'");
			} else if(isset($get['search_parents'])){ // Delete user
				$this->load->database();
				$query = $this->db->query("SELECT * FROM pages WHERE page_title like '%$get[q]%' LIMIT 10");
				foreach($query->result() as $row){
					echo "<tr onclick='page_parent(this)' style='cursor:pointer;'><td>".$row->page_title."</td><td>".$row->id."</td></tr>";
				}
				die();
			} else if(isset($get['search_pages'])){ // Delete user
				$this->load->database();
				$query = $this->db->query("SELECT * FROM pages WHERE page_title like '%$get[q]%' LIMIT 10");
				foreach($query->result() as $row){
					echo "<tr onclick='go_to(this)' style='cursor:pointer;'><td>".$row->page_title."</td><td>".$row->id."</td></tr>";
				}
				die();
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
	
	public function users()
	{
		$data['users'] = $this->_get_users();
		$this->display('admin/users', $data);
	}
	
	/*
		Page manager methods 
	*/
	
	public function new_page()
	{
		$data['new_page_success'] = $this->data['new_page_success'];
		$data['new_page_link'] = base_url().$this->data['new_page_link'];
		$data['categories'] = $this->_get_categories();
		$data['templates'] = $this->_get_templates();
		$data['pages'] = $this->_get_pages();
		$this->display('admin/new_page', $data);
	}
	
	public function edit_page()
	{
		$data['edit_page_success'] = $this->data['edit_page_success'];
		$data['page_id'] = $this->uri->segment(4);
		$data['categories'] = $this->_get_categories();
		$data['_page'] = $this->_get_page($this->uri->segment(4));
		$data['templates'] = $this->_get_templates();
		$this->display('admin/edit_page', $data);
	}
	
	public function edit_pages()
	{
		$data['pages'] = $this->_get_pages();
		// Pagination 
		$data['per_page'] = 20;
		$data['page_start'] = $this->uri->segment(3);
		if(count($data['pages'])<$data['per_page']){
			$data['per_page'] = (count($data['pages'])/2);
		}
		$data['num_of_pages'] = (count($data['pages'])/$data['per_page']);
		$this->display('admin/edit_pages', $data);
	}
	
	public function templates()
	{
		$data['templates'] = $this->_get_templates();
		$this->display('admin/templates', $data);
	}
	
	/*
		Posts manager methods 
	*/
	
	public function new_post()
	{
		$data['new_post_success'] = $this->data['new_post_success'];
		$data['categories'] = $this->_get_categories();
		$this->display('admin/new_post', $data);
	}
	
	public function edit_post()
	{
		$data['edit_post_success'] = $this->data['edit_post_success'];
		$data['post_id'] = $this->uri->segment(4);
		$data['categories'] = $this->_get_categories();
		$data['post'] = $this->_get_post($this->uri->segment(4));
		$this->display('admin/edit_post', $data);
	}
	
	public function edit_posts()
	{
		$data['posts'] = $this->_get_posts();
		$this->display('admin/edit_posts', $data);
	}
	
	public function categories()
	{
		$data['categories'] = $this->_get_categories();
		$this->display('admin/categories', $data);
	}
	
	public function display($view, $data=array())
	{
		$data['page'] = $this->uri->segment(2);
		$this->load->view('wrappers/admin_header', $data);
		$this->load->view($view, $data);
		$this->load->view('wrappers/footer', $data);
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
