<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();

		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/tickets/';
	}
	
	public function index()
	{
		$this->data['meta_title'] = 'All Tickets';
	}
	
}