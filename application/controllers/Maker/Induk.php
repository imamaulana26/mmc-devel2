<?php defined('BASEPATH') or exit('No direct script access allowed');
class Induk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_input', 'm_anak', 'm_induk', 'm_log');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_induk()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_induk',
			'data' => $this->m_input->getData($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_induk()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_induk',
			'data' => $this->m_induk->selectJoin($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function simpanData()
	{
		$key = $this->input->post('no_fos');

		$data = array(
			'no_fos' => input($this->input->post('no_fos')),
			'nip_user' => $this->session->userdata('nip'),
			'nip_member_kop' => input($this->input->post('nip')),
			'mata_uang' => input($this->input->post('uang')),
			'nom_max_guna' => str_replace(',', '', input($this->input->post('maks_guna'))),
			'rating_int' => input($this->input->post('rating_int')),
			'rating_eks' => input($this->input->post('rating_eks')),
			'segmen' => input($this->input->post('segmen')),
			'sts_nikah' => input($this->input->post('sts_nikah')),
			'nama_pasangan' => input($this->input->post('nama_pasangan')),
			'tempat_pasangan' => input($this->input->post('tempat_pasangan')),
			'tgl_pasangan' => input($this->input->post('tgl_pasangan'))
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

		if($this->input->post('method') == 'add'){
			$log['detail'] = 'LIMIT-INDUK '.$key.' berhasil disimpan';

			$this->m_induk->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/anak/add_anak/'.$key)));
		} else {
			$log['detail'] = 'LIMIT-INDUK '.$key.' berhasil diubah';

			$this->m_induk->updateData($key, $data);
			$this->m_log->insert($log);

			$cek = $this->db->get_where('tbl_anak', ['no_fos' => $key]);
			if($cek->num_rows() > 0){
				redirect(site_url(ucfirst('maker/anak/edit_anak/'.$key)));
			} else {
				redirect(site_url(ucfirst('maker/anak/add_anak/'.$key)));
			}
		}
	}

	// public function simpanData(){
	// 	$key = input($this->input->post('no_fos'));
	// 	$data = array(
	// 		'no_fos' => input($this->input->post('no_fos')),
	// 		'nip_user' => $this->session->userdata('nip'),
	// 		'nip_member_kop' => input($this->input->post('nip')),
	// 		'mata_uang' => input($this->input->post('uang')),
	// 		'nom_max_guna' => str_replace(',', '', input($this->input->post('maks_guna'))),
	// 		'rating_int' => input($this->input->post('rating_int')),
	// 		'rating_eks' => input($this->input->post('rating_eks')),
	// 		'segmen' => input($this->input->post('segmen')),
	// 		'nama_pasangan' => input($this->input->post('nama_pasangan')),
	// 		'tempat_pasangan' => input($this->input->post('tempat_pasangan')),
	// 		'tgl_pasangan' => input($this->input->post('tgl_pasangan'))
	// 	);

	// 	date_default_timezone_set('Asia/Jakarta');
	// 	$log = array(
	// 		'user_session' => $this->session->userdata('nip'),
	// 		'nama_user' => $this->session->userdata('nama_user'),
	// 		'akses_user' => $this->session->userdata('akses_user'),
	// 		'ip_address' => $_SERVER['REMOTE_ADDR'],
	// 		'browser' => $_SERVER['HTTP_USER_AGENT'],
	// 		'url' => $_SERVER['REQUEST_URI'],
	// 		'waktu' => date('Y-m-d H:i:s')
	// 	);

	// 	$query = $this->m_induk->getData($key);
	// 	if($query->num_rows() > 0){
	// 		$this->m_induk->updateData($key, $data);
	// 		$log['detail'] = 'Berhasil mengubah data pada Fasilitas Induk dengan No.MMC '.$data['no_fos'];
	// 		$this->m_log->insert($log);

	// 		$cek = $this->m_anak->getData($key);
	// 		if($cek->num_rows() > 0){
	// 			redirect(ucfirst('maker/anak/edit_anak/'.$data['no_fos']));
	// 		} else{
	// 			redirect(ucfirst('maker/anak/add_anak/'.$data['no_fos']));
	// 		}
	// 	} else{
	// 		$this->m_induk->insertData($data);
	// 		$log['detail'] = 'Berhasil menambahkan data pada Fasilitas Induk dengan No.MMC '.$data['no_fos'];
	// 		$this->m_log->insert($log);
	// 		redirect(ucfirst('maker/anak/add_anak/'.$data['no_fos']));
	// 	}
	// }
}
