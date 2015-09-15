<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Akun_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getDetail($uid){
		$q = $this->db->get_where('user', array('user_id'=>$uid));
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
	
	function checkPass($id, $op){
		$query = $this->db->get_where('user', array('user_id'=>$id, 'password'=>$op));
		$count = $query->num_rows();
		$query->free_result();
		if($count > 0){
			return TRUE;
		}else{
			return FALSE;	
		}
	}
	
	function update($id,$data){
		$this->db->where('user_id', $id);
		if($this->db->update('user', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
}