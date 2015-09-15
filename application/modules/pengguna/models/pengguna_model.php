<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Pengguna_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function countData(){
		$query = $this->db->get_where('user', array('user_id <>'=>'1'));
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function getData($sidx, $sord, $start, $limit){
		if($start<=0){$start=0;}
		$q = $this->db->query("SELECT u.*, r.role_nama FROM user u, role r WHERE u.user_id <> 1 AND r.role_id=u.role_id ORDER BY $sidx $sord LIMIT $start , $limit");
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
	
	function getRole(){
		$q = $this->db->get('role');
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
	
	function getUserDetail($uid){
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
	
	function checkUsername($uname){
		$q = $this->db->get_where('user', array('username'=>$uname));
		if($q->num_rows() > 0){
			return false;
		}else{
			return true;	
		}
	}
	
	function delete($ids){
		/*
		if($this->db->delete('user', array('user_id' => $ids))){
			return true;
		}else{
			return false;	
		}
		*/
		$rows = explode(',',$ids);
		for($i=0;$i<sizeof($rows);$i++){
			$this->db->delete('user', array('user_id' => $rows[$i]));
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
	
	function addNew($data){
		if($this->db->insert('user',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}