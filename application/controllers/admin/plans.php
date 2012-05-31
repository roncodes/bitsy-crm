<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plans extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();
		
		$this->load->library('Stripe', 'stripe');
		
		$this->data['folder_name'] = 'admin/settings/';
	}
	
	public function index()
	{
		$this->data['intervals'] = array('month' => 'month', 'year' => 'year');
		$this->data['plans'] = json_decode($this->stripe->plan_list());
		$this->data['meta_title'] = 'Subscription Plans';
	}
	
	public function create()
	{
		$this->form_validation->set_rules('id', 'ID', 'required|trim|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
		$this->form_validation->set_rules('interval', 'Interval', 'required|trim|xss_clean');
		$this->form_validation->set_rules('trial_period_days', 'Trial period days', 'trim|xss_clean');
		
		if ($this->form_validation->run() === TRUE)
		{
			$amount = (int) $this->input->post('amount') * 100;
			$response = json_decode($this->stripe->plan_create($this->input->post('id'), $amount, $this->input->post('name'), $this->input->post('interval'), $this->input->post('trial_period_days')));
			if (isset($response->error))
			{
				$this->data['create_error'] = $response->error->message;
				$this->index();
				return;
			}
			
			flashmsg('Plan successfully created.', 'success');
			redirect('/admin/plans');
		}
		else
		{
			$this->index();
		}
	}
	
	public function delete()
	{
		$this->form_validation->set_rules('id', 'ID', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() === TRUE)
		{
			$response = json_decode($this->stripe->plan_delete($this->input->post('id')));
			if (isset($response->error))
			{
				$this->data['delete_error'] = $response->error->message;
				$this->index();
				return;
			}
			
			flashmsg('Plan successfully deleted.', 'success');
			redirect('/admin/plans');
		}
		else
		{
			$this->index();
		}
	}
	
}