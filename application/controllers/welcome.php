<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['folder_name'] = 'welcome/';
	}
	
	public function index()
	{
		$this->data['meta_title'] = 'Clients Manager';
	}
}
