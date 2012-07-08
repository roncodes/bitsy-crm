<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gateways extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();

		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/gateways/';
	}
	
	public function index()
	{
		if(isset($_POST['update_gateway'])){
			if($this->core->update_gateway(strtolower($_POST['gateway']), $_POST)){
				flashmsg($_POST['gateway'].' gateway settings have been updated successfully.', 'success');
				redirect('/admin/gateways');
			} else {
				flashmsg('Payment gateway failed to be updated, try again.', 'error');
				redirect('/admin/gateways');
			}
		}
		$this->data['gateways'] = $this->core->get_gateways();
		$this->data['meta_title'] = 'Manage Gateways';
	}
	
}