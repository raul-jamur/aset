<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller {
	
	function __construct()
	{
       parent::__construct();
	   $this->load->model('auth_model');
	   $this->load->model('preferensi/preferensi_model');
	}
	
	function index()
	{
        if (!$this->session->userdata('logged_in')){
			$data['title'] = $this->preferensi_model->getPref('nama_sistem');
			$data['footer'] = $this->preferensi_model->getPref('footer_text');
            $this->load->view('login_view', $data);
        }else{
			redirect('backpanel');
		}
	}
	   
    function login() 
    {
        if ($this->input->post('userlogin')){ 
			$u = $this->input->post('userlogin'); 
			$pw = $this->input->post('userpass'); 
			$row = $this->auth_model->loggingIn($u,$pw); 
			if (count($row)){ 
				$data=array(
					'username' => $row['username'],
					'user_id' => $row['user_id'],
					'nama' => $row['nama'],
					'role_id' => $row['role_id'],
					'role_nama' => $row['role_nama'],
					'logged_in' => TRUE
				);
				$this->session->set_userdata($data); //set session data
				$sess_exp = $this->preferensi_model->getPref('sess_exp') * 60;
				$this->session->sess_expiration = $sess_exp; // set session expiration
				$data['title'] = $this->preferensi_model->getPref('nama_sistem');
				$data['footer'] = $this->preferensi_model->getPref('footer_text');
				$this->session->set_flashdata('success', 'Selamat Datang '.$row['nama'].'.');
				redirect('backpanel');
			}else{
				$this->session->set_flashdata('error','Username or Password yang Anda masukan salah');
				redirect('auth');
			}
		}else{
			redirect('auth');			
		}
    }
    
    function logout() //proses logout
    {
        $data=array(
					'nama' => '',
					'user_id' => '',
					'role_id' => '',
					'logged_in' => FALSE
				);
		$data['title'] = $this->preferensi_model->getPref('nama_sistem');
		$data['footer'] = $this->preferensi_model->getPref('footer_text');
		$this->session->unset_userdata($data);
		$this->session->set_flashdata('info','Anda baru saja keluar.');
		redirect('auth');
    }
}

/* End of file auth.php */
/* Location: ./application/modules/auth/controllers/auth.php */