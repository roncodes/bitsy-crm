<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['folder_name'] = 'ajax/';
	}
	
	public function index()
	{
		// do nothing
	}
	
	public function pdf_view($id = NULL)
	{
		// Not really an ajax function but uses ajax layout
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['display_head'] = false;
		$this->data['meta_title'] = 'PDF View of Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function preview_invoice()
	{
		$this->_check_permissions(); // Admin ajax function
		$project = $this->data['project'] = $this->core->get_project($_POST['project_id']);
		$this->data['client'] = $this->ion_auth->get_user($project->client);
		$this->data['invoice_preview'] = $_POST;
		$this->data['items'] = $this->core->parse_invoice_items_to_array($_POST);
		$this->data['subtotal'] = $this->core->calculate_subtotal($this->core->parse_invoice_items_to_array($_POST));
		$this->data['total'] = $this->core->calculate_total($this->core->parse_invoice_items_to_array($_POST));
		$this->data['display_head'] = true;
	}
	
	public function get_clients_projects($client_id = NULL, $client_projects = array())
	{
		$this->view = false;
		$projects = $this->core->get_projects();
		foreach($projects as $project){
			if($project->client_obj->id==$client_id){
				$client_projects[] = $project;
			}
		}
		echo json_encode($client_projects);
		return $client_projects;
	}
	
}
