<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('logged_in')){
	       redirect('auth/login');
	   	}else{
			$this->load->model('config_model');
		}
	}
	
	function index(){
		$data['title'] = 'Configuration';
		$data['content'] = $this->config_model->getConfiguration();
		$data['url'] = anchor('dashboard', 'Home') . " &gt; ";
		$this->load->view('config_view', $data);
	}
	
	function save(){
		$error = 0;
		for($i=1;$i<=4;$i++){
			$update = array();
			$update['administrator'] = $this->input->post('admin-'.$i);
			$update['user'] = $this->input->post('user-'.$i);
			if(!$this->config_model->save($i,$update)){
				$error = 1;
			}
		}
		if($error){
			$this->session->set_flashdata('error','Configuration not saved');
		}else{
			$this->session->set_flashdata('success','Configuration saved');
		}
		
		redirect('config');
	}
}

/* End of file config.php */
/* Location: ./application/modules/config/controllers/config.php */