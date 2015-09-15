<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Gedung_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function countData(){
		$query = $this->db->get('gedung');
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function getList($limit=0, $offset=0){
		$this->db->select('gd_id,gd_nama,gd_foto');
        $this->db->from('gedung');
        $this->db->order_by('gd_nama');
        $this->db->limit($limit,$offset);
        $q = $this->db->get();
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
	
	function getData($sidx, $sord, $start, $limit){
		$q = $this->db->query("SELECT * FROM gedung ORDER BY $sidx $sord LIMIT $start , $limit");
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
		$q = $this->db->get_where('gedung', array('gd_id'=>$id));
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
	
	function getFasilitas($fid){
		$q = $this->db->query("SELECT fasilitas_id, fasilitas_nama FROM fasilitas WHERE fasilitas_id IN ($fid)");
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
	
	function delete($ids){
		$rows = explode(',',$ids);
		for($i=0;$i<sizeof($rows);$i++){
			$this->db->delete('gedung', array('gd_id' => $rows[$i]));
		}
	}
	
	function update($id,$data){
		$this->db->where('gd_id', $id);
		if($this->db->update('gedung', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
	function addNew($data){
		if($this->db->insert('gedung',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function getAllFasilitas(){
		$q = $this->db->get('fasilitas');
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
	
	function getLastId(){
		$q = $this->db->query("SELECT MAX(gd_id) as last_id FROM gedung");
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
	
	function getFotoFile($id){
		$q = $this->db->query("SELECT gd_foto FROM gedung WHERE gd_id=".$id);
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