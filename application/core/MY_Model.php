<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model 
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get($record_id)
	{
		$this->db->where('id', $record_id);
		return $this->db->get($this->table)->row();
	}
	
	function get_all()
	{
		return $this->db->get($this->table)->result();
	}
	
	function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	function update($record_id, $data)
	{				
		$this->db->where('id', $record_id);
		$this->db->update($this->table, $data);
		return $record_id;
	}
	
	function delete($record_id)
	{
		$this->db->where('id', $record_id);
		$this->db->delete($this->table, $data);
		return $record_id;
	}
	
	function __destruct()
	{
	
	}
	
}