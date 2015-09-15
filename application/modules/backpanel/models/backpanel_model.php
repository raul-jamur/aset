<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Backpanel_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getItem() {
		$role = $this->session->userdata('role_name');
        $q = $this->db->query("SELECT * FROM function_list WHERE location='dashboard' AND ".$role." = 1");
		if ($q->num_rows()>0){
            foreach ($q->result() as $row){
                $data[] = $row;
            }           
        } else {
            $data = 0;
        }
        $q->free_result();
        return $data;
    }
	
	function getAkses(){
		$rid = $this->session->userdata('role_id');
		$q = $this->db->query("SELECT f.* FROM rolefitur rf, fitur f WHERE f.fitur_id=rf.fitur_id AND rf.role_id=$rid ORDER BY f.fitur_id DESC");
		if ($q->num_rows()>0){
            foreach ($q->result() as $row){
                $data[] = $row;
            }           
        } else {
            $data = 0;
        }
        $q->free_result();
        return $data;
	}
	
}