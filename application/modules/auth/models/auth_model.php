<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Auth_model extends CI_Model{

	function __construct()
	{
		parent::__construct();	
	}
	
	function loggingIn($u, $pw) {
		$q = $this->db->query("SELECT u.*, r.* FROM user u, role r WHERE u.role_id=r.role_id AND u.username='".$u."' AND u.password='".sha1($pw)."'");
        if ($q->num_rows() > 0) {
            $row = $q->row_array();
			$timestamp = date('Y-m-d H:i:s');
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->db->query("UPDATE user SET login_terakhir='".$timestamp."', ip_terakhir='".$ip."' WHERE user_id=".$row['user_id']);
            return $row;
        } else {
            $this->session->set_flashdata('error','Username or Password yang Anda masukan salah');
            return array();
        }
    }
	
}