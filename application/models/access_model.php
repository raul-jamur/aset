<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Access_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function checkAccess($role, $furl){
		$q = $this->db->query('select m.* from module m where m.fitur_id in (select rf.fitur_id from rolefitur rf where rf.role_id='.$role.') and module_nama="'.$furl.'"');
		if($q->num_rows()>0){
			//$r = $q->row_array();
			$data = true;
		}else{
			$data = false;
		}
        $q->free_result();
        return $data;
	}
	
	
}