<?php defined('BASEPATH') or exit('No direct script access allowed');
class Input extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_input', 'm_induk', 'm_log', 'm_list', 'm_user', 'm_result');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function index()
	{
		$this->add_input();
	}

	public function add_input()
	{
		$key = $this->session->userdata('nip');
		$isi = array(
			'userCab' => $this->m_user->getData($key),
			'cabang' => $this->m_list->getAllCabang(),
			'lokasi' => $this->m_list->getAllLokasi(),
			'koperasi' => $this->m_list->getDistKop(),
			'konten' => 'maker/add_input',
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_input()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_input',
			'data' => $this->m_input->getData($key),
			'koperasi' => $this->m_list->getDistKop()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	// public function listCabang()
	// {
	// 	$id = $_POST['id'];
	// 	$view = $this->m_list->data_chainCabang($id);
	// 	foreach ($view as $row) {
	// 		echo "<p class='text-muted' style='margin-top: 8px'>" . $row->nama_cabang . "</p>";
	// 	}
	// }

	// public function listLokasi()
	// {
	// 	$id = $_POST['id'];
	// 	$view = $this->m_lokasi->data_chain($id);
	// 	foreach ($view as $row) {
	// 		echo "<p class='text-muted' style='margin-top: 8px'>" . $row->deskripsi . "</p>";
	// 	}
	// }

	public function simpanData()
	{
		$key = input($this->input->post('no_fos'));
		$akses = $this->session->userdata('akses_user');
		$nip = $this->session->userdata('nip');

		$check = '';
		if (!empty($_POST['checkbox'])) $check = 'Y';

		$data = array(
			'no_fos' => $key,
			// 'kode' => 1,
			'nip_member_kop' => input($this->input->post('nip')),
			'cif' => input($this->input->post('cif')),
			'cif_induk' => input($this->input->post('uniqid')),
			'nama_nsbh' => input($this->input->post('nama_nsbh')),
			'nama_kop' => input($this->input->post('nama_kop')),
			'kode_cabang' => trim($this->input->post('kd_cabang')),
			'nom_fasilitas' => str_replace(',', '', input($this->input->post('nominal'))),
			'no_sp3' => input($this->input->post('no_sp3')),
			'tgl_sp3' => input($this->input->post('tgl_sp3')),
			'alamat' => input($this->input->post('alamat')),
			'lokasi_proyek' => input($this->input->post('lokasi')),
			'kode_pim' => input($this->input->post('kode_pim')),
			'rek_nsbh' => input($this->input->post('rek_nsbh')),
			'rek_pokok' => input($this->input->post('rek_pokok')),
			'kode_ao' => input($this->input->post('kode_ao')),
			'kode_fao' => input($this->input->post('kode_fao')),
			'tenor' => input($this->input->post('tenor')),
			'gaji_bln' => str_replace(',', '', input($this->input->post('gaji'))),
			'gaji_thn' => str_replace(',', '', input($this->input->post('gaji_thn'))),
			'tgl_jth_tempo' => input($this->input->post('tgl_jth_tempo')),
			'frek_review' => input($this->input->post('frek_review')),
			'tgl_angsuran' => input($this->input->post('tgl_angsuran')),
			'tgl_expired' => input($this->input->post('tgl_expire')),
			'no_pks' => input($this->input->post('no_pks')),
			'tgl_pks' => input($this->input->post('tgl_pks')),
			'tgl_nota' => input($this->input->post('tgl_nota')),
			'no_skkp' => input($this->input->post('no_skkp')),
			'tgl_komite' => input($this->input->post('tgl_komite')),
			'check' => $check
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

		$qry = $this->db->get_where('tbl_result', ['no_fos' => $key]);

		if ($this->input->post('method') == 'add') {
			$data['nip_user'] = $nip;
			$data['approve'] = 1;
			$data['kode'] = 1;
			$log['detail'] = "data input " . $key . " berhasil disimpan";

			$this->m_input->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/induk/add_induk/' . $key)));
		} else {
			// $proses = $this->db->get_where('tbl_result', ['no_fos' => $key, 'status' => 'Gagal']);
			// if ($proses->num_rows() > 0) {
			// 	$data['kode'] = $_POST['kode'] + 1;
			// } else {
			// 	$data['kode'] = $_POST['kode'];
			// }

			$log['detail'] = "data input " . $key . " berhasil diubah";
			if ($akses == 'Maker') {
				$data['nip_user'] = $nip;
			} else {
				$data['nip_reviewer'] = $nip;
				$data['tgl_cair'] = $this->input->post('tgl_cair');
			}

			$this->m_input->updateData($key, $data);
			$this->m_log->insert($log);

			$cek = $this->db->get_where('tbl_induk', ['no_fos' => $key]);
			if ($cek->num_rows() > 0) {
				redirect(site_url(ucfirst('maker/induk/edit_induk/' . $key)));
			} else {
				redirect(site_url(ucfirst('maker/induk/add_induk/' . $key)));
			}
		}
	}
}
