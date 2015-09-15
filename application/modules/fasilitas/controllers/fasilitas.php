<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fasilitas extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('access_model');
			$izin = $this->access_model->checkAccess($this->session->userdata('role_id'), $this->uri->segment(1));
			if($izin){
				$this->load->model('fasilitas_model');
				$this->load->model('preferensi/preferensi_model');
			}else{
				redirect('backpanel');
			}
		}
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Daftar Fasilitas';
		$data['css'] = array('jqueryui','jqgrid');
		$data['js'] = array('jquery','jqueryui','jqgrid');
		$this->load->view('fasilitas_view', $data);
	}
	
	function listing(){
		$page = $this->input->post('page');
		$limit = $this->input->post('rows');
		$sidx = $this->input->post('sidx');
		$sord = $this->input->post('sord');
		
		$count = $this->fasilitas_model->countData();
		if( $count > 0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$rows = $this->fasilitas_model->getData($sidx,$sord,$start,$limit);
		
		$response = new stdClass();
		$response->page = $page; 
		$response->total = $total_pages; 
		$response->records = $count;
		$i=0;
		
		
		foreach($rows as $row){
			$response->rows[$i]['id'] = $row->fasilitas_id; 
			$fasilitas_nama = $row->fasilitas_nama;		
			$response->rows[$i]['cell']=array($fasilitas_nama);
			$i++;
		}
		
		echo json_encode($response);
	}
	
	function mod(){
		if($this->input->post('oper') == 'del'){
			$ids = $this->input->post('id');
			$this->fasilitas_model->delete($ids);
			
		}elseif($this->input->post('oper') == 'edit'){
			$id = $this->input->post('id');
			$new['fasilitas_nama'] = $this->input->post('fasilitas_nama');
			if($this->fasilitas_model->checkData($this->input->post('fasilitas_nama'))){
				$this->session->set_flashdata('error', 'Data tersebut sudah ada di database');
			}else{
				$new['edited_time'] = date('Y-m-d H:i:s');
				$new['user_id'] = $this->session->userdata('user_id');
				if($this->fasilitas_model->update($id,$new)){
					$this->session->set_flashdata('success', 'Data tersimpan');
				}else{
					$this->session->set_flashdata('error', 'Data tidak tersimpan');
				}
			}
			redirect('fasilitas/edit/'.$id);
		}
	}
	
	function add(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Input Fasilitas';
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('fasilitas_add_view', $data);
	}
	
	function edit(){
		$id = $this->uri->segment(3);
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Edit Fasilitas';
		$data['fasilitas'] = $this->fasilitas_model->getDetail($id);
		if(!$id || !$data['fasilitas']){
			redirect("fasilitas");
		}
		$data['id'] = $id;
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('fasilitas_edit_view', $data);
	}
	
	function input(){
		$insert = array ();
		if($this->input->post('fasilitas_nama')){ $insert['fasilitas_nama'] = $this->input->post('fasilitas_nama');}		
		if($this->fasilitas_model->checkData($this->input->post('fasilitas_nama'))){
			$this->session->set_flashdata('error', 'Data tersebut sudah ada di database');
		}else{
			$insert['created_time'] = date('Y-m-d H:i:s');
			$insert['user_id'] = $this->session->userdata('user_id');
			if($this->fasilitas_model->addNew($insert)){
				$this->session->set_flashdata('success', 'Data ditambahkan');
			}else{
				$this->session->set_flashdata('error', 'Data gagal ditambahkan');
			}
		}
		redirect('fasilitas/add');
		
	}
}

/* End of file fasilitas.php */
/* Location: ./application/modules/fasilitas/controllers/fasilitas.php */