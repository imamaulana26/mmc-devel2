<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PTO extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('layout/_header');
		$this->load->view('layout/_footer');
		$model = array('m_user','m_log','m_list');
		foreach($model as $mod){
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if(empty($email)){
			$this->session->sess_destroy();
			redirect('login');
		}
	}
	
	function index(){
		$sess_user = $this->session->userdata('nip');
		$lv_akses = $this->session->userdata('akses_user');
		if(isset($sess_user) && $lv_akses = 'Admin'){
			$isi = array(
				'konten' => 'v_pto'
			);
			$this->load->view('layout/_content', $isi);
		}
	}
}