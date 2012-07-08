<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['folder_name'] = 'frontend/';
	}
	
	public function index()
	{
		$this->data['invoices'] = $this->core->get_recent_client_invoices(user_id());
		$this->data['projects'] = $this->core->get_recent_client_projects(user_id());
		$this->data['user'] = $this->ion_auth->get_user(user_id());
		$this->data['meta_title'] = 'Clients Manager';
	}
}
