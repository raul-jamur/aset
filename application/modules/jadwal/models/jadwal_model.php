<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Jadwal_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function countData(){
		$query = $this->db->get('jadwal');
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
	
	function getDetail($id){
		$q = $this->db->get_where('jadwal', array('jadwal_id'=>$id));
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
	
	function delete($jid){
		/*$rows = explode(',',$jid);
		for($i=0;$i<sizeof($rows);$i++){
			$this->db->delete('jadwal', array('jadwal_id' => $rows[$i]));
		}*/
		if($this->db->delete('jadwal', array('jadwal_id' => $jid))){
			return true;
		}else{
			return false;
		}
	}
	
	function update($id,$data){
		$this->db->where('jadwal_id', $id);
		if($this->db->update('jadwal', $data)){
			return TRUE;	
		}else{
			return FALSE;	
		}
	}
	
	function addNew($data){
		if($this->db->insert('jadwal',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
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
	
	function getAllRuangan($id){
		$this->db->select('ruang_id,ruang_nama,gd_lantai');
        $this->db->from('ruangan');
        $this->db->order_by('gd_lantai asc, ruang_nama asc');
		$this->db->where('gd_id',$id);
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
	
	function getRuangan($id){
		//$q = $this->db->get_where('ruangan', array('gd_id'=>$id));
		if($id){
			$q = $this->db->query("SELECT r.*, g.gd_nama, j.jenisruang_nama FROM ruangan r, gedung g, jenisruang j WHERE g.gd_id=r.gd_id AND j.jenisruang_id=r.jenisruang_id AND r.ruang_id=".$id);
			if ($q->num_rows()>0){
				foreach ($q->result() as $row){
					$data[] = $row;
				}           
			} else {
				$data = 0;
			}
			$q->free_result();
		}else{
			$data = 0;
		}
        return $data;
	}
	
	function getJadwalRuangan($rid, $rutin=0, $start, $end, $smt=array()){
		$start = date("Y-m-d H:i:s", $start);
		$end = date("Y-m-d H:i:s", $end);
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
			
			$q = $this->db->query("SELECT * FROM jadwal WHERE ruang_id=". $rid ." AND jadwal_rutin=1 AND jadwal_smt". $smtnow ." AND jadwal_tahun=". $y);
		}else{
			$q = $this->db->query("SELECT * FROM jadwal WHERE ruang_id=". $rid ." AND jadwal_rutin=0 AND jadwal_mulai >= '". $start ."' AND jadwal_selesai < '". $end ."'");
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
	
	function getListJadwalRuangan($rid, $rutin=0, $smt=array()){
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
			$q = $this->db->query("SELECT * FROM jadwal WHERE ruang_id=". $rid ." AND jadwal_rutin=0 AND (
			(jadwal_mulai<='". $tahun_awal ."-01-01 00:00:00' AND jadwal_selesai>='". $tahun_awal ."-01-01 00:00:00') OR 
			(jadwal_mulai>='". $tahun_awal ."-01-01 00:00:00' AND jadwal_selesai<='". $tahun_awal ."-12-31 00:00:00') OR 
			(jadwal_mulai<='". $tahun_awal ."-12-31 00:00:00' AND jadwal_selesai>='". $tahun_awal ."-12-31 00:00:00')
			) ORDER BY jadwal_mulai ASC");
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
	
	function cekJadwal($id, $data, $mulai, $selesai){
		$this->db->select("jadwal_id");
		$where = 'jadwal_id <> '.$id.' AND ';
		
		if($data['jadwal_rutin']){
			$where .= "ruang_id=".$data['ruang_id']." AND jadwal_hari=".$data['jadwal_hari']." AND jadwal_smt=".$data['jadwal_smt']." AND jadwal_tahun=".$data['jadwal_tahun']." AND";
			$where .= " ((jam_mulai < '".$data['jam_mulai'].":00' AND jam_selesai >'".$data['jam_mulai'].":00') OR";
			$where .= " (jam_mulai < '".$data['jam_selesai'].":00' AND jam_selesai >'".$data['jam_selesai'].":00') OR";
			$where .= " (jam_mulai < '".$data['jam_mulai'].":00' AND jam_selesai >'".$data['jam_selesai'].":00') OR";
			$where .= " (jam_mulai = '".$data['jam_mulai'].":00' AND jam_selesai ='".$data['jam_selesai'].":00') OR";
			
			$where .= " (jam_mulai < '".$data['jam_selesai'].":00' AND jam_selesai >'".$data['jam_mulai'].":00') OR";
			$where .= " (jam_mulai > '".$data['jam_mulai'].":00' AND jam_mulai <'".$data['jam_selesai'].":00') OR";
			$where .= " (jam_mulai >'".$data['jam_mulai'].":00' AND jam_selesai <'".$data['jam_selesai'].":00') OR";
			$where .= " (jam_mulai < '".$data['jam_selesai'].":00' AND jam_selesai >'".$data['jam_mulai'].":00'))";
			
		}else{
			$where .= "ruang_id=".$data['ruang_id']." AND";
			$where .= " ((jadwal_mulai <'".$mulai."' AND jadwal_selesai >'".$mulai."') OR";
			$where .= " (jadwal_mulai <'".$selesai."' AND jadwal_selesai >'".$selesai."') OR";
			$where .= " (jadwal_mulai <'".$mulai."' AND jadwal_selesai >'".$selesai."') OR";
			$where .= " (jadwal_mulai ='".$mulai."' AND jadwal_selesai ='".$selesai."') OR";
			
			$where .= " (jadwal_mulai <'".$selesai."' AND jadwal_selesai >'".$mulai."') OR";
			$where .= " (jadwal_mulai >'".$mulai."' AND jadwal_mulai <'".$selesai."') OR";
			$where .= " (jadwal_mulai >'".$mulai."' AND jadwal_selesai <'".$selesai."') OR";
			$where .= " (jadwal_mulai <'".$selesai."' AND jadwal_selesai >'".$mulai."'))";
		}
		//$where .= " AND jadwal_id <> $id";
		$this->db->where($where);
		
		$query = $this->db->get("jadwal");
		$count = $query->num_rows();
		$query->free_result();
		return $count;
	}
	
	function rollbackScrollTime(){
		$q = $this->db->query("SELECT sb_tgl FROM scrollbox WHERE sb_id=1");
		$row = $q->row_array();
		$waktu = $row['sb_tgl'];
		$q->free_result();
		
		$q = $this->db->query("SELECT scroll_generate FROM preferensi WHERE pref_id=1");
		$row = $q->row_array();
		$jeda = $row['scroll_generate'] * 60;
		$q->free_result();
		
		$new['sb_tgl'] = $waktu - $jeda;
		$this->db->where('sb_id', '1');
		$this->db->update('scrollbox', $new);
	}
	
}