<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'client/invoices/';
	}
	
	public function index()
	{
		$this->data['invoices'] = $this->core->get_invoices();
		$this->data['meta_title'] = 'Your Invoices';
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
	
	public function view($id = NULL)
	{
		$this->data['invoice'] = $this->core->get_invoice($id);
		$this->data['meta_title'] = 'Viewing Invoice #'.$this->data['invoice']->invoice_id;
	}
	
}