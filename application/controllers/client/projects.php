<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		check_user_permissions();
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'client/projects/';
	}
	
	public function index()
	{
		$projects = $this->data['projects'] = $this->core->get_client_projects(user_id());
		// pagination
		$this->data['base_pagination'] = base_url('client/projects/page/');
		$this->data['total_rows'] = count($projects);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'Your Projects';
	}
	
	public function page()
	{
		$projects = $this->data['projects'] = $this->core->get_client_projects(user_id());
		// pagination
		$this->data['base_pagination'] = base_url('client/projects/page/');
		$this->data['total_rows'] = count($projects);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'Your Projects';
	}
	
	public function comment($id = NULL)
	{
		$settings = $this->data['settings'] = $this->settings->get_settings();
		$user = $this->data['user'] = $this->ion_auth->get_user(user_id());
		$project = $this->data['project'] = $this->core->get_project($id);
		if($project->client!=$user->id){
			flashmsg('Project does not exist', 'error');
			redirect('client/projects');
		}
		if(isset($_POST['new_update'])){ // Quick and dirty - add a new update
			$this->form_validation->set_rules('title', 'Comment Title', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Comment Description', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("INSERT INTO project_updates (project_id, title, description) VALUES ('$project->id', 'Comment by Client: $_POST[title]', '$_POST[description]')");
				if($query){
					// Send Email
					$email_data['user'] = $user->username;
					$email_data['project_name'] = $project->name;
					foreach($this->core->get_admin_emails() as $email){
						$this->email->from($settings['company_email'], $settings['site_name']);
						$this->email->to($email); 
						$this->email->subject('New Comment on Project');
						$this->email->message($this->load->view('emails/project_comment', $email_data, true));	
						$this->email->send();
					}
					flashmsg('Project Comment added successfully to '.$project->name.'.', 'success');
					redirect('/client/projects/comment/'.$id);
				}
			}
		}
		$this->data['updates'] = $this->core->get_updates($id);
		$this->data['meta_title'] = 'Comment on Project';
	}
	
}