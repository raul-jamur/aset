<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Statistik_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function getMostUsed($mulai, $selesai, $tahun, $tahun2, $smt, $mode, $limit){
		if(!$mode){ $mode = "all"; }
		$bulan = date("n");
		
		if($limit){ $limit = " LIMIT ".$limit." "; }else{ $limit = ""; }
		$query = "SELECT count(j.jadwal_id) as kegiatan, r.ruang_id, r.ruang_nama FROM jadwal j
				RIGHT JOIN `ruangan` r
				ON j.ruang_id=r.ruang_id
				WHERE
				(
					j.jadwal_rutin=0 
					AND
					(
						(
							j.jadwal_mulai >= '".$mulai."'  
							AND
							j.jadwal_mulai <= '".$selesai."'
						)
						OR
						(
							j.jadwal_selesai >= '".$mulai."'  
							AND
							j.jadwal_selesai <= '".$selesai."' 
						)
					)
				)
				OR
				(
					j.jadwal_rutin = 1 
					AND
					j.jadwal_tahun = ".$tahun2." 
					AND
					j.jadwal_smt = ".$smt."
				)
				GROUP BY r.ruang_id
				ORDER BY kegiatan DESC, r.ruang_nama ASC";
		$query .= $limit;
		$q = $this->db->query($query);
		if($q->num_rows()>0){
			$data = array();
            foreach ($q->result() as $rows){
            	if($mode == "all"){
					$data[] = $rows;
				}else{
					array_push($data, $rows->ruang_id);
				}
				
            }            
        }else{
            $data = NULL;
        }
        
        $q->free_result();
        return $data;
	}
	
	function getUnused($id){
		if($id){
			$q = $this->db->query("SELECT ruang_id, ruang_nama FROM ruangan WHERE ruang_id NOT IN (".$id.")");
		}else{
			$q = $this->db->query("SELECT ruang_id, ruang_nama FROM ruangan WHERE ruang_id");
		}
			if($q->num_rows()>0){
				$data = array();
				foreach ($q->result() as $rows){
					$data[] = $rows;
				}            
			}else{
				$data = NULL;
			}
			
			$q->free_result();
		
        return $data;
	}
	
}