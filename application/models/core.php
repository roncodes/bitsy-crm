<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_project_group_name($id)
	{
		$group = $this->db->query("SELECT * FROM project_groups WHERE id = $id");
		return $group->row()->name;
	}
	
	function get_project($id)
	{
		$project = $this->db->query("SELECT * FROM projects WHERE id = $id");
		return $project->row();
	}
	
	function get_updates($id, $updates=array())
	{
		$get_updates = $this->db->query("SELECT * FROM project_updates WHERE project_id = $id");
		foreach($get_updates->result() as $row){
			$updates[] = $row;
		}
		return $updates;
	}
	
	function delete_project($id)
	{
		return $this->db->query("DELETE FROM projects WHERE id = $id");
	}
	
	function get_client_name($id)
	{
		$user = $this->db->query("SELECT * FROM meta WHERE user_id = $id");
		return $user->row()->first_name.' '.$user->row()->last_name;
	}
	
	function get_groups($groups=array())
	{
		$get_groups = $this->db->query("SELECT * FROM project_groups");
		foreach($get_groups->result() as $row){
			$groups[] = $row;
		}
		return $groups;
	}
	
	function get_projects($projects=array())
	{
		$get_projects = $this->db->query("SELECT * FROM projects");
		foreach($get_projects->result() as $row){
			$row->client = $this->get_client_name($row->client);
			$row->project_group = $this->get_group_name($row->project_group);
			$projects[] = $row;
		}
		return $projects;
	}
	
	function generate_invoice($post)
	{
		$project = $this->get_project($post['project_id']);
		$client = $this->ion_auth->get_user($project->client);
		$items = mysql_real_escape_string(json_encode($this->parse_invoice_items_to_array($post)));
		$query = $this->db->query("INSERT INTO invoices (invoice_id, client_id, project_id, items, amount_paid, invoice_description) VALUES ('$post[id]', '$client->id', '$post[project_id]', '$items', '$post[amount_paid]', '".mysql_real_escape_string($post['description'])."')");
		if($query){
			return true;
		}
		return false;
	}
	
	function open_invoice($id)
	{
		$invoice = $this->get_invoice($id);
		if(intval($invoice->amount_due)>0){
			$status = 'Unpaid';
		} else {
			$status = 'Paid';
		}
		$query = $this->db->query("UPDATE invoices SET status = '$status' WHERE id = '$id'");
		if($query){
			return true;
		}
		return false;
	}
	
	function close_invoice($id)
	{
		$query = $this->db->query("UPDATE invoices SET status = 'Closed' WHERE id = '$id'");
		if($query){
			return true;
		}
		return false;
	}
	
	function get_invoices($invoices=array())
	{
		$get_invoices = $this->db->query("SELECT * FROM invoices");
		foreach($get_invoices->result() as $row){
			$row->client = $this->ion_auth->get_user($row->client_id);
			$row->items = json_decode($row->items);
			$row->project = $this->core->get_project($row->project_id);
			$row->amount_due = $this->get_amount_due($row);
			$row->tax = $this->get_tax($row);
			$row->total = $this->get_total($row);
			$invoices[] = $row;
		}
		return $invoices;
	}
	
	function get_amount_due($invoice)
	{
		$settings = $this->get_settings();
		$items = $invoice->items;
		$tax = $this->core->calculate_subtotal_from_object($items) * (floatval($settings['tax_percent']) / 100);
		return ($tax + $this->core->calculate_subtotal_from_object($items)) - $invoice->amount_paid;
	}
	
	function get_tax($invoice)
	{
		$settings = $this->get_settings();
		$items = $invoice->items;
		return $this->core->calculate_subtotal_from_object($items) * (floatval($settings['tax_percent']) / 100);
	}
	
	function get_total($invoice)
	{
		$settings = $this->get_settings();
		$items = $invoice->items;
		$tax = $this->core->calculate_subtotal_from_object($items) * (floatval($settings['tax_percent']) / 100);
		return ($tax + $this->core->calculate_subtotal_from_object($items));
	}
	
	function get_invoice($id)
	{
		$get_invoices = $this->db->query("SELECT * FROM invoices WHERE id = $id");
		foreach($get_invoices->result() as $row){
			$row->client = $this->ion_auth->get_user($row->client_id);
			$row->items = json_decode($row->items);
			$row->project = $this->core->get_project($row->project_id);
			$row->amount_due = $this->get_amount_due($row);
			$row->tax = $this->get_tax($row);
			$row->subtotal = $this->get_total($row);
			$invoice = $row;
		}
		return $invoice;
	}
	
	function get_new_amount_due($invoice, $amount_paid)
	{
		$settings = $this->get_settings();
		$items = $invoice->items;
		$tax = $this->core->calculate_subtotal_from_object($items) * (floatval($settings['tax_percent']) / 100);
		return ($tax + $this->core->calculate_subtotal_from_object($items)) - $amount_paid;
	}
	
	function update_invoice($post)
	{
		$invoice = $this->get_invoice($post['invoice_id']);
		if(intval($this->get_new_amount_due($invoice, $post['amount_paid']))>0){
			$status = 'Unpaid';
		} else {
			$status = 'Paid';
		}
		$project = $this->get_project($post['project_id']);
		$client = $this->ion_auth->get_user($project->client);
		$items = mysql_real_escape_string(json_encode($this->parse_invoice_items_to_array($post)));
		$query = $this->db->query("UPDATE invoices SET invoice_id = '$post[id]', items = '$items', amount_paid = '$post[amount_paid]', invoice_description = '".mysql_real_escape_string($post['description'])."', status = '$status' WHERE id = '$post[invoice_id]'");
		if($query){
			return true;
		}
		return false;
	}
	
	function get_group_name($id)
	{
		$group = $this->db->query("SELECT * FROM project_groups WHERE id = $id");
		return $group->row()->name;
	}
	
	function parse_invoice_items_to_array($post, $items = array(), $i = 0)
	{
		$items['count'] = 0;
		foreach($post as $item => $val){
			if(strstr($item, 'item_')){
				if(strstr($item, 'name')){
					$items['name'][] = $val;
				} else if(strstr($item, 'description')){
					$items['description'][] = $val;
				} else if(strstr($item, 'unit_cost')){
					$items['unit_cost'][] = $val;
				} else if(strstr($item, 'quanity')){
					$items['quanity'][] = $val;
					$items['count'] = $items['count']+1;
				}
			}
		}
		return $items;
	}
	
	function calculate_subtotal($items, $subtotals = array())
	{
		for($i=0;$i<$items['count'];$i++){
			$subtotals[] = $items['unit_cost'][$i]*$items['quanity'][$i];
		}
		return array_sum($subtotals);
	}
	
	function calculate_subtotal_from_object($items, $subtotals = array())
	{
		for($i=0;$i<$items->count;$i++){
			$subtotals[] = $items->unit_cost[$i]*$items->quanity[$i];
		}
		return array_sum($subtotals);
	}
	
	function recursive_implode($glue, $pieces)
	{
		foreach( $pieces as $r_pieces ) { 
			if( is_array( $r_pieces ) ) { 
				$retVal[] = $this->recursive_implode($glue, $r_pieces); 
			} else { 
				$retVal[] = $r_pieces; 
			} 
		} 
		return implode($glue, $retVal); 
	}
	
	function get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function valid_csrf_nonce()
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
	
	function get_settings($settings = array())
	{
		$query = $this->db->query("SELECT * FROM settings");
		foreach($query->result() as $row){
			$settings[$row->option_name] = $row->option_value;
		}
		return $settings;
	}
	
}
