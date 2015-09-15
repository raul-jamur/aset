<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _404 extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('preferensi/preferensi_model');
	}
	
	function index(){
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$this->load->view('404_view', $data);
	}
}

/* End of file _404.php */
/* Location: ./application/modules/_404/controllers/_404.php */