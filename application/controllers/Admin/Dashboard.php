<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();
		$model = array('m_user','m_dashboard','m_login','m_list');
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
		$isi = array(
			'konten' => 'admin/v_dashboard',
			'cabang' => $this->m_list->getAllCabang(),
			'Maker' => $this->m_user->getMaker(),
			'Checker' => $this->m_user->getChecker(),
			'Approval' => $this->m_user->getApproval(),
			'Reviewer' => $this->m_user->getReviewer()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
		$this->load->view('layout/_footer');
	}
}