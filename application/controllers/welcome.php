<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}
	
	public function index($data=array())
	{
		if($this->uri->segment(2)){
			$this->load_page($this->uri);
		} else {
			$this->display('welcome_message', $data);
		}
	}
	
	public function load_page($uri, $parent_count=0, $data=null)
	{
		// Do some parent path validation
		$parents = array_reverse(array_merge(array(), $uri->segments));
		if(count($parents)>1){
			for($i=0;$i<count($parents);$i++){
				$page = $this->_get_page_by_uri($parents[$i]);
				if($page){
					if($page->page_parent>0){
						if($this->_get_page_uri_by_id($page->page_parent)==$parents[$i+1]){
							if($i=count($parents)){
								$data['content'] = $page->page_content;
								$data['title'] = $page->page_title;
								$this->load->view('page_templates/'.$page->page_template, $data);
							}
						} else {
							echo "Page does not exist";
							die();
						}
					}
				} else {
					echo "Page does not exist";
					die();
				}
			}
		} else {
			$page = $this->_get_page_by_uri($uri->segment(count($uri->segments)));
			if($page){
				$data['content'] = $page->page_content;
				$data['title'] = $page->page_title;
				$this->load->view('page_templates/'.$page->page_template, $data);
			} else {
				echo "Page does not exist";
				die();
			}
		}
	}
	
	public function display($view, $data)
	{
		$data['page'] = $this->uri->segment(1);
		$this->load->view('wrappers/header', $data);
		$this->load->view($view, $data);
		$this->load->view('wrappers/footer', $data);
	}
	
	private function _get_page_by_uri($uri, $page=null)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM pages WHERE page_uri = '$uri'");
		foreach($query->result() as $row){
			$page = $row;
		}
		return $page;
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
}
