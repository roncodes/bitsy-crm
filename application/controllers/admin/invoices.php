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
		$this->data['invoices'] = $this->core->get_invoices();
		$this->data['meta_title'] = 'All Invoices';
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
	}
	
	public function download($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
		require_once(APPPATH."third_party/dompdf/dompdf_config.inc.php");
		$html = $this->load->view('/admin/invoices/pdf_view', $this->data, true);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream("invoice_id_".$this->data['invoice']->invoice_id.".pdf");
	}
	
	public function create()
	{
		// do code
	}
	
	public function view($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
	}
	
	public function pdf_view($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
	}
	
}