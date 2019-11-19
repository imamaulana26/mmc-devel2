<?php defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$model = array('m_dashboard', 'm_login', 'm_list', 'm_result');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	function index()
	{
		$isi = array(
			'konten' => 'maker/v_dashboard',
			'cif' => $this->m_dashboard->count_cif(),
			'kop' => $this->m_dashboard->count_kop(),
			'details' => $this->m_dashboard->details(),
			'existing' => $this->m_dashboard->get_existing(),
			'proses' => $this->m_dashboard->get_proses(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'get_revisi' => $this->m_dashboard->get_revisi(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function approve()
	{
		$data = array(
			'konten' => 'maker/v_approval',
			'data' => $this->m_dashboard->get_proses(),
			'details' => $this->m_dashboard->details(),
			'kop' => $this->m_dashboard->count_kop(),
			'cif' => $this->m_dashboard->count_cif(),
			'existing' => $this->m_dashboard->get_existing(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'get_revisi' => $this->m_dashboard->get_revisi(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $data);
	}

	function result()
	{
		$isi = array(
			'konten' => 'maker/v_pencairan',
			'cif' => $this->m_dashboard->count_cif(),
			'kop' => $this->m_dashboard->count_kop(),
			'details' => $this->m_dashboard->details(),
			'existing' => $this->m_dashboard->get_existing(),
			'proses' => $this->m_dashboard->get_proses(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'get_revisi' => $this->m_dashboard->get_revisi(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}
}
