<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preferensi extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth/login');
	   	}else{
			$this->load->model('access_model');
			$izin = $this->access_model->checkAccess($this->session->userdata('role_id'), $this->uri->segment(1));
			if($izin){
				$this->load->model('preferensi_model');
				$this->load->model('preferensi/preferensi_model');
			}else{
				redirect('backpanel');
			}
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Preferensi';
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$data['preferensi'] = $this->preferensi_model->getAllPref();
		$this->load->view('preferensi_view', $data);
	}
	
	function simpan(){
		$id = 1;
		$new['nama_sistem'] = $this->input->post('nama_sistem');
		$new['smt_ganjil_start'] = $this->input->post('smt_ganjil_start');
		$new['smt_ganjil_end'] = $this->input->post('smt_ganjil_end');
		$new['smt_genap_start'] = $this->input->post('smt_genap_start');
		$new['smt_genap_end'] = $this->input->post('smt_genap_end');
		$new['nama_sistem'] = $this->input->post('nama_sistem');
		$new['satuan_luas'] = $this->input->post('satuan_luas');
		$new['scroll_generate'] = $this->input->post('scroll_generate');
		$new['satuan_lantai'] = $this->input->post('satuan_lantai');
		$new['footer_text'] = $this->input->post('footer_text');
		$new['sess_exp'] = $this->input->post('sess_exp');
		
		if($this->preferensi_model->update($id,$new)){
			$this->session->set_flashdata('success', 'Preferensi berhasil diperbaharui');
		}else{
			$this->session->set_flashdata('error', 'Preferensi gagal diperbaharui');
		}
		redirect('preferensi');
	}
	
}

/* End of file preferensi.php */
/* Location: ./application/modules/preferensi/controllers/preferensi.php */