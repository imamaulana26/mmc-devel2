<?php defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$model = array('m_input', 'm_dashboard', 'm_login', 'm_list', 'm_checker', 'm_log', 'm_result');
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
		$data = array(
			'konten' => 'checker/v_dashboard',
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

	function approve()
	{
		$data = array(
			'konten' => 'checker/v_approval',
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
		$data = array(
			'konten' => 'checker/v_pencairan',
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

	function updateDetail()
	{
		$key = input($this->input->post('no_fos'));

		date_default_timezone_set('Asia/Jakarta');
		$log = array(
			'user_session' => $this->session->userdata('nip'),
			'nama_user' => $this->session->userdata('nama_user'),
			'akses_user' => $this->session->userdata('akses_user'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'url' => $_SERVER['REQUEST_URI'],
			'waktu' => date('Y-m-d H:i:s')
		);

		if (isset($_POST['approve'])) {
			$update = array(
				'no_fos' => $key,
				'nip_checker' => $this->session->userdata('nip'),
				'approve' => $this->input->post('approve')
			);
			$log['detail'] = $key . ' disetujui oleh ' . $this->session->userdata('nip');
			$this->session->set_flashdata('Info', 'Data ' . $key . ' telah disetujui dan dikirim ke menu Reviewer');
		} else {
			$update = array(
				'no_fos' => $key,
				'nip_checker' => $this->session->userdata('nip'),
				'approve' => $this->input->post('reject')
			);
			$log['detail'] = $key . ' ditolak oleh ' . $this->session->userdata('nip');
			$this->session->set_flashdata('Info', 'Data ' . $key . ' telah ditolak dan dikirim ke menu Maker');
		}

		$this->m_input->updateData($key, $update);
		$this->m_log->insert($log);
		redirect(site_url(ucfirst('checker/dashboard')));
	}
}
