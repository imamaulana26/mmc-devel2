<?php defined('BASEPATH') or exit('No direct script access allowed');
class Asset extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_asset', 'm_kontrak', 'm_log');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}

		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_asset()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_asset',
			'data' => $this->m_asset->selectJoin($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_asset()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_asset',
			'data' => $this->m_asset->getJoin($key)
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function simpanData()
	{
		$key = input($this->input->post('no_fos'));
		$check = '';
		if (!empty($_POST['checkbox'])) $check = 'Y';

		$data = array(
			'no_fos' => $key,
			'nip_member_kop' => input($this->input->post('nip')),
			'nip_user' => $this->session->userdata('nip'),
			'nama_asset' => input($this->input->post('nama_asset')),
			'ket_asset' => input($this->input->post('ket_asset')),
			'harga_asset' => input($this->input->post('harga')),
			'cif_pemasok' => input($this->input->post('cif_pemasok')),
			'nama_pemasok' => input($this->input->post('nama_pemasok')),
			'rek_pemasok' => input($this->input->post('rek_pemasok')),
			'uang_muka' => str_replace(',', '', input($this->input->post('uang_muka'))),
			'jumlah_asset' => input($this->input->post('jumlah_asset')),
			'total_asset' => str_replace(',', '', input($this->input->post('total_asset'))),
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

		if($this->input->post('method') == 'add'){
			$log['detail'] = 'ASET-REG '.$key.' berhasil disimpan';

			$this->m_asset->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/kontrak/add_kontrak/'.$key)));
		} else {
			$log['detail'] = 'ASET-REG '.$key.' berhasil diubah';

			$this->m_asset->updateData($key, $data);
			$this->m_log->insert($log);

			$cek = $this->db->get_where('tbl_kontrak', ['no_fos' => $key]);
			if($cek->num_rows() > 0){
				redirect(site_url(ucfirst('maker/kontrak/edit_kontrak/'.$key)));
			} else {
				redirect(site_url(ucfirst('maker/kontrak/add_kontrak/'.$key)));
			}
		}
	}

	// public function simpanData(){
	// 	$key = input($this->input->post('no_fos'));
	// 	$check = '';
	// 	if(!empty($_POST['checkbox'])){
	// 		$check = 'Y';
	// 	}
	// 	if($this->input->post('rek_pemasok') != "" && is_numeric($this->input->post('rek_pemasok'))){
	// 		$data = array(
	// 			'no_fos' => input($this->input->post('no_fos')),
	// 			'nip_member_kop' => input($this->input->post('nip')),
	// 			'nip_user' => $this->session->userdata('nip'),
	// 			'nama_asset' => input($this->input->post('nama_asset')),
	// 			'ket_asset' => input($this->input->post('ket_asset')),
	// 			'harga_asset' => input($this->input->post('harga')),
	// 			'cif_pemasok' => input($this->input->post('cif_pemasok')),
	// 			'nama_pemasok' => input($this->input->post('nama_pemasok')),
	// 			'rek_pemasok' => input($this->input->post('rek_pemasok')),
	// 			'uang_muka' => str_replace(',', '', input($this->input->post('uang_muka'))),
	// 			'jumlah_asset' => input($this->input->post('jumlah_asset')),
	// 			'total_asset' => str_replace(',', '', input($this->input->post('total_asset'))),
	// 			'check' => $check
	// 		);
	// 	} else{
	// 		echo "<script type='text/javascript'>alert('Ada field yang belum terisi');";
	// 		echo "window.history.back();</script>";
	// 	}

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

	// 	$query = $this->m_asset->getData($key);
	// 	if($query->num_rows() > 0){
	// 		$this->m_asset->updateData($key, $data);
	// 		$log['detail'] = 'Berhasil mengubah data pada Pendaftaran Asset Murabahah dengan No.MMC '.$data['no_fos'];
	// 		$this->m_log->insert($log);

	// 		$cek = $this->m_kontrak->getData($key);
	// 		if($cek->num_rows() > 0){
	// 			redirect(ucfirst('maker/kontrak/edit_kontrak/'.$data['no_fos']));
	// 		} else{
	// 			redirect(ucfirst('maker/kontrak/add_kontrak/'.$data['no_fos']));
	// 		}
	// 		// redirect('maker/agent/edit_agent/'.$data['no_fos']);

	// 	} else{
	// 		$this->m_asset->insertData($data);
	// 		$log['detail'] = 'Berhasil menambahkan data pada Pendaftaran Asset Murabahah dengan No.MMC '.$data['no_fos'];
	// 		$this->m_log->insert($log);
	// 		redirect(ucfirst('maker/kontrak/add_kontrak/'.$data['no_fos']));
	// 		// redirect('maker/agent/add_agent/'.$data['no_fos']);
	// 	}
	// }
}
