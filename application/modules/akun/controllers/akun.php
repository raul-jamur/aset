<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('akun_model');
			$this->load->model('preferensi/preferensi_model');
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Ubah Password';
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$data['user'] = $this->akun_model->getDetail($this->session->userdata('user_id'));
		$this->load->view('akun_view', $data);
	}
	
	function profil(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Profil';
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$data['user'] = $this->akun_model->getDetail($this->session->userdata('user_id'));
		$this->load->view('profil_view', $data);
	}
	
	function update(){
		$id = $this->session->userdata('user_id');
		if($this->input->post('oldpassword') != NULL){
			$oldpass = sha1($this->input->post('oldpassword'));
			if($this->akun_model->checkPass($id,$oldpass)){
				$new['password'] = sha1($this->input->post('password'));
				if($this->akun_model->update($id,$new)){
					$this->session->set_flashdata('success', 'Data tersimpan');
				}else{
					$this->session->set_flashdata('error', 'Data tidak tersimpan');
				}
			}else{
				$this->session->set_flashdata('error', 'Password lama salah! password baru tidak tersimpan.');
			}
		}
		redirect('akun');
	}
	
	function updateprofil(){
		$id = $this->session->userdata('user_id');
		$new['nama'] = $this->input->post('nama');
		$new['kontak'] = $this->input->post('kontak');
		$new['email'] = $this->input->post('email');		
		if($this->akun_model->update($id,$new)){
			$this->session->set_flashdata('success', 'Data tersimpan');
		}else{
			$this->session->set_flashdata('error', 'Data tidak tersimpan');
		}
		redirect('akun/profil');
	}
	
	function checkoldpass(){
		$id = $this->session->userdata('user_id');
		$oldpass = sha1($this->input->post('op'));
		$check = $this->akun_model->checkPass($id, $oldpass);
		if($check){
			echo 'correct';
		}else{
			echo 'wrong';	
		}
	}
}

/* End of file akun.php */
/* Location: ./application/modules/akun/controllers/akun.php */