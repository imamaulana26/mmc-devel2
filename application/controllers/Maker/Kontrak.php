<?php defined('BASEPATH') or exit('No direct script access allowed');
class Kontrak extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$model = array('m_input', 'm_induk', 'm_kontrak', 'm_list', 'm_log');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_kontrak()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_kontrak',
			'sektor' => $this->m_list->getAllSektor(),
			'data' => $this->m_kontrak->getJoin($key),
			'produk' => $this->m_list->getAllProduk(),
			'lokasi' => $this->m_list->getAllLokasi(),
			'li_guna' => array(10 => 'Kredit Modal kerja Permanen (KMKP)', 16 => 'Kredit Umum Pedesaan (Kupedes)', 18 => 'Kredit Kelolaan', 25 => 'Kredit Perkebunan Swata Nasional (PSN)', 26 => 'Kredit Ekspor', 28 => 'Modal Kerja - Kredit Koperasi - Kredit Usaha Tani (KUT)', 32 => 'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Unit', 36 => 'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Prim', 38 => 'Modal Kerja - Kredit Koperasi - Lainnya', 39 => 'Kredit modal kerja lainnya', 42 => 'Investasi - Kredit Investasi Kecil (KIK)', 45 => 'Investasi - PIR-BUN - Kredit Kebun Inti', 46 => 'Investasi - PIR-BUN - Kredit Kebun Plasma', 47 => 'Investasi - PIR-BUN - Kredit Pasca Konversi PIR-BUN', 48 => 'Investasi - UPP - Kredit Peremajaan Rehabilitasi Perluasan', 49 => 'Investasi - UPP - Kredit Pasca konversi PRPTE', 50 => 'Investasi - UPP - Lainnya', 51 => 'Investasi - PIR-TRANS - Kredit Kebun Inti', 52 => 'Investasi - PIR-TRANS - Kredit Kebun Plasma', 53 => 'Investasi - PIR-TRANS - Kredit Pasca Konversi', 54 => 'Investasi - Kredit Perkebunan Swasta Nasional (PSN)', 55 => 'Investasi - Bantuan Proyek - Nilai lawan valuta asing', 56 => 'Investasi - Bantuan Proyek - Biaya lokal Rekening Dana Inve', 57 => 'Investasi - Bantuan Proyek - Biaya lokal dana perbankan', 59 => 'Investasi - Kredit kelolaan di luar bantuan proyek', 60 => 'Investasi - Kredit Umum Pedesaan (Kupedes)', 62 => 'Investasi - Kredit Koperasi - Kredit kepada Koperasi Primer', 63 => 'Investasi - Kredit Koperasi - Lainnya', 64 => 'Investasi - DLBS - Nilai lawan valuta asing', 67 => 'Investasi - DLBS - Kredit Rupiah', 74 => 'Investasi - Kredit Investasi sampai dengan Rp 75 juta', 75 => 'Investasi - Kredit Investasi Biasa', 76 => 'Invesatsi - Kredit Ekspor', 79 => 'Investasi - Kredit Investasi Lainnya', 80 => 'KPR Sangat Sederhana(KPRSS) dan Kredit Pemilikan Kapling Si', 81 => 'Pemilikan Rumah KPR Sederhana (KPRS) s.d. tipe 21', 82 => 'Pemilikan Rumah di atas tipe 21 s.d. tipe 70', 83 => 'Pemilikan Rumah di atas tipe 21 s.d. tipe 70', 85 => 'Perbaikan/Pemugaran Rumah', 86 => 'Kredit Kepada Guru untuk Pembelian Sepeda Motor(KPG)', 87 => 'Kredit Mahasiswa Indonesia', 88 => 'Kredit Rumah Toko', 89 => 'Kredit Konsumsi Lainnya')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_kontrak()
	{
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_kontrak',
			'data' => $this->m_kontrak->selectJoin($key),
			'sektor' => $this->m_list->getAllSektor(),
			'produk' => $this->m_list->getAllProduk(),
			'lokasi' => $this->m_list->getAllLokasi(),
			'li_guna' => array(10 => 'Kredit Modal kerja Permanen (KMKP)', 16 => 'Kredit Umum Pedesaan (Kupedes)', 18 => 'Kredit Kelolaan', 25 => 'Kredit Perkebunan Swata Nasional (PSN)', 26 => 'Kredit Ekspor', 28 => 'Modal Kerja - Kredit Koperasi - Kredit Usaha Tani (KUT)', 32 => 'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Unit', 36 => 'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Prim', 38 => 'Modal Kerja - Kredit Koperasi - Lainnya', 39 => 'Kredit modal kerja lainnya', 42 => 'Investasi - Kredit Investasi Kecil (KIK)', 45 => 'Investasi - PIR-BUN - Kredit Kebun Inti', 46 => 'Investasi - PIR-BUN - Kredit Kebun Plasma', 47 => 'Investasi - PIR-BUN - Kredit Pasca Konversi PIR-BUN', 48 => 'Investasi - UPP - Kredit Peremajaan Rehabilitasi Perluasan', 49 => 'Investasi - UPP - Kredit Pasca konversi PRPTE', 50 => 'Investasi - UPP - Lainnya', 51 => 'Investasi - PIR-TRANS - Kredit Kebun Inti', 52 => 'Investasi - PIR-TRANS - Kredit Kebun Plasma', 53 => 'Investasi - PIR-TRANS - Kredit Pasca Konversi', 54 => 'Investasi - Kredit Perkebunan Swasta Nasional (PSN)', 55 => 'Investasi - Bantuan Proyek - Nilai lawan valuta asing', 56 => 'Investasi - Bantuan Proyek - Biaya lokal Rekening Dana Inve', 57 => 'Investasi - Bantuan Proyek - Biaya lokal dana perbankan', 59 => 'Investasi - Kredit kelolaan di luar bantuan proyek', 60 => 'Investasi - Kredit Umum Pedesaan (Kupedes)', 62 => 'Investasi - Kredit Koperasi - Kredit kepada Koperasi Primer', 63 => 'Investasi - Kredit Koperasi - Lainnya', 64 => 'Investasi - DLBS - Nilai lawan valuta asing', 67 => 'Investasi - DLBS - Kredit Rupiah', 74 => 'Investasi - Kredit Investasi sampai dengan Rp 75 juta', 75 => 'Investasi - Kredit Investasi Biasa', 76 => 'Invesatsi - Kredit Ekspor', 79 => 'Investasi - Kredit Investasi Lainnya', 80 => 'KPR Sangat Sederhana(KPRSS) dan Kredit Pemilikan Kapling Si', 81 => 'Pemilikan Rumah KPR Sederhana (KPRS) s.d. tipe 21', 82 => 'Pemilikan Rumah di atas tipe 21 s.d. tipe 70', 83 => 'Pemilikan Rumah di atas tipe 21 s.d. tipe 70', 85 => 'Perbaikan/Pemugaran Rumah', 86 => 'Kredit Kepada Guru untuk Pembelian Sepeda Motor(KPG)', 87 => 'Kredit Mahasiswa Indonesia', 88 => 'Kredit Rumah Toko', 89 => 'Kredit Konsumsi Lainnya')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function simpanData()
	{
		$key = input($this->input->post('no_fos'));
		$akses = $this->session->userdata('akses_user');

		$kode_biaya = $_POST['kode_biaya'];
		$nilai_biaya = preg_replace('/[^0-9]/', '', $_POST['nilai_biaya']);
		if (is_array($_POST['kode_biaya']) && is_array($_POST['nilai_biaya'])) {
			$kode_biaya = implode("::", $_POST['kode_biaya']);
			$nilai_biaya = implode("::", preg_replace('/[^0-9]/', '', $_POST['nilai_biaya']));
		}

		$data = array(
			'no_fos' => $key,
			'nip_user' => $this->session->userdata('nip'),
			'nip_member_kop' => input($this->input->post('nip')),
			'tipe_produk' => input($this->input->post('tipe_produk')),
			'kode_unit_kerja' => input($this->input->post('kode_unit')),
			//'no_limit' => $this->input->post('no_limit'),
			'tipe_angsuran' => input($this->input->post('tipe_angsuran')),
			'segmentasi' => input($this->input->post('segmen_produk')),
			'rek_margin' => input($this->input->post('rek_margin')),
			'wakalah' => input($this->input->post('wakalah')),
			'tipe_margin' => input($this->input->post('tipe_margin')),
			'margin' => input($this->input->post('margin')),
			'teratribusi' => input($this->input->post('teratribusi')),
			'kode_biaya' => $kode_biaya,
			'nom_biaya' => $nilai_biaya,
			// 'total_biaya' => str_replace(',', '', $this->input->post('total_biaya')),
			// 'total_margin' => str_replace(',', '', $this->input->post('total_margin')),
			'rek_biaya' => input($this->input->post('rek_biaya')),
			'status_piutang' => input($this->input->post('stat_piutang')),
			'no_akad' => input($this->input->post('no_akad')),
			'tgl_akad' => input($this->input->post('tgl_akad')),
			'pengusul' => input($this->input->post('pengusul')),
			'pemutus' => input($this->input->post('pemutus')),
			// 'rate_agent' => $this->input->post('rate_agent'),
			'orientasi' => input($this->input->post('orientasi')),
			'sifat_piutang' => input($this->input->post('piutang')),
			'flag_agunan' => 'Y',
			'ratio' => 100,
			'portofolio' => input($this->input->post('portofolio'))
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
			$log['detail'] = 'PEMBIAYAAN '.$key.' berhasil disimpan';

			$this->m_kontrak->insertData($data);
			$this->m_log->insert($log);

			$this->session->set_flashdata('Info', 'Data '.$key.' berhasil disimpan!');
			
			if($akses == 'Reviewer'){
				redirect(site_url(ucfirst('approval/dashboard')));
			} else {
				redirect(site_url(ucfirst('maker/dashboard')));
			}
		} else {
			if($akses == 'Maker') $this->db->update('tbl_input', ['approve' => '1'], ['no_fos' => $key]);
			else $this->db->update('tbl_input', ['approve' => '3'], ['no_fos' => $key]);

			$log['detail'] = 'PEMBIAYAAN '.$key.' berhasil diubah';

			$this->m_kontrak->updateData($key, $data);
			$this->m_log->insert($log);

			$this->session->set_flashdata('Info', 'Data '.$key.' berhasil diubah!');
			
			if($akses == 'Reviewer'){
				redirect(site_url(ucfirst('approval/dashboard')));
			} else {
				redirect(site_url(ucfirst('maker/dashboard')));
			}
		}
	}
}
