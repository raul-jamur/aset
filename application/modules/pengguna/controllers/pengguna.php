<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth/login');
	   	}else{
			$this->load->model('access_model');
			$izin = $this->access_model->checkAccess($this->session->userdata('role_id'), $this->uri->segment(1));
			if($izin){
				$this->load->model('pengguna_model');
				$this->load->model('preferensi/preferensi_model');
			}else{
				redirect('backpanel');
			}
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Daftar Pengguna';
		$data['css'] = array('jqueryui','jqgrid');
		$data['js'] = array('jquery','jqueryui','jqgrid');
		$this->load->view('pengguna_view', $data);
	}
	
	function listing(){
		$page = $this->input->post('page');
		$limit = $this->input->post('rows');
		$sidx = $this->input->post('sidx');
		$sord = $this->input->post('sord');
		
		$count = $this->pengguna_model->countData();
		if( $count > 0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$rows = $this->pengguna_model->getData($sidx,$sord,$start,$limit);
		
		$response = new stdClass();
		$response->page = $page; 
		$response->total = $total_pages; 
		$response->records = $count;
		$i=0;
		
		
		foreach($rows as $row){
			$response->rows[$i]['id'] = $row->user_id; 
			$username = $row->username;
			$nama = ucwords($row->nama);
			$email = $row->email;
			$kontak = $row->kontak;
			$role = ucwords($row->role_nama);
			if($row->login_terakhir != NULL && $row->login_terakhir != ""){
				$t = explode(' ', $row->login_terakhir);
				$d = explode('-', $t[0]);
				$login_terakhir = "$d[2]-$d[1]-$d[0] $t[1]";
			}
			$ip_terakhir = $row->ip_terakhir;
			$response->rows[$i]['cell']=array($username,$nama,$email,$kontak,$role,$login_terakhir,$ip_terakhir);
			$i++;
		}
		
		echo json_encode($response);
	}
	
	function mod(){
		if($this->input->post('oper') == 'del'){
			$ids = $this->input->post('id');
			
			$this->pengguna_model->delete($ids);
			
		}elseif($this->input->post('oper') == 'edit'){
			$id = $this->input->post('id');
			$new['nama'] = $this->input->post('nama');
			$new['kontak'] = $this->input->post('kontak');
			$new['email'] = $this->input->post('email');
			$new['role_id'] = $this->input->post('role_id');
			if($this->input->post('password') != NULL){
				$new['password'] = sha1($this->input->post('password'));
			}
			
			if($this->pengguna_model->update($id,$new)){
				$this->session->set_flashdata('success', 'Data tersimpan');
			}else{
				$this->session->set_flashdata('error', 'Data tidak tersimpan');
			}
			redirect('pengguna/edit/'.$id);
		}
	}
	
	function check(){
		$uname = $this->input->post('uname');
		$check = $this->pengguna_model->checkUsername($uname);
		if($check){
			echo 'free';
		}else{
			echo 'exist';	
		}
	}
	
	function add(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Input Pengguna';
		$data['role'] = $this->pengguna_model->getRole();
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('pengguna_add_view', $data);
	}
	
	function edit(){
		$id = $this->uri->segment(3);
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Edit Pengguna';
		$data['user'] = $this->pengguna_model->getUserDetail($id);
		$data['id'] = $id;
		if(!$data['user'] || !$id || $id == 1){
			redirect("pengguna");
		}
		$data['role'] = $this->pengguna_model->getRole();
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('pengguna_edit_view', $data);
	}
	
	function input(){
		$insert = array ();
		if($this->input->post('username')){ $insert['username'] = $this->input->post('username');}
		if($this->input->post('password')){ $insert['password'] = sha1($this->input->post('password'));}
		if($this->input->post('nama')){ $insert['nama'] = $this->input->post('nama');}
		if($this->input->post('email')){ $insert['email'] = $this->input->post('email');}
		if($this->input->post('kontak')){ $insert['kontak'] = $this->input->post('kontak');}
		if($this->input->post('role_id')){ $insert['role_id'] = $this->input->post('role_id');}
		$insert['reg_time'] = date("Y-m-d H:i:s");
		$insert['login_terakhir'] = '0000-00-00 00:00:00';
		
		
		if($this->pengguna_model->addNew($insert)){
			$this->session->set_flashdata('success', 'Data ditambahkan');
		}else{
			$this->session->set_flashdata('error', 'Data gagal ditambahkan');
		}
		redirect('pengguna/add');
		
	}
}

/* End of file pengguna.php */
/* Location: ./application/modules/pengguna/controllers/pengguna.php */