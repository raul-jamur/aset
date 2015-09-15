<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Ruangan_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function countData(){
		$query = $this->db->get('ruangan');
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function countRuangan($id){
		$this->db->where("gd_id", $id);
		$query = $this->db->get('ruangan');
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function getList($gd_id, $limit=0, $offset=0){
		$this->db->select('ruang_id,ruang_nama,ruang_foto,gd_lantai');
        $this->db->from('ruangan');
		$this->db->where('gd_id', $gd_id);
        $this->db->order_by('gd_lantai asc, ruang_nama asc');
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
	
	function getAllGedung(){
		$this->db->select('gd_id,gd_nama');
        $this->db->from('gedung');
        $this->db->order_by('gd_nama');
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
	
	function getGedung($id){
        $q = $this->db->query("SELECT g.gd_id,g.gd_nama FROM gedung g, ruangan r WHERE g.gd_id=r.gd_id AND r.ruang_id=".$id);
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
	
	function getGdLantai($gd_id){
		$this->db->select('gd_lantai');
        $this->db->from('gedung');
		$this->db->where('gd_id', $gd_id);
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
		$q = $this->db->query("SELECT r.*, g.gd_nama, j.jenisruang_nama FROM ruangan r, gedung g, jenisruang j WHERE g.gd_id=r.gd_id AND j.jenisruang_id=r.jenisruang_id ORDER BY r.$sidx $sord LIMIT $start , $limit");
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
		//$q = $this->db->get_where('ruangan', array('gd_id'=>$id));
		
		$q = $this->db->query("SELECT r.*, g.gd_nama, j.jenisruang_nama FROM ruangan r, gedung g, jenisruang j WHERE g.gd_id=r.gd_id AND j.jenisruang_id=r.jenisruang_id AND r.ruang_id=".$id);
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
	
	function getAllJenisRuang(){
		$q = $this->db->get('jenisruang');
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
	
	function delete($ids){
		$rows = explode(',',$ids);
		for($i=0;$i<sizeof($rows);$i++){
			$this->db->delete('ruangan', array('ruang_id' => $rows[$i]));
		}
	}
	
	function update($id,$data){
		$this->db->where('ruang_id', $id);
		if($this->db->update('ruangan', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
	function addNew($data){
		if($this->db->insert('ruangan',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
		
	function getLastId(){
		$q = $this->db->query("SELECT MAX(gd_id) as last_id FROM ruangan");
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
		$q = $this->db->query("SELECT ruang_foto FROM ruangan WHERE gd_id=".$id);
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
	
	function getJadwalRuangan($rid, $rutin=0, $smt=array()){
		if($rutin){
			$m = date("n");
			$y = date("Y");
			if(($m >= $smt['ganjil_start'] && $m > $smt['genap_end']) || ($m <= $smt['ganjil_end'] && $m < $smt['genap_start'])){
				$smtnow = "=1";
			}elseif($m >= $smt['genap_start'] && $m <= $smt['genap_end']){
				$smtnow = "=2";
			}else{
				$smtnow = "IN(1,2)";
			}
			if($m < $smt['genap_end']){
				$y--;
			}
			
			$q = $this->db->query("SELECT * FROM jadwal WHERE ruang_id=". $rid ." AND jadwal_rutin=1 AND jadwal_smt". $smtnow ." AND jadwal_tahun=". $y ." ORDER BY jadwal_hari, jam_mulai");
		}else{
			$tahun_awal = date("Y");
			$tahun_akhir = $tahun_awal + 1; 
			$q = $this->db->query("SELECT * FROM jadwal WHERE ruang_id=". $rid ." AND jadwal_rutin=0 AND jadwal_mulai>='". $tahun_awal ."-1-1 00:00:00' AND jadwal_selesai<='". $tahun_akhir ."-12-31 00:00:00' ORDER BY jadwal_mulai ASC");
		}
		
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
	
}