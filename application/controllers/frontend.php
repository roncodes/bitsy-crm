<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['folder_name'] = 'frontend/';
	}
	
	public function index()
	{
		$this->data['invoices'] = $this->core->get_client_invoices(user_id());
		$this->data['meta_title'] = 'Clients Manager';
	}
}
