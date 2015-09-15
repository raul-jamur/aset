<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jenisruangan extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('access_model');
			$izin = $this->access_model->checkAccess($this->session->userdata('role_id'), $this->uri->segment(1));
			if($izin){
				$this->load->model('jenisruangan_model');
				$this->load->model('preferensi/preferensi_model');
			}else{
				redirect('backpanel');
			}
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Daftar Jenis Ruangan';
		$data['css'] = array('jqueryui','jqgrid');
		$data['js'] = array('jquery','jqueryui','jqgrid');
		$this->load->view('jenisruangan_view', $data);
	}
	
	function listing(){
		$page = $this->input->post('page');
		$limit = $this->input->post('rows');
		$sidx = $this->input->post('sidx');
		$sord = $this->input->post('sord');
		
		$count = $this->jenisruangan_model->countData();
		if( $count > 0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$rows = $this->jenisruangan_model->getData($sidx,$sord,$start,$limit);
		
		$response = new stdClass();
		$response->page = $page; 
		$response->total = $total_pages; 
		$response->records = $count;
		$i=0;
		
		
		foreach($rows as $row){
			$response->rows[$i]['id'] = $row->jenisruang_id; 
			$jenisruang_nama = $row->jenisruang_nama;
			if($row->jenisruang_jadwal == 1){
				$jadwal = "Ya";
			}else{
				$jadwal = "Tidak";
			}
			$response->rows[$i]['cell']=array($jenisruang_nama, $jadwal);
			$i++;
		}
		
		echo json_encode($response);
	}
	
	function mod(){
		if($this->input->post('oper') == 'del'){
			$ids = $this->input->post('id');
			$this->jenisruangan_model->delete($ids);
			
		}elseif($this->input->post('oper') == 'edit'){
			$id = $this->input->post('id');
			$new['jenisruang_nama'] = $this->input->post('jenisruang_nama');
			$new['jenisruang_jadwal'] = $this->input->post('jenisruang_jadwal');
			if($this->jenisruangan_model->checkData($this->input->post('jenisruang_nama'))){
				$this->session->set_flashdata('error', 'Data tersebut sudah ada di database');
			}else{
				$new['edited_time'] = date('Y-m-d H:i:s');
				$new['user_id'] = $this->session->userdata('user_id');
				if($this->jenisruangan_model->update($id,$new)){
					$this->session->set_flashdata('success', 'Data berhasil disimpan');
				}else{
					$this->session->set_flashdata('error', 'Data gagal disimpan');
				}
			}
			redirect('jenisruangan/edit/'.$id);
		}
	}
	
	function add(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Input Jenis Ruangan';
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('jenisruangan_add_view', $data);
	}
	
	function edit(){
		$id = $this->uri->segment(3);
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Edit Jenis Ruangan';
		$data['jenisruangan'] = $this->jenisruangan_model->getDetail($id);
		if(!$id || !$data['jenisruangan']){
			redirect("jenisruangan");
		}
		$data['id'] = $id;
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('jenisruangan_edit_view', $data);
	}
	
	function input(){
		$insert = array ();
		if($this->input->post('jenisruang_nama')){ $insert['jenisruang_nama'] = $this->input->post('jenisruang_nama');}
		if($this->input->post('jenisruang_jadwal')){ $insert['jenisruang_jadwal'] = $this->input->post('jenisruang_jadwal');}
		if($this->jenisruangan_model->checkData($this->input->post('jenisruang_nama'))){
			$this->session->set_flashdata('error', 'Data tersebut sudah ada di database');
		}else{
			$insert['created_time'] = date('Y-m-d H:i:s');
			$insert['user_id'] = $this->session->userdata('user_id');
			if($this->jenisruangan_model->addNew($insert)){
				$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
			}else{
				$this->session->set_flashdata('error', 'Data gagal ditambahkan');
			}
		}
		redirect('jenisruangan/add');
		
	}
}

/* End of file jenisruangan.php */
/* Location: ./application/modules/jenisruangan/controllers/jenisruangan.php */