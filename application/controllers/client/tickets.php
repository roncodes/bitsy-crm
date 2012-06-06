<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/tickets/';
	}
	
	public function index()
	{
		if(isset($_POST['new_ticket'])){ // Quick and dirty - add a new ticket
			$this->form_validation->set_rules('subject', 'Ticket Subject', 'required|trim|xss_clean');
			$this->form_validation->set_rules('issue', 'Issue Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project', 'Project', 'required');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("INSERT INTO tickets (subject, issue, client, project, date_opened, status) VALUES ('$_POST[subject]', '$_POST[issue]', '".user_id()."', '$_POST[project]', '".date('Y-m-d H:i:s')."', 'Open')");
				if($query){
					$project = $this->core->get_project($_POST['project']);
					flashmsg('New ticket created for project: '.$project->name.'.', 'success');
					redirect('/client/tickets');
				}
			}
		}
		$all_projects = $this->core->get_projects();
		$projects = array('' => 'Select one');
		foreach ($all_projects as $project)
		{
			$projects[$project->id] = $project->name;
		}
		$this->data['projects'] = $projects;
		$this->data['tickets'] = $this->core->get_client_tickets(user_id());
		$this->data['meta_title'] = 'Your Tickets';
	}
	
}