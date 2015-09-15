<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('preferensi/preferensi_model');
	}
	
	function index(){				
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		//$data['jadwal'] = $this->home_model->getJadwal();
		$data['pagetitle'] = '';
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$data['scroller'] = $this->scroller();
		$data['js'] = array('jquery','scroller');
		$data['css'] = array('scroller');
		$this->load->view('home_view', $data);
	}
	
	function scroller()
	{
        $last = $this->home_model->getLast();
		$now = mktime();
		$diff = $now - $last;
		$scroll = '';
		$string = '';
		$gd = '';
		$rg = '';
		
		$smt['ganjil_start'] = $this->preferensi_model->getPref('smt_ganjil_start');
		$smt['ganjil_end'] = $this->preferensi_model->getPref('smt_ganjil_end');
		$smt['genap_start'] = $this->preferensi_model->getPref('smt_genap_start');
		$smt['genap_end'] = $this->preferensi_model->getPref('smt_genap_end');
		$scroll_generate = $this->preferensi_model->getPref('scroll_generate'); // dalam menit
		if($scroll_generate == ''){
			$scroll_generate = 30;
		}
		$auto_scroll_generate = $scroll_generate * 60;
		
		if(abs($diff) > $auto_scroll_generate){
			$gedung = $this->home_model->getAllGedung();
			if($gedung){
				foreach($gedung as $g){
					$ruangan = $this->home_model->getAllRuangan($g->gd_id);
					foreach($ruangan as $r){
						$jadwal = $this->home_model->getJadwal($r->ruang_id, $smt);
						//$string .= "<li>".$jadwal."</li>";
						if($jadwal){
							foreach($jadwal as $j){
								if($g->gd_id != $gd){
									$string .= "<li><p><a href='".site_url("gedung/detail")."/".$g->gd_id."'><b style='text-decoration:underline;'>Gd. ".$g->gd_nama."</b></a></p></li>";
									$gd = $g->gd_id;
								}
								
								if($r->ruang_id != $rg){
									$string .= "<li><a href='".site_url("ruangan/detail/id")."/".$r->ruang_id."'><b>".$r->ruang_nama."</b></a></li>";
									$rg = $r->ruang_id;
								}
								
								if($j->jadwal_rutin == 1){
									$string .= "<li>".substr($j->jam_mulai,0,5)." - ".substr($j->jam_selesai,0,5)." : ".$j->jadwal_acara."</li>"."\n";
								}else{
									$jm = explode(" ",$j->jadwal_mulai);
									$tm = explode(":", $jm[0]);
									$hm = substr($jm[1],0,5);
									
									$js = explode(" ",$j->jadwal_selesai);
									$ts = explode(":", $js[0]);
									$hs = substr($js[1],0,5);
									
									if(substr($j->jadwal_mulai,0,10) == substr($j->jadwal_selesai,0,10)){
										$waktu = $hm." - ".$hs;
									}else{
										$waktu = $tm[2]."/".$tm[1]."/".$tm[0].", ".$hm." - ".$ts[2]."/".$ts[1]."/".$ts[0].", ".$hs;
									}
									
									$string .= "<li>".$waktu." : ".$j->jadwal_acara."</li>"."\n";
								}
							}
						}
					}
				}
			}else{
				//$string .= '<ul><li>Tidak ada kegiatan yang sedang dilaksanakan saat ini.</li></ul>';
			}
			
			
			if($string != ''){
				$data = "<ul>"."\n".$string."</ul>";
				/*if ( write_file('./assets/file/scroller.txt', $data)){
					 $new['sb_tgl'] = $now;
					 if($this->home_model->update($new)){ // update waktu generate terakhir
					 	$scroll = read_file('./assets/file/scroller.txt'); // baca file
					 }
				}else{
					 $scroll = read_file('./assets/file/scroller.txt');
				}*/
			}else{
				//$scroll = "<p align='center'>Tidak ada kegiatan yang sedang<br/>dilaksanakan saat ini.</p>";
				$data = "<p align='center'>Tidak ada kegiatan yang sedang<br/>dilaksanakan saat ini.</p>";
			}
			// tulis ke file;
			if ( write_file('./assets/file/scroller.txt', $data)){
				 $new['sb_tgl'] = $now;
				 if($this->home_model->update($new)){ // update waktu generate terakhir
					$scroll = read_file('./assets/file/scroller.txt'); // baca file
				 }
			}else{
				 $scroll = read_file('./assets/file/scroller.txt');
			}
			
		}else{
			$scroll = read_file('./assets/file/scroller.txt');
		}
		
		return $scroll;
	}
}

/* End of file home.php */
/* Location: ./application/modules/home/controllers/home.php */