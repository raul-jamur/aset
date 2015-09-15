<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Preferensi_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getPref($pn){
		$q = $this->db->query("SELECT ".$pn." FROM preferensi WHERE pref_id=1");
		$row = $q->row_array();
		$data = $row[$pn];
        $q->free_result();
        return $data;
	}
	
	function getAllPref(){
		$q = $this->db->query("SELECT * FROM preferensi WHERE pref_id=1");
		
		if($q->num_rows()>0){
            foreach ($q->result() as $rows){
            $data[] = $rows;
            }            
        }else{
            $data=0;
        }
        
        $q->free_result();
        return $data;
	}
	
	function update($id,$data){
		$this->db->where('pref_id', $id);
		if($this->db->update('preferensi', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
}