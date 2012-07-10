<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_model extends CI_Model
{

    function isCron($ip) { if ($ip == '192.168.1.1') { return true; } else { return false; } }

} 