<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();  
		$this->data['folder_name'] = 'cron/';
        $this->load->model('Cron_model');
        if ($this->Cron_model->isCron($_SERVER['REMOTE_ADDR']) == false) { 
         redirect('404', 'location'); }
    }
	
	function generate_recurring_invoices()
	{
		// do code
	}
	
}
