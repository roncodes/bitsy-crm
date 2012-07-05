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
			$row->client_obj = $this->ion_auth->get_user($row->client);
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
	
	function get_user_invoices($id, $invoices=array())
	{
		$get_invoices = $this->db->query("SELECT * FROM invoices WHERE client_id = $id");
		foreach($get_invoices->result() as $row){
			$row->client = $this->ion_auth->get_user($row->client_id);
			$row->items = json_decode($row->items);
			$row->project = $this->core->get_project($row->project_id);
			$row->amount_due = $this->get_amount_due($row);
			$row->tax = $this->get_tax($row);
			$row->total = $this->get_total($row);
			$row->subtotal = $this->get_total($row);
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
	
	function get_subtotal($invoice)
	{
		$settings = $this->get_settings();
		$items = $invoice->items;
		$tax = $this->core->calculate_subtotal_from_object($items) * (floatval($settings['tax_percent']) / 100);
		return $this->core->calculate_subtotal_from_object($items);
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
			$row->subtotal = $this->get_subtotal($row);
			$invoice = $row;
		}
		return $invoice;
	}
	
	function get_invoice_by_id($id)
	{
		$get_invoices = $this->db->query("SELECT * FROM invoices WHERE invoice_id = '$id'");
		foreach($get_invoices->result() as $row){
			$row->client = $this->ion_auth->get_user($row->client_id);
			$row->items = json_decode($row->items);
			$row->project = $this->core->get_project($row->project_id);
			$row->amount_due = $this->get_amount_due($row);
			$row->tax = $this->get_tax($row);
			$row->subtotal = $this->get_subtotal($row);
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
		if(intval($this->get_new_amount_due($invoice, $post['amount_paid']))>=0){
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
	
	function get_clients($clients = array())
	{
		$users = $this->ion_auth->get_users();
		foreach($users as $user){
			if($user->group_id==2){
				$clients[] = $user;
			}
		}
		return $clients;
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
	
	function calculate_total($items)
	{
		$settings = $this->get_settings();
		$total['tax'] = $this->core->calculate_subtotal($items) * (floatval($settings['tax_percent']) / 100);
		$total['total'] = $total['tax'] + $this->core->calculate_subtotal($items);
		return $total;
	}
	
	function get_client_invoices($id, $client_invoices = array())
	{
		$invoices = $this->get_invoices();
		foreach($invoices as $invoice){
			if($invoice->client->id==$id){
				$client_invoices[] = $invoice;
			}
		}
		return $client_invoices;
	}
	
	function get_recent_client_invoices($id, $client_invoices = array(), $num = 5)
	{
		$get_invoices = $this->db->query("SELECT * FROM invoices ORDER BY id DESC LIMIT $num");
		foreach($get_invoices->result() as $invoice){
			$invoice->client = $this->ion_auth->get_user($invoice->client_id);
			if($invoice->client->id==$id){
				$client_invoices[] = $invoice;
			}
		}
		return $client_invoices;
	}
	
	function get_recent_client_projects($id, $client_projects = array(), $num = 5)
	{
		$get_projects = $this->db->query("SELECT * FROM projects ORDER BY id DESC LIMIT $num");
		foreach($get_projects->result() as $project){
			if($project->client==$id){
				$client_projects[] = $project;
			}
		}
		return $client_projects;
	}
	
	function get_client_projects($id, $client_projects = array())
	{
		$projects = $this->get_projects();
		foreach($projects as $project){
			if($project->client_obj->id==$id){
				$client_projects[] = $project;
			}
		}
		return $client_projects;
	}
	
	function get_client_tickets($id, $tickets = array())
	{
		$get_tickets = $this->db->query("SELECT * FROM tickets WHERE client = '$id' AND reply = 0");
		foreach($get_tickets->result() as $ticket){
			$tickets[] = $ticket;
		}
		return $tickets;
	}
	
	function get_tickets($tickets = array())
	{
		$get_tickets = $this->db->query("SELECT * FROM tickets WHERE reply = 0");
		foreach($get_tickets->result() as $ticket){
			$tickets[] = $ticket;
		}
		return $tickets;
	}
	
	function get_ticket($id)
	{
		return $this->db->query("SELECT * FROM tickets WHERE id = '$id'")->row();
	}
	
	function get_ticket_replies($id, $replies = array())
	{
		$get_replies = $this->db->query("SELECT * FROM tickets WHERE code = '$id' AND reply = 1");
		foreach($get_replies->result() as $reply){
			$replies[] = $reply;
		}
		return $replies;
	}
	
	function close_ticket($id)
	{
		return $this->db->query("UPDATE tickets SET status = 'Closed' WHERE code = '$id'");
	}
	
	function open_ticket($id)
	{
		return $this->db->query("UPDATE tickets SET status = 'Open' WHERE code = '$id'");
	}
	
	function get_gateways($gateways = array())
	{
		$get_gateways = $this->db->query("SELECT * FROM gateways");
		foreach($get_gateways->result() as $row){
			$gateways[$row->name] = $row;
		}
		return $gateways;
	}
	
	function update_gateway($gateway, $data)
	{
		$insert_check = $this->db->query("SELECT * FROM gateways WHERE name = '$gateway'");
		if($insert_check->num_rows()>0){
			$query = $this->db->query("UPDATE gateways SET login = '$data[login]', password = '$data[password]', auth1 = '$data[auth1]', auth2 = '$data[auth2]', url = '$data[url]', active = '$data[active]' WHERE name = '$gateway'");
		} else {
			$query = $this->db->query("INSERT INTO gateways (name, login, password, auth1, auth2, url, active) VALUES ('$gateway', '$data[login]', '$data[password]', '$data[auth1]', '$data[auth2]', '$data[url]', '$data[active]')");
		}
		return $query;
	}
	
	function make_paypal_payment($data)
	{
		$invoice = $this->get_invoice_by_id($data['item_number']);
		$update_invoice = $this->db->query("UPDATE invoices SET amount_paid = '".(intval($data['payment_gross'])+intval($invoice->amount_paid))."' WHERE id = '$invoice->id'");
		if($update_invoice){
			$add_payment = $this->db->query("INSERT INTO payments (gateway, amount, invoice, transaction_id, client) VALUES ('paypal', '$data[payment_gross]', '$invoice->id', '$data[txn_id]', '".user_id()."')");
		}
		$invoice = $this->get_invoice($invoice->id);
		if(intval($invoice->amount_due)>0){
			$status = 'Unpaid';
		} else {
			$status = 'Paid';
		}
		$query = $this->db->query("UPDATE invoices SET status = '$status' WHERE id = '$invoice->id'");
		return $add_payment;
	}
	
	function make_stripe_payment($invoice, $result, $amount)
	{
		$update_invoice = $this->db->query("UPDATE invoices SET amount_paid = '".(intval(str_replace('$', '', $amount))+intval($invoice->amount_paid))."' WHERE id = '$invoice->id'");
		if($update_invoice){
			$add_payment = $this->db->query("INSERT INTO payments (gateway, amount, invoice, transaction_id, client) VALUES ('stripe', '".str_replace('$', '', $amount)."', '$invoice->id', '$result->id', '".user_id()."')");
		}
		$invoice = $this->get_invoice($invoice->id);
		if(intval($invoice->amount_due)>0){
			$status = 'Unpaid';
		} else {
			$status = 'Paid';
		}
		$query = $this->db->query("UPDATE invoices SET status = '$status' WHERE id = '$invoice->id'");
		return $add_payment;
	}
	
	function get_settings_as_objs($settings = array())
	{
		$fetch = $this->db->query("SELECT * FROM settings");
		foreach($fetch->result() as $setting){
			$settings[] = $setting;
		}
		return $settings;
	}
}
