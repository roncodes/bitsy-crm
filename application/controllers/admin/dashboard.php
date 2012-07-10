<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();
		
		$this->data['folder_name'] = 'admin/dashboard';
	}
	
	public function index()
	{
		if(isset($_POST['run_cron'])){
			$output = shell_exec('crontab -l');
			file_put_contents('tmp/crontab.txt', $output.'0 */24 * * * php -q index.php cron generate_recurring_invoices'.PHP_EOL);
			echo exec('crontab tmp/crontab.txt');
			flashmsg('Cron has been ran successfully.', 'success');
		}
		$this->data['monthly_income'] = $this->core->get_monthly_income(date('m'));
		$this->data['meta_title'] = 'Admin Dashboard';
	}
	
}