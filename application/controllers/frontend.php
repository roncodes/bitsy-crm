<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['folder_name'] = 'frontend/';
	}
	
	public function index()
	{
		$this->data['meta_title'] = 'Clients Manager';
	}
}
