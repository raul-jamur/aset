<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('jadwal_model');
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
		redirect("backpanel");
	}
	
	function input(){
		$this->checkAccess();
		$data['smt'] = 1;
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['pagetitle'] = 'Input Jadwal Penggunaan Ruangan';
		
		$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
		$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
		$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
		$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
		
		$bulan = date("m");
	
		if(($bulan >= $smt['ganjil_start'] && $bulan > $smt['genap_end']) || ($bulan <= $smt['ganjil_end'] && $bulan < $smt['genap_start'])){
			$data['smt'] = "1";
		}elseif($bulan >= $smt['genap_start'] && $bulan <= $smt['genap_end']){
			$data['smt'] = "2";
		}
		
		if($this->uri->segment(3) == "step"){
			if($this->uri->segment(4) == "1"){
				$data['gedung'] = $this->jadwal_model->getAllGedung();
				$data['js'] = array('jquery');
				$this->load->view('jadwal_input1_view', $data);
			}elseif($this->uri->segment(4) == "2"){
				$ruang_id = $this->input->post('ruang_id');
				$data['ruangan'] = $this->jadwal_model->getRuangan($ruang_id);
				if(! $ruang_id || ! $data['ruangan']){
					$this->session->set_flashdata('error', 'Silahkan memilih ruangan terlebih dahulu');
					redirect("jadwal/input/step/1");
				}
				$data['gedung'] = $this->jadwal_model->getGedung($ruang_id);
				$data['css'] = array('jqueryui','timepicker','validation');
				$data['js'] = array('jquery','jqueryui','timepicker','validation');
				$this->load->view('jadwal_input2_view', $data);
			}else{
				redirect("jadwal/input/step/1");
			}
		}else{
			redirect("jadwal/input/step/1");
		}
	}
	
	function edit(){
		$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Input Jadwal Penggunaan Ruangan';
		
		$jadwal_id = $this->input->post('edit_id');
		if(! $jadwal_id){
			$jadwal_id = $this->uri->segment(3);
			if(! $jadwal_id){
				redirect("jadwal/ruangan");
			}
		}
		$ruang_id = $this->input->post('ruang_id');
		
		$data['jadwal'] = $this->jadwal_model->getDetail($jadwal_id);
		if(! $jadwal_id || ! $data['jadwal']){
			$this->session->set_flashdata('error', 'Silahkan memilih ruangan terlebih dahulu');
			redirect("jadwal/ruangan/detail/".$ruang_id);
		}
		$data['ruangan'] = $this->jadwal_model->getRuangan($ruang_id);
		$data['gedung'] = $this->jadwal_model->getGedung($ruang_id);
		$data['css'] = array('jqueryui','timepicker','validation');
		$data['js'] = array('jquery','jqueryui','timepicker','validation');
		$this->load->view('jadwal_edit_view', $data);
	}	
	
	function ruangan(){
		$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['s_luas'] = $this->preferensi_model->getPref('satuan_luas');
		$data['pagetitle'] = 'Jadwal Penggunaan Ruangan';
		if($this->uri->segment(3) == "detail"){
			$ruang_id = $this->input->post('ruang_id');
			if(! $ruang_id){
				$ruang_id = $this->uri->segment(4);
				if(! $ruang_id){
					redirect("jadwal/ruangan");
				}
			}
			if($ruang_id){
				$data['ruangan'] = $this->jadwal_model->getRuangan($ruang_id);
				$data['gedung'] = $this->jadwal_model->getGedung($ruang_id);
				
				$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
				$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
				$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
				$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
				
				$data['jadwal_rutin'] = $this->jadwal_model->getListJadwalRuangan($ruang_id, 1, $smt);
				$data['jadwal_tidak_rutin'] = $this->jadwal_model->getListJadwalRuangan($ruang_id, 0, $smt);
				$data['js'] = array('jquery','jqueryui','calendar','qtip');
				$data['css'] = array('jqueryui','calendar');
				$this->load->view('jadwal_ruangan_view', $data);
			}else{
				redirect("jadwal/ruangan");
			}
		}else{
			$data['gedung'] = $this->jadwal_model->getAllGedung();
			$data['js'] = array('jquery');
			$this->load->view('jadwal_penggunaan_view', $data);
		}
	}
	
	function penggunaan(){
		$ruang_id = $this->uri->segment(3);
		if($ruang_id){
			$start = $this->input->get('start');
			$end = $this->input->get('end');
			$jadwal = array();
			$smt = array();
			
			$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
			$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
			$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
			$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
			
			// fetch jadwal tidak rutin
			$jadwal2 = $this->jadwal_model->getJadwalRuangan($ruang_id, 0, $start, $end, $smt);
			if($jadwal2){
				foreach($jadwal2 as $row){
					$j2['id'] = $row->jadwal_id;
					$j2['title'] = $row->jadwal_acara;
					$j2['start'] = $row->jadwal_mulai;
					$j2['end'] = $row->jadwal_selesai;
					$jadwal[] = $j2;
				}
			}
			// fetch jadwal rutin
			$jadwal3 = $this->jadwal_model->getJadwalRuangan($ruang_id, 1, $start, $end, $smt);
			if($jadwal3){
				$m = date("n");
				if(($m >= $smt['ganjil_start'] && $m > $smt['genap_end']) || ($m <= $smt['ganjil_end'] && $m < $smt['genap_start'])){
					$smtnow = "1";
				}elseif($m >= $smt['genap_start'] && $m <= $smt['genap_end']){
					$smtnow = "2";
				}
				
				$tahun = date("Y");
				$tahun = (int)$tahun;
				if($m < $smt['genap_end']){
					$tahun--;
				}
				
				if($smtnow == "1"){
					if($smt['ganjil_end'] < $smt['ganjil_start']){
						$tahun2 = $tahun + 1;
					}else{
						$tahun2 = $tahun;
					}
					$t_end = mktime(0,0,0,$smt['ganjil_end']+1,1,$tahun2);
					$bulan = $smt['ganjil_start'];
					
				}elseif($smtnow == "2"){
					if($smt['genap_end'] < $smt['genap_start']){
						$tahun2 = $tahun + 1;
					}else{
						$tahun2 = $tahun;
					}
					$t_end = mktime(0,0,0,$smt['genap_end']+1,1,$tahun2);
					$bulan = $smt['genap_start'];
				}
				
				foreach($jadwal3 as $row){
					$start = $this->getFirstDay($bulan,$tahun,$row->jadwal_hari);
					$tanggal = (int)$start;
					$t_start = mktime(0,0,0,$bulan,$tanggal,$tahun);
					while($t_start <= $t_end){
						$j3['id'] = $row->jadwal_id;
						$j3['title'] = $row->jadwal_acara;
						$j3['start'] = date("Y-m-d",$t_start)." ".$row->jam_mulai;
						$j3['end'] = date("Y-m-d",$t_start)." ".$row->jam_selesai;
						$jadwal[] = $j3;
						$t_start += 604800;
					}
				}
				
			}
			//parsing data ke json
			echo json_encode($jadwal);
		}else{
			return false;
		}
	}
	
	function simpan(){
		$insert['ruang_id'] = $this->input->post('ruang_id');
		$insert['jadwal_acara'] = $this->input->post('jadwal_acara');
		
		if($insert['ruang_id']){
			$insert['jadwal_rutin'] = $this->input->post('jadwal_rutin');
			$cekrutin = '0';
			$cektidakrutin = '0';
			if($insert['jadwal_rutin'] == "1"){
				$insert['jadwal_hari'] = $this->input->post('jadwal_hari');
				$insert['jam_mulai'] = $this->input->post('jam_mulai');
				$insert['jam_selesai'] = $this->input->post('jam_selesai');
				$insert['jadwal_smt'] = $this->input->post('jadwal_smt');
				$insert['jadwal_tahun'] = $this->input->post('jadwal_tahun');
				
				if(! $insert['jam_mulai'] || ! $insert['jam_selesai']){
					$this->session->set_flashdata('error', 'Jadwal tersebut tidak diterima!');
					redirect('jadwal/input/step/1');
				}
				
				$cekrutin = $this->jadwal_model->cekJadwal(0, $insert, 0, 0);
			}elseif($insert['jadwal_rutin'] == "0"){
				$mulai = explode(" ",$this->input->post('jadwal_mulai'));
				$selesai = explode(" ",$this->input->post('jadwal_selesai'));
				$jm = explode("-", $mulai[0]);
				$js = explode("-", $selesai[0]);
				$insert['jadwal_mulai'] = $jm[2].'-'.$jm[1].'-'.$jm[0].' '.$mulai[2];
				$insert['jadwal_selesai'] = $js[2].'-'.$js[1].'-'.$js[0].' '.$selesai[2];
				
				if(! $insert['jadwal_mulai'] || ! $insert['jadwal_selesai']){
					$this->session->set_flashdata('error', 'Jadwal tersebut tidak diterima!');
					redirect('jadwal/input/step/1');
				}
				
				$cektidakrutin = $this->jadwal_model->cekJadwal(0, $insert, $insert['jadwal_mulai'], $insert['jadwal_selesai']);
			}
			
			$insert['created_time'] = date("Y-m-d H:i:s");
			$insert['user_id'] = $this->session->userdata('user_id');
			
			//echo "rutin = ".$cekrutin."<br/>";
			//echo "tidakrutin = ".$cektidakrutin."<br/>";
			
			if($cekrutin || $cektidakrutin){
				$this->session->set_flashdata('error', 'Jadwal tersebut bentrok dengan jadwal lain');
				echo '<html><head><script type="text/javascript">alert("Jadwal tersebut bentrok dengan jadwal lain"); history.go(-1);</script></head></html>';
			}else{
				if($this->jadwal_model->addNew($insert)){
					$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
					$this->jadwal_model->rollbackScrollTime();
				}else{
					$this->session->set_flashdata('error', 'Data gagal ditambahkan');
				}
				redirect('jadwal/input/step/1');
			}
			
		}else{
			$this->session->set_flashdata('error', 'Silahkan memilih ruangan terlebih dahulu');
			redirect("jadwal/input/step/1");
		}
	}
	
	function hapus(){
		$this->checkAccess();
		$jid = $this->input->post('jid');
		if($jid){
			if($this->jadwal_model->delete($jid)){
				$this->jadwal_model->rollbackScrollTime();
				echo "berhasil";
			}else{
				echo "gagal";
			}
		}else{
			echo "gagal";
		}
	}
	
	function update(){
		$jadwal_id = $this->input->post('jadwal_id');
		if($jadwal_id){
			$new['jadwal_rutin'] = $this->input->post('jadwal_rutin');
			$new['ruang_id'] = $this->input->post('ruang_id');
			$new['jadwal_acara'] = $this->input->post('jadwal_acara');
			$cekrutin = '0';
			$cektidakrutin = '0';
			//isi data
			if($new['jadwal_rutin'] == "1"){
				$new['jadwal_hari'] = $this->input->post('jadwal_hari');
				$new['jam_mulai'] = $this->input->post('jam_mulai');
				$new['jam_selesai'] = $this->input->post('jam_selesai');
				$new['jadwal_smt'] = $this->input->post('jadwal_smt');
				$new['jadwal_tahun'] = $this->input->post('jadwal_tahun');
				
				if(! $new['jam_mulai'] || ! $new['jam_selesai']){
					$this->session->set_flashdata('error', 'Jadwal tersebut tidak diterima!');
					redirect('jadwal/ruangan/detail/'.$new['ruang_id']);
				}
				
				$cekrutin = $this->jadwal_model->cekJadwal($jadwal_id, $new, 0, 0);
			}elseif($new['jadwal_rutin'] == "0"){
				$mulai = explode(" ",$this->input->post('jadwal_mulai'));
				$selesai = explode(" ",$this->input->post('jadwal_selesai'));
				$jm = explode("-", $mulai[0]);
				$js = explode("-", $selesai[0]);
				$new['jadwal_mulai'] = $jm[2].'-'.$jm[1].'-'.$jm[0].' '.$mulai[2];
				$new['jadwal_selesai'] = $js[2].'-'.$js[1].'-'.$js[0].' '.$selesai[2];
				
				if(! $new['jadwal_mulai'] || ! $new['jadwal_selesai']){
					$this->session->set_flashdata('error', 'Jadwal tersebut tidak diterima!');
					redirect('jadwal/ruangan/detail/'.$new['ruang_id']);
				}
				
				$cektidakrutin = $this->jadwal_model->cekJadwal($jadwal_id, $new, $new['jadwal_mulai'], $new['jadwal_selesai']);
			}
			
			$new['edited_time'] = date("Y-m-d H:i:s");
			$new['user_id'] = $this->session->userdata('user_id');
			
			//echo "rutin = ".$cekrutin."<br/>";
			//echo "tidakrutin = ".$cektidakrutin."<br/>";
			if($cekrutin || $cektidakrutin){
				$this->session->set_flashdata('error', 'Jadwal tersebut bentrok dengan jadwal lain');
				echo '<html><head><script type="text/javascript">alert("Jadwal tersebut bentrok dengan jadwal lain"); history.go(-1);</script></head></html>';
			}else{
				$this->clearRow($jadwal_id);
				if($this->jadwal_model->update($jadwal_id,$new)){
					$this->jadwal_model->rollbackScrollTime();
					$this->session->set_flashdata('success', 'Data berhasil disimpan');
				}else{
					$this->session->set_flashdata('error', 'Data gagal disimpan');
				}
				redirect('jadwal/ruangan/detail/'.$new['ruang_id']);
			}	
			
		}else{
			redirect("jadwal/ruangan/");
		}
	}
	
	function clearRow($jid){
		$new['jadwal_rutin'] = '';
		$new['jadwal_hari'] = NULL;
		$new['jam_mulai'] = NULL;
		$new['jam_selesai'] = NULL;
		$new['jadwal_mulai'] = NULL;
		$new['jadwal_selesai'] = NULL;
		$new['jadwal_smt'] = NULL;
		$new['jadwal_tahun'] = NULL;
		$this->jadwal_model->update($jid,$new);
	}
	
	function listruangan(){
		$id = $this->uri->segment(3);
		if($id){
			$ruangan = $this->jadwal_model->getAllRuangan($id);
			if($ruangan){
				$l = '';
				for($i=0;$i<sizeof($ruangan);$i++){
					if($ruangan[$i]->gd_lantai != $l && $l == ''){
						echo '<optgroup label="Lantai '.$ruangan[$i]->gd_lantai.'">'."\n";
						$l = $ruangan[$i]->gd_lantai;
					}
					if($ruangan[$i]->gd_lantai != $l && $l != ''){
						echo '</optgroup>'."\n";
						echo '<optgroup label="Lantai '.$ruangan[$i]->gd_lantai.'">'."\n";
						$l = $ruangan[$i]->gd_lantai;
					}
					
					echo "\t".'<option value="'.$ruangan[$i]->ruang_id.'">'.$ruangan[$i]->ruang_nama.'</option>'."\n";
					
					$j = $i+1;
					if($j == sizeof($ruangan)){
						echo '</optgroup>';
					}
				}
			}else{
				echo "<option value='-1'>Tidak dapat memuat data</option>";
			}
		}else{
			echo "<option value='-1'>Tidak dapat memuat data</option>";
		}
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
	
	function getFirstDay($month,$year,$day){
        $num = date("w",mktime(0,0,0,$month,1,$year));
        if($num==$day) {
                return date("d",mktime(0,0,0,$month,1,$year));
        }
        elseif($num>$day) {
                return date("d",mktime(0,0,0,$month,1,$year)+(86400*((7+$day)-$num)));
        }
        else {
                return date("d",mktime(0,0,0,$month,1,$year)+(86400*($day-$num)));
        }
	}
	
	function info(){
		//$this->checkAccess();
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['pagetitle'] = 'Jadwal Penggunaan Ruangan';
		$data['gedung'] = $this->jadwal_model->getAllGedung();
		$data['js'] = array('jquery');
		$this->load->view('jadwal_info_view', $data);
	}
}

/* End of file gedung.php */
/* Location: ./application/modules/gedung/controllers/gedung.php */