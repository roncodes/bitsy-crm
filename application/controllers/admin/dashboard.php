<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();
		
		$this->data['folder_name'] = 'admin/dashboard';
	}
	
	public function index()
	{
		$this->data['monthly_income'] = $this->core->get_monthly_income(date('m'));
		$this->data['meta_title'] = 'Admin Dashboard';
	}
	
}