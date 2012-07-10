<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->uri->segment(3)!='download'){
			$this->_check_permissions();
		}
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/invoices/';
	}
	
	public function index()
	{
		$invoices = $this->data['invoices'] = $this->core->get_invoices();
		// pagination
		$this->load->library('pagination');
		$this->data['base_pagination'] = $config['base_url'] = base_url('admin/invoices/page/');
		$this->data['total_rows'] = $config['total_rows'] = count($invoices);
		$this->data['per_page'] = $config['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'All Invoices';
	}
	
	public function page()
	{
		$invoices = $this->data['invoices'] = $this->core->get_invoices();
		// pagination
		$this->load->library('pagination');
		$this->data['base_pagination'] = $config['base_url'] = base_url('admin/invoices/page/');
		$this->data['total_rows'] = $config['total_rows'] = count($invoices);
		$this->data['per_page'] = $config['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'All Projects';
	}
	
	public function open($id = NULL)
	{
		if (empty($id))
		{
			flashmsg('You must specify a invoice to open.', 'error');
			redirect('/admin/invoices');
		}
		
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'invoice ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->core->open_invoice($id);
				}
				
				// Redirect them back to the admin page
				flashmsg('Invoice re-opened successfully.', 'success');
				redirect('/admin/invoices');
			}
			else
			{
				redirect('/admin/invoices');
			}
		}
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['meta_title'] = 'Re-Open Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function close($id = NULL)
	{
		if (empty($id))
		{
			flashmsg('You must specify a invoice to close.', 'error');
			redirect('/admin/invoices');
		}
		
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'invoice ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{

				// Do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->core->close_invoice($id);
				}
				
				// Redirect them back to the admin page
				flashmsg('Invoice closed successfully.', 'success');
				redirect('/admin/invoices');
			}
			else
			{
				redirect('/admin/invoices');
			}
		}
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['meta_title'] = 'Close Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function edit($id = NULL)
	{
		if(isset($_POST['edit_invoice'])){
			$this->form_validation->set_rules('id', 'Invoice ID', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('description', 'Invoice Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'trim|xss_clean|decimal');
			if ($this->form_validation->run() == TRUE)
			{
				$gen = $this->core->update_invoice($_POST);
				if($gen){
					flashmsg('Invoice updated successfully.', 'success');
					redirect('/admin/invoices');
				}
			}
		}
		$this->data['invoice_id'] = $id;
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['meta_title'] = 'Edit Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function download($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
		require_once(APPPATH."third_party/dompdf/dompdf_config.inc.php");
		$html = $this->load->view('/ajax/pdf_view', $this->data, true);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream("invoice_id_".$this->data['invoice']->invoice_id.".pdf");
		$this->data['meta_title'] = 'Download Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function create()
	{
		if(isset($_POST['new_invoice'])){
			$this->form_validation->set_rules('client', 'Client', 'required');
			$this->form_validation->set_rules('project_id', 'Project', 'required');
			$this->form_validation->set_rules('id', 'Invoice ID', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('description', 'Invoice Description', 'required|trim|xss_clean');
			$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'trim|xss_clean|decimal');
			if(isset($_POST['recurring'])){ if(intval($_POST['recurring'])){
				$this->form_validation->set_rules('recur_length', 'Recur Length', 'trim|xss_clean|less_than[31]|max_length[2]|is_natural_no_zero|required');
			}}
			if(isset($_POST['custom_date'])){ if(intval($_POST['custom_date'])){
				$this->form_validation->set_rules('date', 'Date', 'required|callback_is_valid_date');
			}}
			if ($this->form_validation->run() == TRUE)
			{
				$gen = $this->core->generate_invoice($_POST);
				if($gen){
					$project = $this->core->get_project($_POST['project_id']);
					$settings = $this->data['settings'] = $this->settings->get_settings();
					$client = $this->ion_auth->get_user($project->client);
					// Send Email
					$email_data['project_name'] = $project->name;
					$email_data['invoice_amount'] = $this->core->calculate_total($this->core->parse_invoice_items_to_array($_POST));
					$this->email->from($settings['company_email'], $settings['site_name']);
					$this->email->to($client->email); 
					$this->email->subject('New Invoice Billed To You');
					$this->email->message($this->load->view('emails/new_invoice', $email_data, true));	
					$this->email->send();
					flashmsg('Invoice created successfully.', 'success');
					redirect('/admin/invoices');
				}
			}
		}
		$all_clients = $this->core->get_clients();
		$clients = array('' => 'Select one');
		foreach ($all_clients as $client)
		{
			$clients[$client->id] = $client->first_name.' '.$client->last_name;
		}
		$this->data['clients'] = $clients;
		$this->data['meta_title'] = 'Create new Invoice';
	}
	
	public function is_valid_date($str)
	{
		if(substr_count($str, '/')==2){
			list($mm,$dd,$yyyy) = explode('/',$str);
		} else {
			$this->form_validation->set_message('is_valid_date', 'The date entered is not of valid format (MM/DD/YYYY)');
			return false;
		}
		if (checkdate($mm,$dd,$yyyy)) {
			return true;
		}
		$this->form_validation->set_message('is_valid_date', 'The date entered is not of valid format (MM/DD/YYYY)');
		return false;
	}
	
	public function view($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['meta_title'] = 'Viewing Invoice #'.$this->data['invoice']->invoice_id;
	}
	
}