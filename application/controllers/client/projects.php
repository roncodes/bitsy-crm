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
		$this->data['projects'] = $this->core->get_client_projects(user_id());
		$this->data['meta_title'] = 'Your Projects';
	}
	
	public function comment($id = NULL)
	{
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
					flashmsg('Project Comment added successfully to '.$project->name.'.', 'success');
					redirect('/client/projects/comment/'.$id);
				}
			}
		}
		$this->data['updates'] = $this->core->get_updates($id);
		$this->data['meta_title'] = 'Comment on Project';
	}
	
}