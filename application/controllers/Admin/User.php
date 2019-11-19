<?php defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_user', 'm_log', 'm_list');
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
			'konten' => 'admin/v_user',
			'list' => $this->m_user->getAll()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function add_user()
	{
		$isi = array(
			'konten' => 'admin/add_user'
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function edit_user($key)
	{
		$isi = array(
			'konten' => 'admin/edit_user',
			'data' => $this->m_user->getData($key),
			'cabang' => $this->m_list->getAllCabang()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function profil()
	{
		$key = $this->session->userdata('nip');
		$isi = array(
			'konten' => 'admin/v_profil',
			'cabang' => $this->m_list->getAllCabang(),
			'data' => $this->m_user->getData($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function log()
	{
		$isi = array(
			'log_history' => $this->m_log->getAll(),
			'konten' => 'admin/v_log'
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_content', $isi);
	}


	function simpan()
	{
		$method = $this->input->post('method');
		$key = input($this->input->post('nip_user'));

		$jaringan = $this->input->post('jaringan');
		if (is_array($this->input->post('jaringan'))) {
			$jaringan = implode("::", $this->input->post('jaringan'));
		}

		$data = array(
			'nama_user' => input($this->input->post('nama_user')),
			'cabang' => input($this->input->post('cabang')),
			'jaringan' => $jaringan,
			'jabatan' => input($this->input->post('jabatan')),
			'akses_user' => input($this->input->post('akses')),
			'email' => input($this->input->post('email')) . '@syariahmandiri.co.id',
			'password' => md5('Bsm123'),
			'active' => 0,
			'log_on' => '0000-00-00 00:00:00',
			'last_login' => '0000-00-00 00:00:00'
		);

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

		if ($method == 'add') {
			$query = $this->m_user->getData($key);
			if ($query->num_rows() > 0) {
				$this->session->set_flashdata('error', 'NIP User sudah ada!');

				$this->add_user();
			} else {
				$data['nip_user'] = $key;

				$log['detail'] = $key . " berhasil menambahkan Data Users";

				$this->m_user->insertData($data);
				$this->m_log->insert($log);

				$this->session->set_flashdata('info', "Data Users <b>" . $key . " - " . $data['nama_user'] . "</b> berhasil disimpan!");
				$this->index();
			}
		} else {
			$log['detail'] = $key . " berhasil merubah Data Users";

			$this->m_user->updateData($key, $data);
			$this->m_log->insert($log);

			$this->session->set_flashdata('info', "Data Users <b>" . $key . " - " . $data['nama_user'] . "</b> berhasil diubah!");
			$this->index();
		}
	}

	function v_jaringan()
	{
		$this->db->select('a.*, b.nama_cabang')->from('tbl_users a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		$this->db->where('a.nip_user', $this->input->post('user'));
		$result = $this->db->get()->result_array();

		$exp = explode("::", $result[0]['jaringan']);
		$this->db->select('*')->from('tbl_cabang');
		for ($i = 0; $i < count($exp); $i++) {
			$this->db->or_where('kd_cabang', $exp[$i]);
		}
		$res = $this->db->get()->result_array();

		echo json_encode($res);
		exit;
	}
}
