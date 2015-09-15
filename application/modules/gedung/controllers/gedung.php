<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gedung extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('gedung_model');
		$this->load->model('preferensi/preferensi_model');
	}
	
	function checkAccess(){
		if(!$this->session->userdata('logged_in')){
	       redirect('auth');
	   	}else{
			$this->load->model('access_model');
			$izin = $this->access_model->checkAccess($this->session->userdata('role_id'), $this->uri->segment(1));
			if($izin){
				return true;
			}else{
				redirect('backpanel'); 
			}
		}
	}
	
	function index(){
		$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Daftar Gedung';
		$data['css'] = array('jqueryui','jqgrid');
		$data['js'] = array('jquery','jqueryui','jqgrid');
		$this->load->view('gedung_view', $data);
	}
	
	function listing(){
		$data['s_lantai'] = $this->preferensi_model->getPref('satuan_lantai');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$page = $this->input->post('page');
		$limit = $this->input->post('rows');
		$sidx = $this->input->post('sidx');
		$sord = $this->input->post('sord');
		
		$count = $this->gedung_model->countData();
		if( $count > 0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$rows = $this->gedung_model->getData($sidx,$sord,$start,$limit);
		
		$response = new stdClass();
		$response->page = $page; 
		$response->total = $total_pages; 
		$response->records = $count;
		$i=0;
		
		foreach($rows as $row){
			$response->rows[$i]['id'] = $row->gd_id; 
			$gd_nama = $row->gd_nama;
			if($row->gd_luas){
				$gd_luas = $row->gd_luas." ".$data['s_luas'];
			}else{
				$gd_luas = '-';
			}
			$gd_lantai = $row->gd_lantai." ".$data['s_lantai'];
			if($row->gd_foto != NULL || $row->gd_foto != ''){
				$gd_foto = "Ada";
			}else{
				$gd_foto = "Tidak Ada";	
			}
			$response->rows[$i]['cell']=array($gd_nama, $gd_luas,$gd_lantai,$gd_foto);
			$i++;
		}
		
		echo json_encode($response);
	}
	
	function mod(){
		$this->checkAccess();
		if($this->input->post('oper') == 'del'){
			$ids = $this->input->post('id');
			$this->gedung_model->delete($ids);
			
		}elseif($this->input->post('oper') == 'edit'){
			$id = $this->input->post('id');
			if(isset($id)){
				if($this->input->post('del-foto')){
					$this->_delFoto($id);
					$new['gd_foto'] = '';
				}
				
				if ( ! empty($_FILES['gd_foto']['name'])){
					$filename = explode(".", $_FILES['gd_foto']['name']);
					$fileext = $filename[sizeof($filename) - 1];
					$nama_file = 'gd_'.$id.'_'.mktime().'.'.$fileext;
					$config['file_name'] = $nama_file;
					$config['upload_path'] = './assets/gambar/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['overwrite'] = TRUE;
					$config['max_size']	= '200';
					$config['max_width'] = '400';
					$config['max_height'] = '400';
			
					$this->load->library('upload', $config);
			
					if ( ! $this->upload->do_upload('gd_foto'))
					{
						echo $this->session->set_flashdata('error', $this->upload->display_errors('<span>','</span>'));
						$this->_delFoto($id);
						$new['gd_foto'] = '';
					}else{
						$new['gd_foto'] = $nama_file;
					}
				}else{
					$gd_foto = $this->gedung_model->getFotoFile($id);
					$new['gd_foto'] = $gd_foto[0]->gd_foto;
				}
				$new['gd_nama'] = $this->input->post('gd_nama');
				$new['gd_luas'] = $this->input->post('gd_luas');
				$new['gd_lantai'] = $this->input->post('gd_lantai');
				if($this->input->post('gd_fasilitas')){
					$new['gd_fasilitas'] = implode(",",$this->input->post('gd_fasilitas'));
				}else{
					$new['gd_fasilitas'] = '';
				}
				$new['edited_time'] = date('Y-m-d H:i:s');
				$new['user_id'] = $this->session->userdata('user_id');
				
				if($this->gedung_model->update($id,$new)){
					$this->session->set_flashdata('success', 'Data tersimpan');
				}else{
					$this->session->set_flashdata('error', 'Data tidak tersimpan');
				}
				redirect('gedung/edit/'.$id);
			}
		}
	}
	
	function _delFoto($id){
		$this->checkAccess();
		$gd_foto = $this->gedung_model->getFotoFile($id);
		if($gd_foto){
			@unlink('./assets/gambar/'.$gd_foto[0]->gd_foto);
		}
	}
	
	function add(){
		$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Input Gedung';
		$data['fasilitas'] = $this->gedung_model->getAllFasilitas();
		$data['s_lantai'] = $this->preferensi_model->getPref('satuan_lantai');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('gedung_add_view', $data);
	}
	
	function edit(){
		$this->checkAccess();
		$id = $this->uri->segment(3);
		$data['s_lantai'] = $this->preferensi_model->getPref('satuan_lantai');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Edit Gedung';
		$data['gedung'] = $this->gedung_model->getDetail($id);
		if(!$id || !$data['gedung']){
			redirect("gedung");
		}
		$data['fasilitas'] = $this->gedung_model->getAllFasilitas();
		if($data['gedung'][0]->gd_fasilitas){
			$data['gd_fasilitas'] = $this->gedung_model->getFasilitas($data['gedung'][0]->gd_fasilitas);
		}else{
			$data['gd_fasilitas'] = '';
		}
		$data['id'] = $id;
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('gedung_edit_view', $data);
	}
	
	function input(){
		$this->checkAccess();
		$gd_foto = '';
		if ( ! empty($_FILES['gd_foto']['name'])){
			$filename = explode(".", $_FILES['gd_foto']['name']);
			$fileext = $filename[sizeof($filename) - 1];
			$gmid = $this->gedung_model->getLastId();
			$lid = $gmid[0]->last_id + 1;
			$nama_file = 'gd_'.$lid.'_'.mktime().'.'.$fileext;
			$config['file_name'] = $nama_file;
			$config['upload_path'] = './assets/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '200';
			$config['max_width'] = '400';
			$config['max_height'] = '400';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('gd_foto'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors('<span>','</span>'));
				$gd_foto = '';
			}else{
				$gd_foto = $nama_file;
			}
		}
		$insert = array ();
		if($this->input->post('gd_nama')){ $insert['gd_nama'] = $this->input->post('gd_nama');}
		if($this->input->post('gd_luas')){ $insert['gd_luas'] = $this->input->post('gd_luas');}
		if($this->input->post('gd_lantai')){ $insert['gd_lantai'] = $this->input->post('gd_lantai');}
		if($this->input->post('gd_fasilitas')){
			$insert['gd_fasilitas'] = implode(",",$this->input->post('gd_fasilitas'));
		}else{
			$insert['gd_fasilitas'] = '';
		}
		$insert['gd_foto'] = $gd_foto;
		$insert['created_time'] = date('Y-m-d H:i:s');
		$insert['user_id'] = $this->session->userdata('user_id');
		
		if($this->gedung_model->addNew($insert)){
			$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		}else{
			$this->session->set_flashdata('error', 'Data gagal ditambahkan');
		}
		redirect('gedung/add');
		
	}
	
	
	
	function katalog(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		
		//pagination
		$config['base_url'] = site_url().'gedung/katalog/';
		$config['total_rows'] = $this->gedung_model->countData();
		$config['per_page'] = '10';
		$config['num_links'] = '8';
		$config['full_tag_open'] = " <div id='pagination'>";
		$config['full_tag_close'] = '</div> ';
		$config['uri_segment'] = 3; 
		
		$this->pagination->initialize($config);
		$data['paginator']=$this->pagination->create_links();
		
		//content
		$data['gedung'] = $this->gedung_model->getList($config['per_page'], $this->uri->segment(3));
		$data['pagetitle'] = 'Daftar Gedung';
		$this->load->view('gedung_list_view', $data);
	}
	
	function detail(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		
		$data['gedung'] = $this->gedung_model->getDetail($this->uri->segment(3));
		if($data['gedung']){
			$data['s_lantai'] = $this->preferensi_model->getPref('satuan_lantai');
			$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
			if($data['gedung'][0]->gd_fasilitas){
				$data['fasilitas'] = $this->gedung_model->getFasilitas($data['gedung'][0]->gd_fasilitas);			
			}else{
				$data['fasilitas'] = '';
			}
			$data['breadcrumb'] = anchor('gedung/katalog','Daftar Gedung');
			$data['breadcrumb'] .= "<span>Gd. ".$data['gedung'][0]->gd_nama."</span>";
			$this->load->view('gedung_detail_view', $data);
		}else{
			redirect("404");
		}
	}
}

/* End of file gedung.php */
/* Location: ./application/modules/gedung/controllers/gedung.php */