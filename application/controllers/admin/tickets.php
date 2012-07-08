<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->_check_permissions();

		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
		
		$this->data['folder_name'] = 'admin/tickets/';
	}
	
	public function index()
	{
		$tickets = $this->data['tickets'] = $this->core->get_tickets();
		// pagination
		$this->data['base_pagination'] = base_url('admin/tickets/page/');
		$this->data['total_rows'] = count($tickets);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'All Tickets';
	}
	
	public function page()
	{
		$tickets = $this->data['tickets'] = $this->core->get_tickets();
		// pagination
		$this->data['base_pagination'] = base_url('admin/tickets/page/');
		$this->data['total_rows'] = count($tickets);
		$this->data['per_page'] = 10; 
		$this->data['row_start'] = intval($this->uri->segment(4));
		$this->data['links'] = pagination_links($this->data);
		// end pagination
		$this->data['meta_title'] = 'All Tickets';
	}
	
	public function view($id = NULL)
	{
		$settings = $this->data['settings'] = $this->settings->get_settings();
		$user = $this->data['user'] = $this->ion_auth->get_user(user_id());
		$ticket = $this->data['ticket'] = $this->core->get_ticket($id);
		$replies = $this->data['replies'] = $this->core->get_ticket_replies($ticket->code);
		$client = $this->data['client'] = $this->ion_auth->get_user($ticket->client);
		if(isset($_POST['reply'])){ // Quick and dirty - reply
			$this->form_validation->set_rules('reply', 'Reply', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				if(count($replies)==0){
					$subject = $ticket->subject;
				} else {
					$subject = $replies[count($replies)-1]->subject;
				}
				$query = $this->db->query("INSERT INTO tickets (code, subject, issue, client, project, status, reply) VALUES ('$ticket->code', 'RE: $subject', '<b>$user->username (admin) says:</b> ".mysql_real_escape_string($_POST['reply'])."', '$ticket->client', '$ticket->project', 'Open', 1)");
				if($query){
					// Send Email
					$email_data['user'] = $user->username;
					$email_data['reply'] = '<b>'.$user->username.' (admin) says:</b> '.$_POST['reply'];
					$email_data['ticket_id'] = $ticket->ticket_id;
					$email_data['ticket_subject'] = 'RE: '.$subject;
					$this->email->from($settings['company_email'], $settings['site_name']);
					$this->email->to($client->email); 
					$this->email->subject('New Reply On Your Ticket');
					$this->email->message($this->load->view('emails/ticket_reply', $email_data, true));	
					$this->email->send();
					flashmsg('New reply successfully added to ticket', 'success');
					redirect('/admin/tickets/view/'.$id);
				}
			}
		}
	}
	
	public function close($id = NULL)
	{
		if (empty($id))
		{
			flashmsg('You must specify a ticket to close.', 'error');
			redirect('/client/tickets');
		}
		$ticket = $this->data['ticket'] = $this->core->get_ticket($id);
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'ticket ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				$this->core->close_ticket($ticket->code);
				// Redirect them back to the admin page
				flashmsg('Ticket closed successfully.', 'success');
				redirect('/admin/tickets');
			}
			else
			{
				redirect('/admin/tickets');
			}
		}
		$this->data['meta_title'] = 'Close Ticket #'.$this->data['ticket']->code;
	}
	
	public function open($id = NULL)
	{
		if (empty($id))
		{
			flashmsg('You must specify a ticket to re-open.', 'error');
			redirect('/admin/tickets');
		}
		$ticket = $this->data['ticket'] = $this->core->get_ticket($id);
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'ticket ID', 'required|is_natural');

		if ($this->form_validation->run() === TRUE)
		{
			// Do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				$this->core->open_ticket($ticket->code);
				flashmsg('Ticket re-opened successfully.', 'success');
				redirect('/admin/tickets');
			}
			else
			{
				redirect('/admin/tickets');
			}
		}
		$this->data['meta_title'] = 'Re-Open Ticket #'.$this->data['ticket']->code;
	}
	
}