<?php defined('BASEPATH') or exit('No direct script access allowed');
class Koperasi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_koperasi', 'm_list', 'm_log');
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
		$isi = array(
			'konten' => 'maker/v_koperasi',
			'data' => $this->m_list->getDistKop()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function add_koperasi()
	{
		$isi = array(
			'konten' => 'maker/add_koperasi'
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_koperasi()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_koperasi',
			'data' => $this->m_koperasi->getData($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function simpan()
	{
		$key = input($this->input->post('cif_induk'));
		$method = input($this->input->post('method'));
		$akses = $this->session->userdata('akses_user');

		$rate_bank = preg_replace('/[^0-9.]/', '', $this->input->post('rate_bank'));
		$tenor_bank = preg_replace('/[^0-9]/', '', $this->input->post('tenor_bank'));
		if (is_array(preg_replace('/[^0-9.]/', '', $this->input->post('rate_bank'))) && is_array(preg_replace('/[^0-9]/', '', $this->input->post('tenor_bank')))) {
			$rate_bank = implode("::", preg_replace('/[^0-9.]/', '', $this->input->post('rate_bank')));
			$tenor_bank = implode("::", preg_replace('/[^0-9]/', '', $this->input->post('tenor_bank')));
		}

		$data = array(
			'cif_induk' => $key,
			'nip_user' => $this->session->userdata('nip'),
			'cabang' => $this->session->userdata('cabang'),
			'nama_kop' => input($this->input->post('nama_kop')),
			'npwp' => input($this->input->post('npwp')),
			'rek_agent' => input($this->input->post('rek_agent')),
			'rek_escrow' => input($this->input->post('rek_escrow')),
			'mata_uang' => 'IDR',
			'rate_bank' => $rate_bank,
			'tenor_bank' => $tenor_bank
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

		$qry = $this->m_koperasi->getData($key);

		if ($method == 'add') {
			if ($qry->num_rows() > 0) {
				$this->session->set_flashdata('Error', 'Data koperasi ' . $key . ' telah tersedia!');
				$this->index();
			} else {
				$log['detail'] = "data koperasi " . $key . " - " . $data['nama_kop'] . " berhasil disimpan!";

				$this->m_koperasi->insertData($data);
				$this->db->update(
					'tbl_koperasi', 
					['sisa_nom' => str_replace(',', '', input($this->input->post('nominal'))), 'nominal' => str_replace(',', '', input($this->input->post('nominal')))], 
					['cif_induk' => $key]
				);
				$this->m_log->insert($log);
				$this->session->set_flashdata('Info', 'Data koperasi ' . $key . ' - ' . $data['nama_kop'] . ' berhasil disimpan!');

				$this->index();
			}
		} else {
			if ($akses == 'Reviewer') {
				$this->m_koperasi->updateData($key, ['id_fasilitas' => input($this->input->post('id_fasilitas'))]);
			} else {
				$get_data = $this->db->get_where('tbl_koperasi', ['cif_induk' => $key])->row_array();
				if($get_data['nominal'] < str_replace(',', '', $this->input->post('nominal'))){
					$this->session->set_flashdata('Error', 'Nominal tersedia melebihi nominal awal!');
					$this->index(); return;
				} else {
					$this->db->update('tbl_koperasi', ['sisa_nom' => str_replace(',', '', input($this->input->post('nominal')))], ['cif_induk' => $key]);
					$this->m_koperasi->updateData($key, $data);
				}
			}
			$log['detail'] = "data koperasi " . $key . " - " . $data['nama_kop'] . " berhasil diubah!";

			$this->m_log->insert($log);
			$this->session->set_flashdata('Info', 'Data koperasi ' . $key . ' - ' . $data['nama_kop'] . ' berhasil diubah!');

			$this->index();
		}
	}
}
