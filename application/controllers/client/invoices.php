<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		check_user_permissions();
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		$this->data['folder_name'] = 'client/invoices/';
		$this->load->library('paypal_lib');
	}
	
	public function index()
	{
		$invoices = $this->data['invoices'] = $this->core->get_user_invoices(user_id());
		// pagination
		$this->data['base_pagination'] = base_url('client/invoices/page/');
		$this->data['total_rows'] = count($invoices);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'Your Invoices';
	}
	
	public function page()
	{
		$invoices = $this->data['invoices'] = $this->core->get_user_invoices(user_id());
		// pagination
		$this->data['base_pagination'] = base_url('client/invoices/page/');
		$this->data['total_rows'] = count($invoices);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
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
	
	public function pay($id = NULL)
	{
		if($id==NULL){
			flashmsg('You must select an invoice to make a payment', 'error');
			redirect('client/invoices');
		}
		$user = $this->data['user'] = $this->ion_auth->get_user(user_id());
		$gateways = $this->data['gateways'] = $this->core->get_gateways();
		$invoice = $this->data['invoice'] = $this->core->get_invoice($id);
		if($invoice->client_id!=$user->id){
			flashmsg('Invoice does not exist', 'error');
			redirect('client/invoices');
		}
		if(isset($_POST['submit'])){
			if(!isset($_POST['gateway'])){
				flashmsg('You must select a gateway to make a payment with', 'error');
				redirect('client/invoices/pay/'.$id);
			}
			if($_POST['gateway']=='paypal'){
				if(intval(str_replace('$', '', $_POST['amount']))>intval(str_replace('$', '', $invoice->amount_due))){
					flashmsg('You cannot make a payment for more than the amount due', 'error');
					redirect('client/invoices/pay/'.$id);
				}
				$this->paypal_lib->add_field('business', $gateways['paypal']->login);
				$this->paypal_lib->add_field('return', site_url('client/invoices/success/paypal'));
				$this->paypal_lib->add_field('cancel_return', site_url('client/invoices/cancel/paypal'));
				$this->paypal_lib->add_field('notify_url', site_url('client/invoices/ipn/paypal'));
				$this->paypal_lib->add_field('item_name', $invoice->invoice_description);
				$this->paypal_lib->add_field('item_number', $invoice->invoice_id);
				$this->paypal_lib->add_field('amount', $_POST['amount']);
				$this->paypal_lib->button('Confirm & Pay!');
				$this->data['paypal_form'] = $this->paypal_lib->paypal_form('paypal_form');
			} else if($_POST['gateway']=='stripe'){
				require_once APPPATH.'libraries/Stripe.php';
				$config['stripe_key_test_public'] = 'pk_OyHpP2uvEQIInEC6ghAvIg9dexjne';
				$config['stripe_key_test_secret'] = 'xuRKxPH0GLEU6VwEeqI5L3VFiayQiiiA';
				$config['stripe_key_live_public'] = $gateways['stripe']->auth2;
				$config['stripe_key_live_secret'] = $gateways['stripe']->auth1;
				$config['stripe_verify_ssl'] = false;
				$config['stripe_test_mode'] = TRUE;
				$stripe = new Stripe($config);
				if(isset($_POST['stripe_charge'])){
					$charge = $stripe->charge_card((intval(str_replace('$', '', $_POST['amount']))*100), array('number' => $_POST['number'], 'exp_month' => $_POST['exp_month'], 'exp_year' => $_POST['exp_year'], 'cvc' => $_POST['cvc'], 'name' => $user->first_name.' '.$user->last_name), $invoice->invoice_description);
					$result = json_decode($charge);
					if(!$result->error){
						$this->core->make_stripe_payment($invoice, $result, $_POST['amount']);
						flashmsg('Your payment of <b>'.$_POST['amount'].'</b> to invoice #'.$invoice->invoice_id.' has been successfully processed via Stripe', 'success');
						redirect('client/invoices');
					} else {
						flashmsg($result->error->message, 'error');
						redirect('client/invoices/pay/'.$id);
					}
				} else {
					$this->data['stripe_form'] = true;
				}
			}
		}
		$this->data['meta_title'] = 'Make Payment on Invoice #'.$this->data['invoice']->invoice_id;
	}
	
	public function cancel($gateway = NULL)
	{
		// do code
		$this->data['meta_title'] = 'Cancel invoice payment';
	}
	
	public function success($gateway = NULL)
	{
		if($gateway=='paypal'){
			$this->core->make_paypal_payment($_REQUEST);
		}
		$this->data['gateway'] = $gateway;
		$this->data['meta_title'] = 'Successful invoice payment';
	}
	
	public function ipn($gateway = NULL)
	{
		if($gateway=='paypal'){
			$this->core->make_paypal_payment($_REQUEST);
		}
	}
	
}