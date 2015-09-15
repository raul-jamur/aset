<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Home_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getLast(){
		$q = $this->db->query("SELECT sb_tgl FROM scrollbox WHERE sb_id=1");
		$row = $q->row_array();
		$data = $row['sb_tgl'];
        $q->free_result();
        return $data;
	}
	
	function update($data){
		$this->db->where('sb_id', '1');
		if($this->db->update('scrollbox', $data)){
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
	
	function getJadwal($id, $smt){
		$date = date("Y-m-d H:i:s");
		$year = date("Y");
		$hour = date("H:i:s");
		$day = date("w");
		if($day == "0"){ $day=$day+1; }
		$m = date("n");
		if(($m >= $smt['ganjil_start'] && $m > $smt['genap_end']) || ($m <= $smt['ganjil_end'] && $m < $smt['genap_start'])){
			$smtnow = "=1";
		}elseif($m >= $smt['genap_start'] && $m <= $smt['genap_end']){
			$smtnow = "=2";
		}else{
			$smtnow = " IN(1,2)";
		}
		
		$this->db->select("*");
		$where = "ruang_id = ".$id." AND ((jadwal_hari=".$day." AND jam_mulai<='".$hour."' AND jam_selesai>='".$hour."' AND jadwal_smt".$smtnow." AND jadwal_tahun=".$year.") OR (jadwal_mulai<='".$date."' AND jadwal_selesai>='".$date."'))";
		
		$this->db->where($where);		
		$q = $this->db->get("jadwal");
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