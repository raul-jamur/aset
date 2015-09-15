<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Fasilitas_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function countData(){
		$query = $this->db->get('fasilitas');
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function getData($sidx, $sord, $start, $limit){
		$q = $this->db->query("SELECT * FROM fasilitas ORDER BY $sidx $sord LIMIT $start , $limit");
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
	
	function getDetail($id){
		$q = $this->db->get_where('fasilitas', array('fasilitas_id'=>$id));
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
	
	function checkData($key){
		$query = $this->db->get_where('fasilitas', array('fasilitas_nama'=>$key));
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function delete($ids){
		$rows = explode(',',$ids);
		for($i=0;$i<sizeof($rows);$i++){
			$this->db->delete('fasilitas', array('fasilitas_id' => $rows[$i]));
		}
	}
	
	function update($id,$data){
		$this->db->where('fasilitas_id', $id);
		if($this->db->update('fasilitas', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
	function addNew($data){
		if($this->db->insert('fasilitas',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}