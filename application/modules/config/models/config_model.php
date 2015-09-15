<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Config_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getConfiguration(){
		$q = $this->db->query("SELECT * FROM function_list WHERE function_name <> 'Configuration'");
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
	
	function save($id,$data){
		$this->db->where('id', $id);
		if($this->db->update('function_list', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}