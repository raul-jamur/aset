<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruangan extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('ruangan_model');
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
		$data['pagetitle'] = 'Daftar Ruangan';
		$data['css'] = array('jqueryui','jqgrid');
		$data['js'] = array('jquery','jqueryui','jqgrid');
		$this->load->view('ruangan_view', $data);
	}
	
	function listing(){
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$page = $this->input->post('page');
		$limit = $this->input->post('rows');
		$sidx = $this->input->post('sidx');
		$sord = $this->input->post('sord');
		
		$count = $this->ruangan_model->countData();
		if( $count > 0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$rows = $this->ruangan_model->getData($sidx,$sord,$start,$limit);
		
		$response = new stdClass();
		$response->page = $page; 
		$response->total = $total_pages; 
		$response->records = $count;
		$i=0;
		
		foreach($rows as $row){
			$response->rows[$i]['id'] = $row->ruang_id; 
			$ruang_nama = $row->ruang_nama;
			$jenisruang = $row->jenisruang_nama;
			if($row->ruang_luas != "" && $row->ruang_luas != NULL && $row->ruang_luas > 0){
				$ruang_luas = $row->ruang_luas." ".$data['s_luas'];
			}else{
				$ruang_luas = '';
			}
			$gd_nama = $row->gd_nama;
			$gd_lantai = $row->gd_lantai;
			if($row->ruang_foto != NULL || $row->ruang_foto != ''){
				$ruang_foto = "Ada";
			}else{
				$ruang_foto = "Tidak Ada";	
			}
			$response->rows[$i]['cell']=array($ruang_nama, $jenisruang, $ruang_luas, 'Gd. '.$gd_nama.'  lt. '.$gd_lantai, $ruang_foto);
			$i++;
		}
		
		echo json_encode($response);
	}
	
	function mod(){
		$this->checkAccess();
		if($this->input->post('oper') == 'del'){
			$ids = $this->input->post('id');
			$this->ruangan_model->delete($ids);
			
		}elseif($this->input->post('oper') == 'edit'){
			$id = $this->input->post('id');
			if(isset($id)){
				if($this->input->post('del-foto')){
					$this->_delFoto($id);
					$new['ruang_foto'] = '';
				}
				
				if ( ! empty($_FILES['ruang_foto']['name'])){
					$filename = explode(".", $_FILES['ruang_foto']['name']);
					$fileext = $filename[sizeof($filename) - 1];
					$nama_file = 'ruang_'.$id.'_'.mktime().'.'.$fileext;
					$config['file_name'] = $nama_file;
					$config['upload_path'] = './assets/gambar/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['overwrite'] = TRUE;
					$config['max_size']	= '200';
					$config['max_width'] = '400';
					$config['max_height'] = '400';
			
					$this->load->library('upload', $config);
			
					if ( ! $this->upload->do_upload('ruang_foto'))
					{
						echo $this->session->set_flashdata('error', $this->upload->display_errors('<span>','</span>'));
						$this->_delFoto($id);
						$new['ruang_foto'] = '';
					}else{
						$new['ruang_foto'] = $nama_file;
					}
				}else{
					//$ruang_foto = $this->ruangan_model->getFotoFile($id);
					//$new['ruang_foto'] = $ruang_foto[0]->ruang_foto;
				}
				$new['ruang_nama'] = $this->input->post('ruang_nama');
				$new['ruang_luas'] = $this->input->post('ruang_luas');
				$new['jenisruang_id'] = $this->input->post('jenisruang_id');
				$new['gd_id'] = $this->input->post('gd_id');
				$new['gd_lantai'] = $this->input->post('gd_lantai');
				$new['edited_time'] = date('Y-m-d H:i:s');
				$new['user_id'] = $this->session->userdata('user_id');
				
				if($this->ruangan_model->update($id,$new)){
					$this->session->set_flashdata('success', 'Data berhasil disimpan');
				}else{
					$this->session->set_flashdata('error', 'Data gagal disimpan');
				}
				redirect('ruangan/edit/'.$id);
			}
		}
	}
	
	function _delFoto($id){
		$this->checkAccess();
		$ruang_foto = $this->ruangan_model->getFotoFile($id);
		if($ruang_foto){
			@unlink('./assets/gambar/'.$ruang_foto[0]->ruang_foto);
		}
	}
	
	function add(){
		$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['pagetitle'] = 'Input Ruangan';
		$data['gedung'] = $this->ruangan_model->getAllGedung();
		$data['jenisruangan'] = $this->ruangan_model->getAllJenisRuang();
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('ruangan_add_view', $data);
	}
	
	function gdlantai(){
		$gd_id = $this->uri->segment(3);
		$gd_lantai = $this->uri->segment(4);
		$gdlantai = $this->ruangan_model->getGdLantai($gd_id);
		$s = '';
		for($i=1;$i<=$gdlantai[0]->gd_lantai;$i++){
			if($gd_lantai && $i == $gd_lantai){
				$s = 'selected="true"';
			}else{
				$s = '';
			}
			echo '<option value="'.$i.'" '.$s.'>'.$i.'</option>';
		}
	}
	
	function edit(){
		$this->checkAccess();
		$id = $this->uri->segment(3);
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['pagetitle'] = 'Edit Ruangan';
		$data['jenisruangan'] = $this->ruangan_model->getAllJenisRuang();
		$data['gedung'] = $this->ruangan_model->getAllGedung();
		$data['ruangan'] = $this->ruangan_model->getDetail($id);
		if(!$id || !$data['ruangan']){
			redirect("ruangan");
		}
		$data['id'] = $id;
		$data['css'] = array('validation');
		$data['js'] = array('jquery','validation');
		$this->load->view('ruangan_edit_view', $data);
	}
	
	function input(){
		$this->checkAccess();
		$ruang_foto = '';
		if ( ! empty($_FILES['ruang_foto']['name'])){
			$filename = explode(".", $_FILES['ruang_foto']['name']);
			$fileext = $filename[sizeof($filename) - 1];
			$gmid = $this->ruangan_model->getLastId();
			$lid = $gmid[0]->last_id + 1;
			$nama_file = 'ruang_'.$lid.'_'.mktime().'.'.$fileext;
			$config['file_name'] = $nama_file;
			$config['upload_path'] = './assets/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '200';
			$config['max_width'] = '400';
			$config['max_height'] = '400';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('ruang_foto'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors('<span>','</span>'));
				$ruang_foto = '';
			}else{
				$ruang_foto = $nama_file;
			}
		}
		$insert = array ();
		if($this->input->post('ruang_nama')){ $insert['ruang_nama'] = $this->input->post('ruang_nama');}
		if($this->input->post('ruang_luas')){ $insert['ruang_luas'] = $this->input->post('ruang_luas');}
		if($this->input->post('jenisruang_id')){ $insert['jenisruang_id'] = $this->input->post('jenisruang_id');}
		if($this->input->post('gd_id')){ $insert['gd_id'] = $this->input->post('gd_id');}
		if($this->input->post('gd_lantai')){ $insert['gd_lantai'] = $this->input->post('gd_lantai');}
		$insert['ruang_foto'] = $ruang_foto;
		$insert['created_time'] = date('Y-m-d H:i:s');
		$insert['user_id'] = $this->session->userdata('user_id');
		
		if($this->ruangan_model->addNew($insert)){
			$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		}else{
			$this->session->set_flashdata('error', 'Data gagal ditambahkan');
		}
		redirect('ruangan/add');
		
	}
	
	
	
	function katalog(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		
		$gd_id = $this->uri->segment(3);
		//pagination
		$config['base_url'] = site_url().'ruangan/katalog/'.$gd_id.'/list/';
		$config['total_rows'] = $this->ruangan_model->countRuangan($gd_id);
		$config['per_page'] = '20';
		$config['num_links'] = '8';
		$config['full_tag_open'] = " <div id='pagination'>";
		$config['full_tag_close'] = '</div> ';
		$config['uri_segment'] = 5; 
		
		$this->pagination->initialize($config);
		$data['paginator']=$this->pagination->create_links();
		
		//content
		$data['ruangan'] = $this->ruangan_model->getList($gd_id, $config['per_page'], $this->uri->segment(5));
		$data['pagetitle'] = 'Daftar Ruangan';
		
		$this->load->model('gedung/gedung_model');
		$data['gedung'] = $this->gedung_model->getDetail($gd_id);
		
		$data['breadcrumb'] = anchor('gedung/katalog/', 'Daftar Gedung');
		$data['breadcrumb'] .= anchor('gedung/detail/'.$gd_id, 'Gd. '.$data['gedung'][0]->gd_nama);
		$data['breadcrumb'] .= "<span>Daftar Ruangan</span>";
		
		$this->load->view('ruangan_list_view', $data);
	}
	
	function detail(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		
		$ruang_id = $this->uri->segment(4);
		$data['ruangan'] = $this->ruangan_model->getDetail($ruang_id);
		if($data['ruangan']){
			$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
			$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
			$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
			$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
			
			$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
			$data['gedung'] = $this->ruangan_model->getGedung($ruang_id);
			
			$data['jadwal_rutin'] = $this->ruangan_model->getJadwalRuangan($ruang_id, 1, $smt);
			$data['jadwal_tidak_rutin'] = $this->ruangan_model->getJadwalRuangan($ruang_id, 0, $smt);
			
			$data['breadcrumb'] = anchor('gedung/katalog/', 'Daftar Gedung');
			$data['breadcrumb'] .= anchor('gedung/detail/'.$data['gedung'][0]->gd_id, 'Gd. '.$data['gedung'][0]->gd_nama);
			$data['breadcrumb'] .= anchor('ruangan/katalog/'.$data['gedung'][0]->gd_id.'/list','Daftar Ruangan');
			$data['breadcrumb'] .= "<span>".$data['ruangan'][0]->ruang_nama."</span>";
			
			$data['js'] = array('jquery','jqueryui','calendar','qtip');
			$data['css'] = array('jqueryui','calendar');
			
			$this->load->view('ruangan_detail_view', $data);
		}else{
			redirect("404");
		}
	}
}

/* End of file ruangan.php */
/* Location: ./application/modules/ruangan/controllers/ruangan.php */