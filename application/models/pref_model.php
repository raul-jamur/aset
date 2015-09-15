<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Pref_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getPref($pn){
		$q = $this->db->query("SELECT ".$pn." FROM preferensi");
		$row = $q->row_array();
		$data = $row[$pn];
        $q->free_result();
        return $data;
	}
	
}