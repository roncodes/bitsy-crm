<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/projects/';
	}
	
	public function index()
	{
		$this->data['projects'] = $this->_get_projects();
		$this->data['meta_title'] = 'All Projects';
	}
	
	public function create()
	{
		if(isset($_POST['new_project'])){ // Quick and dirty - add a new project
			$this->form_validation->set_rules('project_name', 'Project Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_description', 'Project Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_client', 'Project Client', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_quote', 'Project Quote', 'required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('project_group', 'Project Group', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_status', 'Project Status', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("INSERT INTO projects (name, description, client, quote, created, project_group, status) VALUES ('$_POST[project_name]', '$_POST[project_description]', '$_POST[project_client]', '$_POST[project_quote]', '".date('Y-m-d H:i:s')."', '$_POST[project_group]', '$_POST[project_status]')");
				if($query){
					flashmsg('New Project created successfully.', 'success');
					redirect('/admin/projects');
				}
			}
		}
		// Display the create project form
		$all_users = $this->ion_auth->get_users();
		$clients = array('' => 'Select one');
		foreach ($all_users as $user)
		{
			if($user->group_id==2){
				$clients[$user->id] = $user->first_name.' '.$user->last_name;
			}
		}
		$all_groups = $this->_get_groups();
		$groups = array('' => 'Select one');
		foreach ($all_groups as $group)
		{
			$groups[$group->id] = $group->name;
		}
		$this->data['status'] = array('Active' => 'Active', 'Inactive' => 'Inactive', 'Complete' => 'Complete');
		$this->data['clients'] = $clients;
		$this->data['groups'] = $groups;
		$this->data['meta_title'] = 'Create Project';
	}
	
	public function groups()
	{
		if(isset($_POST['new_group'])){ // Quick and dirty - add a new group
			$this->form_validation->set_rules('group_name', 'Group Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('group_description', 'Group Description', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("INSERT INTO project_groups (name, description) VALUES ('$_POST[group_name]', '$_POST[group_description]')");
				if($query){
					flashmsg('Project Group created successfully.', 'success');
					redirect('/admin/projects/groups');
				}
			}
		}
		$this->data['groups'] = $this->_get_groups();
		$this->data['meta_title'] = 'Project Groups';
	}
	
	public function update($id = NULL)
	{
		$project = $this->data['project'] = $this->_get_project($id);
		if(isset($_POST['new_update'])){ // Quick and dirty - add a new update
			$this->form_validation->set_rules('title', 'Update Title', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Update Description', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("INSERT INTO project_updates (project_id, title, description) VALUES ('$project->id', '$_POST[title]', '$_POST[description]')");
				if($query){
					flashmsg('Project Update added successfully to '.$project->name.'.', 'success');
					redirect('/admin/projects');
				}
			}
		}
		$this->data['updates'] = $this->_get_updates($id);
		$this->data['meta_title'] = 'Update Project';
	}
	
	public function invoice($id = NULL)
	{
		$project = $this->data['project'] = $this->_get_project($id);
		$this->data['client'] = $this->ion_auth->get_user($project->client);
		$this->data['meta_title'] = 'Generate Invoice for Project';
	}
	
	public function preview_invoice()
	{
		$project = $this->data['project'] = $this->_get_project($_POST['project_id']);
		$this->data['client'] = $this->ion_auth->get_user($project->client);
		$this->data['invoice_preview'] = $_POST;
	}
	
	public function edit($id = NULL)
	{
		$project = $this->data['project'] = $this->_get_project($id);
		if(isset($_POST['edit_project'])){ // Quick and dirty - edit project
			$this->form_validation->set_rules('project_name', 'Project Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_description', 'Project Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_client', 'Project Client', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_quote', 'Project Quote', 'required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('project_group', 'Project Group', 'required|trim|xss_clean');
			$this->form_validation->set_rules('project_status', 'Project Status', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$query = $this->db->query("UPDATE projects SET name = '$_POST[project_name]', description = '$_POST[project_description]', client = '$_POST[project_client]', quote = '$_POST[project_quote]', project_group = '$_POST[project_group]', status = '$_POST[project_status]' WHERE id = $id");
				if($query){
					flashmsg('Project updated successfully.', 'success');
					redirect('/admin/projects');
				}
			}
		}
		$all_users = $this->ion_auth->get_users();
		$clients = array('' => 'Select one');
		foreach ($all_users as $user)
		{
			if($user->group_id==2){
				$clients[$user->id] = $user->first_name.' '.$user->last_name;
			}
		}
		$all_groups = $this->_get_groups();
		$groups = array('' => 'Select one');
		foreach ($all_groups as $group)
		{
			$groups[$group->id] = $group->name;
		}
		$this->data['status'] = array('Active' => 'Active', 'Inactive' => 'Inactive', 'Complete' => 'Complete');
		$this->data['clients'] = $clients;
		$this->data['groups'] = $groups;
		$this->data['meta_title'] = 'Edit Project';
	}

	public function delete($id = NULL)
	{
		$user = $this->data['project'] = $this->_get_project($id);
		if (empty($id) || empty($user))
		{
			flashmsg('You must specify a project to edit.', 'error');
			redirect('/admin/projects');
		}
		
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'project ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// Do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->_delete_project($id);
				}
				
				// Redirect them back to the admin page
				flashmsg('Project deleted successfully.', 'success');
				redirect('/admin/projects');
			}
			else
			{
				redirect('/admin/projects');
			}
		}
		
		// Insert csrf check
		$this->data['csrf'] = $this->_get_csrf_nonce();
		$this->data['project'] = $this->_get_project($id);
		$this->data['meta_title'] = 'Delete Project';
	}
	
	function _get_groups($groups=array())
	{
		$get_groups = $this->db->query("SELECT * FROM project_groups");
		foreach($get_groups->result() as $row){
			$groups[] = $row;
		}
		return $groups;
	}
	
	function _get_projects($projects=array())
	{
		$get_projects = $this->db->query("SELECT * FROM projects");
		foreach($get_projects->result() as $row){
			$row->client = $this->_get_client_name($row->client);
			$row->project_group = $this->_get_group_name($row->project_group);
			$projects[] = $row;
		}
		return $projects;
	}
	
	function _get_project($id)
	{
		$project = $this->db->query("SELECT * FROM projects WHERE id = $id");
		return $project->row();
	}
	
	function _get_updates($id, $updates=array())
	{
		$get_updates = $this->db->query("SELECT * FROM project_updates WHERE project_id = $id");
		foreach($get_updates->result() as $row){
			$updates[] = $row;
		}
		return $updates;
	}
	
	function _delete_project($id)
	{
		return $this->db->query("DELETE FROM projects WHERE id = $id");
	}
	
	function _get_client_name($id)
	{
		$user = $this->db->query("SELECT * FROM meta WHERE user_id = $id");
		return $user->row()->first_name.' '.$user->row()->last_name;
	}
	
	function _get_group_name($id)
	{
		$group = $this->db->query("SELECT * FROM project_groups WHERE id = $id");
		return $group->row()->name;
	}
	
	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}