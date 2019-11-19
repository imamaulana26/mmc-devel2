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


	function print($id)
	{
		$this->load->library('pdf');
		global $title;
		$fpdf = new PDF('P');
		$title = 'Detail Data Pembiayaan Nasabah';
		$fpdf->SetTitle($title);
		$fpdf->AliasNbPages();

		// page break
		$fpdf->AddPage();
		// load data
		$this->db->select('*')->from('tbl_input a');
		$this->db->join('tbl_induk b', 'b.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_anak c', 'c.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_link d', 'd.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_jaminan e', 'e.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_asset f', 'f.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_koperasi g', 'g.cif_induk = a.cif_induk', 'inner');
		$this->db->join('tbl_kontrak h', 'h.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_cabang i', 'i.kd_cabang = a.kode_cabang', 'inner');
		$this->db->where('a.no_fos', $id);
		$result = $this->db->get();

		$this->db->select('*')->from('tbl_users a');
		$this->db->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		$this->db->where(['a.nip_user' => $this->session->userdata('nip')]);
		$users = $this->db->get();
		// load data

		// echo data user
		$fpdf->SetFont('Times', '', 10);
		foreach ($users->result_array() as $user) {
			$fpdf->Cell(30, 6, 'Nama Cabang');
			$fpdf->Cell(5, 6, ':');
			$fpdf->Cell(50, 6, $user['nama_cabang'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Lengkap');
			$fpdf->Cell(5, 6, ':');
			$fpdf->Cell(50, 6, $user['nama_user'], 0, 1);
			$fpdf->Cell(30, 6, 'Jabatan');
			$fpdf->Cell(5, 6, ':');
			$fpdf->Cell(50, 6, $user['jabatan'], 0, 1);
		}
		$fpdf->SetFont('Times', 'I', 10);
		$fpdf->Cell(30, 6, '*) dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat', 0, 1);
		$fpdf->Cell(30, 6, 'dipertanggung jawabkan.');
		// ech data user
		$fpdf->Ln(10);

		$fpdf->SetFont('Times', '', 10);
		foreach ($result->result_array() as $res) {
			// echo data nasabah
			$fpdf->Cell(30, 6, 'Nama Cabang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_cabang'], 0, 0);
			$fpdf->Cell(30, 6, 'Usulan Tgl. Cair', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(35, 6, '20' . substr($res['no_fos'], 0, 2) . '-' . substr($res['no_fos'], 2, 2) . '-' . substr($res['no_fos'], 4, 2), 0, 1);
			$fpdf->Cell(30, 6, 'Nomor CIF', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif'], 0, 0);
			$fpdf->Cell(30, 6, 'Member Koperasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(30, 6, $res['nip_member_kop'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Nasabah', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_nsbh'], 0, 0);
			$fpdf->Cell(30, 6, 'Nama Koperasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(30, 6, $res['nama_kop'], 0, 0);
			$fpdf->Ln(10);
			// echo data nasabah

			// Fasilitas Induk
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Fasilitas Induk', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Mata Uang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['mata_uang'], 0, 0);
			$fpdf->Cell(30, 6, 'Segmentasi Kriteria', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['segmen'] == 13 ? $res['segmen'] . ' - Pembiayaan Konsumer' : '', 0, 1);
			$fpdf->Cell(30, 6, 'Nominal Fasilitas', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_fasilitas'], 0, '.', ','), 0, 0);
			$fpdf->Cell(30, 6, 'Rating Internal', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rating_int'], 0, 1);
			$fpdf->Cell(30, 6, 'Maks. Penggunaan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_max_guna'], 0, '.', ','), 0, 0);
			$fpdf->Cell(30, 6, 'Rating Eksternal', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rating_eks'] . ' - Tidak ada rating', 0, 1);
			$fpdf->Cell(30, 6, 'Tanggal Nota', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_nota'], 0, 1);
			$fpdf->Cell(30, 6, 'Tanggal SP3', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_sp3'], 0, 1);
			$fpdf->Cell(30, 6, 'Tgl. Jatuh Tempo', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_jth_tempo'], 0, 0);
			$fpdf->Ln(10);
			// Fasilitas Induk

			// Fasilitas Anak
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Fasilitas Anak', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Golongan Piutang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['gol_piutang'] == 19 ? $res['gol_piutang'] . ' - Pembiayaan Konsumer' : $res['gol_piutang'], 0, 0);
			$fpdf->Cell(30, 6, 'Mata Uang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['mata_uang'], 0, 1);
			$lok = $this->db->get_where('tbl_lokasi', ['id' => $res['lokasi_proyek']])->row_array();
			$fpdf->Cell(30, 6, 'Lokasi Proyek', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $lok['id'] . ' - ' . $lok['deskripsi'], 0, 0);
			$fpdf->Cell(30, 6, 'Nominal Fasilitas', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_fasilitas'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Jenis Penggunaan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['jenis_guna'] == 89 ? $res['jenis_guna'] . ' - Kredit Konsumsi Lainnya' : $res['jenis_guna'], 0, 0);
			$fpdf->Cell(30, 6, 'Maks. Penggunaan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_max_guna'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Sifat Pinjaman', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['sifat_pinjam'] == 60 ? $res['sifat_pinjam'] . ' - Piutang Murabahah' : $res['sifat_pinjam'], 0, 1);
			$fpdf->Cell(30, 6, 'Tipe Penggunaan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_guna'] == 3 ? $res['tipe_guna'] . ' - Konsumsi' : $res['tipe_guna'], 0, 1);
			$sek = $this->db->get_where('tbl_sektor', ['id' => $res['sektor_ekonomi']])->row_array();
			$fpdf->Cell(30, 6, 'Sektor Ekonomi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $sek['id'] . ' - ' . $sek['deskripsi'], 0, 1);
			$fpdf->Cell(30, 6, 'Baru/Perpanjangan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			if ($res['status_cair'] == 0) {
				$fpdf->Cell(70, 6, $res['status_cair'] . ' - Baru', 0, 0);
			} else {
				for ($i = 1; $i <= 5; $i++) {
					if ($res['status_cair'] == $i) {
						$fpdf->Cell(70, 6, $res['status_cair'] . ' - Perpanjangan ke-' . $i, 0, 0);
					}
				}
			}
			$fpdf->Ln(10);
			// Fasilitas Anak

			// Pendaftaran Link Jaminan
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Pendaftaran Link Jaminan', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Kode Jaminan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_jaminan'] == 10 ? $res['kode_jaminan'] . ' - Lainnya' : $res['kode_jaminan'], 0, 1);
			$fpdf->Cell(30, 6, 'CIF Nasabah', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Nasabah', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_nsbh'], 0, 1);
			$fpdf->Cell(30, 6, 'CIF Induk', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif_induk'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Koperasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_kop'], 0, 1);
			$fpdf->Cell(30, 6, 'Tgl. Jatuh Tempo', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_jth_tempo'], 0, 0);
			$fpdf->Ln(10);
			// Pendaftaran Link Jaminan

			// Pendaftaran Nilai Jaminan
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Pendaftaran Nilai Jaminan', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Tipe Jaminan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_jaminan'] == 82 ? $res['tipe_jaminan'] . ' - Salary Slip' : $res['tipe_jaminan'], 0, 1);
			$fpdf->Cell(30, 6, 'Tipe Jaminan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_jaminan'] == 82 ? $res['tipe_jaminan'] . ' - Salary Slip' : $res['tipe_jaminan'], 0, 1);
			$fpdf->Cell(30, 6, 'Kode Jaminan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_jaminan'] == 10 ? $res['kode_jaminan'] . ' - Lainnya' : $res['kode_jaminan'], 0, 1);
			$fpdf->Cell(30, 6, 'Deskripsi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['deskripsi'], 0, 1);
			$fpdf->Cell(30, 6, 'Mata Uang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['mata_uang'], 0, 1);
			$fpdf->Cell(30, 6, 'Negara', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['negara'] . ' - INDONESIA', 0, 1);
			$fpdf->Cell(30, 6, 'Tanggal Taksasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, '20' . substr($res['no_fos'], 0, 2) . '-' . substr($res['no_fos'], 2, 2) . '-' . substr($res['no_fos'], 4, 2), 0, 1);
			$fpdf->Cell(30, 6, 'Nilai Pasar', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_fasilitas'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Nilai Likuidasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_fasilitas'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Nilai NJOP', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['njop'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Surat/Bukti ', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['surat_bukti'], 0, 1);
			$fpdf->Cell(30, 6, 'Kepemilikan', 0, 0);
			$fpdf->Ln(10);
			// Pendaftaran Nilai Jaminan

			// Pendaftaran Aset Murabahah
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Pendaftaran Aset Murabahah', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			// Pendaftaran Aset Murabahah

			// give the name file
			$fpdf->Output('I', 'CF-' . $res['nama_nsbh'] . '-20' . substr($res['no_fos'], 0, 6) . '.pdf');
		}
	}
}
