<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistik extends MX_Controller {
	
	function __construct()
	{
       parent::__construct();

	   if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('statistik_model');
			$this->load->model('preferensi/preferensi_model');
		}
	}
	
	function index()
	{
        //redirect("backpanel");
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Statistik mingguan';
		$data['css'] = array('jqueryui','jqplot');
		$data['js'] = array('jquery','jqueryui','jqplot');
		$stat = explode("||", $this->mostused("minggu"));
		$data['plot'] = $stat[0];
		$data['label'] = $stat[1];
		$this->load->view('statistik_mostused_view', $data);
	}
	
	function _mostusedlimited($jangka, $mode, $limit){
		$smtnow = 1;
		$tahun = date("Y");	
		$tahun2 = $tahun;
		
		$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
		$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
		$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
		$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
		
		$bulan = $this->uri->segment(4);
		if(! $bulan || $bulan > 12 || $bulan < 1){
			$bulan = date("n");
		}
	
		if(($bulan >= $smt['ganjil_start'] && $bulan > $smt['genap_end']) || ($bulan <= $smt['ganjil_end'] && $bulan < $smt['genap_start'])){
			$smtnow = "1";
		}elseif($bulan >= $smt['genap_start'] && $bulan <= $smt['genap_end']){
			$smtnow = "2";
		}
		
		if($bulan < $smt['genap_end']){
			$tahun2 = $tahun - 1;
		}
		
		if($jangka == "bulan"){
			
			$mulai = $tahun."-".$bulan."-01 00:00:00";
			$jmlhr = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			$selesai = $tahun."-".$bulan."-".$jmlhr." 23:59:59";
			
		}elseif($jangka == "minggu"){
			$mulai = date("Y-m-d H:i:s",strtotime('last monday'));
			$selesai = date("Y-m-d",strtotime('next sunday'))." 23:59:59";
		}else{
			redirect("backpanel");
		}
		
		$ruangan = $this->statistik_model->getMostUsed($mulai, $selesai, $tahun, $tahun2, $smtnow, $mode, $limit);
		
		return $ruangan;
		//echo $mulai.'|'.$selesai.'|'.$tahun.'|'.$smtnow.'|'.$mode.'|'.$limit.'<br/>';
	}
	
	function mostused($jangka){
		//$jangka = $this->uri->segment(3);
		if($jangka != "bulan"){
			$jangka = "minggu";
		}
		$ruangan = $this->_mostusedlimited($jangka, 'all', 5);
		if($ruangan){
			$k = array();
			$r = array();
			foreach($ruangan as $row){
				array_push($k, $row->kegiatan);
				array_push($r, '"'.$row->ruang_nama.'"');
			}

			return "[". implode(",",$k) ."]||[". implode(",",$r) ."]";
		}else{
			return false;
		}
	}
	
	function unused($jangka, $mode, $limit){
		$used = '0';
		$ruangan = $this->_mostusedlimited($jangka, $mode, $limit);
		
		if($ruangan){
			$used = implode(",",$ruangan);
		}
		
		$unused = $this->statistik_model->getUnused($used);
			
		return $unused;
	}
	
	function penggunaan(){
		$jangka = $this->uri->segment(3);
		$data['pagetitle'] = 'Ruangan dengan Penggunaan Terbanyak Bulan Ini';
		if($jangka != "bulan"){
			$jangka = "minggu";
			$data['pagetitle'] = 'Ruangan dengan Penggunaan Terbanyak Minggu Ini';
		}
		$data['used'] = $this->_mostusedlimited($jangka, 'all', 0);
		//if($data['used']){
			$data['unused'] = $this->unused($jangka, 'id', 0);
		//}else{
			//$this->session->set_flashdata('error', 'Data tidak ditemukan');
		//}
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$this->load->view('statistik_penggunaan_view', $data);
	}
}

/* End of file statistik.php */
/* Location: ./application/modules/statistik/controllers/statistik.php */