<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backpanel extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('backpanel_model');
			$this->load->model('preferensi/preferensi_model');
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		
		$data['css'] = array('jqueryui','jqplot');
		$data['js'] = array('jquery','jqueryui','jqplot');
		
		$this->load->module('statistik/statistik');
		$statmingguan = $this->statistik->mostused('minggu');
		$statbulanan = $this->statistik->mostused('bulan');
		if($statmingguan){
			$stat1 = explode("||", $statmingguan);
		}else{
			$stat1 = array('[0]','["Tidak Ada Penggunaan"]');
		}
		if($statbulanan){
			$stat2 = explode("||", $statbulanan);
		}else{
			$stat2 = array('[0]','["Tidak Ada Penggunaan"]');
		}
		
		$data['plot1'] = $stat1[0];
		$data['label1'] = $stat1[1];
		$data['plot2'] = $stat2[0];
		$data['label2'] = $stat2[1];
		
		$data['hidenav'] = 1;
		$data['akses'] = $this->backpanel_model->getAkses();
		$this->load->view('backpanel_view', $data);
	}
}

/* End of file backpanel.php */
/* Location: ./application/modules/backpanel/controllers/backpanel.php */