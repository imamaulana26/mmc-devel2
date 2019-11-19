<?php defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$model = array('m_user', 'm_input', 'm_anak', 'm_dashboard', 'm_login', 'm_list', 'm_result', 'm_log');
		foreach ($model as $mod) {
			$this->load->model($mod);
		}

		$email = $this->session->userdata('email');
		if (empty($email)) {
			$this->session->sess_destroy();
			redirect('login');
		}

		if (!empty($this->session->userdata('filename'))) {
			$this->getResult();
		}
	}

	function index()
	{
		$isi = array(
			'konten' => 'approval/v_dashboard',
			'details' => $this->m_dashboard->details(),
			'kop' => $this->m_dashboard->count_kop(),
			'cif' => $this->m_dashboard->count_cif(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'get_proses' => $this->m_dashboard->get_proses(),
			'get_existing' => $this->m_dashboard->get_existing(),
			'proses_cair' => $this->m_dashboard->proses_cair(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	function result()
	{
		$isi = array(
			'konten' => 'approval/v_pencairan',
			'details' => $this->m_dashboard->details(),
			'kop' => $this->m_dashboard->count_kop(),
			'cif' => $this->m_dashboard->count_cif(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'get_proses' => $this->m_dashboard->get_proses(),
			'get_existing' => $this->m_dashboard->get_existing(),
			'proses_cair' => $this->m_dashboard->proses_cair(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	// approve / reject
	function approve()
	{
		$key = input($this->input->post('no_fos'));

		$data = array(
			'konten' => 'approval/v_approval',
			'get_proses' => $this->m_dashboard->get_proses(),
			'existing' => $this->m_dashboard->get_existing(),
			'kop' => $this->m_dashboard->count_kop(),
			'cif' => $this->m_dashboard->count_cif(),
			'get_approve' => $this->m_dashboard->get_approve(),
			'details' => $this->m_dashboard->details(),
			'proses_cair' => $this->m_dashboard->proses_cair(),
			'getSukses' => $this->m_result->getSukses(),
			'getGagal' => $this->m_result->getGagal()
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $data);

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

		// approve
		if (isset($_POST['approve'])) {
			$cek = $this->db->get_where('tbl_input', ['no_fos' => $key]);
			foreach ($cek->result_array() as $cek) {
				if ($cek['tgl_cair'] == '0000-00-00') {
					$this->session->set_flashdata('Error', 'No. Aplikasi ' . $key . ' belum ada tanggal pencairan!');
					redirect(site_url(ucfirst('approval/dashboard')));
				} else {
					$data = array(
						'no_fos' => $key,
						'nip_reviewer' => $this->session->userdata('nip'),
						'approve' => 3
					);
				}
			}
			$log['detail'] = $key . ' disetujui oleh ' . $this->session->userdata('nip') . '(Reviewer)';
			$this->session->set_flashdata('Info', 'Data ' . $key . ' telah disetujui dan dikirim ke menu Approval');
		}

		// reject
		if (isset($_POST['reject'])) {
			if ($this->session->userdata('akses_user') == 'Reviewer') {
				$data = array(
					'no_fos' => $key,
					'nip_reviewer' => $this->session->userdata('nip'),
					'approve' => 0,
					'status' => ''
				);
				$log['detail'] = $key . ' ditolak oleh ' . $this->session->userdata('nip') . '(Reviewer)';
				$this->session->set_flashdata('Info', 'Data ' . $key . ' telah ditolak dan dikirim ke menu Maker');
			} else {
				$data = array(
					'no_fos' => $key,
					// 'nip_approval' => $this->session->userdata('nip'),
					'approve' => 2,
					'status' => ''
				);
				$log['detail'] = $key . ' ditolak oleh ' . $this->session->userdata('nip') . '(Approval)';
				$this->session->set_flashdata('Info', 'Data ' . $key . ' telah ditolak dan dikirim ke menu Reviewer');
			}
		}

		$query = $this->db->get_where('tbl_kontrak', ['no_fos' => $key]);
		if ($query->num_rows() > 0) {
			$this->m_input->updateData($key, $data);
			$this->m_log->insert($log);
			redirect(site_url(ucfirst('approval/dashboard')));
		}
	}

	// input tgl cair
	function updateDetail()
	{
		$key = input($this->input->post('no_fos'));
		$data = array(
			'nip_reviewer' => $this->session->userdata('nip'),
			'tgl_cair' => input($this->input->post('tgl_cair')),
			'approve' => 3
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

		$this->m_input->updateData($key, $data);
		$log['detail'] = 'Berhasil input tanggal pencairan ' . $data['tgl_cair'] . ' pada No. Aplikasi ' . $key;
		$this->m_log->insert($log);

		$this->session->set_flashdata('Info', "Berhasil input tanggal pencairan " . $data['tgl_cair'] . " pada No. Aplikasi " . $key);
		redirect(site_url(ucfirst('approval/dashboard/approve')));
	}

	// send file txt to ftp (success)
	public function send_ftp()
	{
		$key = $this->uri->segment(4);
		$this->db->select("*");
		$this->db->from("tbl_input");
		$this->db->join("tbl_induk", "tbl_induk.no_fos = tbl_input.no_fos", "inner");
		$this->db->join("tbl_anak", "tbl_anak.no_fos = tbl_input.no_fos", "inner");
		$this->db->join("tbl_link", "tbl_link.no_fos = tbl_input.no_fos", "inner");
		$this->db->join("tbl_jaminan", "tbl_jaminan.no_fos = tbl_input.no_fos", "inner");
		$this->db->join("tbl_asset", "tbl_asset.no_fos = tbl_input.no_fos", "inner");
		$this->db->join("tbl_koperasi", "tbl_koperasi.cif_induk = tbl_input.cif_induk", "inner");
		$this->db->join("tbl_kontrak", "tbl_kontrak.no_fos = tbl_input.no_fos", "inner");
		$this->db->where("tbl_input.no_fos", $key);
		$query = $this->db->get();

		foreach ($query->result() as $list) {

			if (strlen($list->kode) > 1) $kode = $list->kode;
			else $kode = '0' . $list->kode;

			$filename = date('Ymd', strtotime($list->tgl_cair)) . "-MMC-" . trim($list->kode_cabang) . "-" . $list->tipe_produk . "-" . $list->no_fos . "-DISBURSE-" . $kode . ".txt";

			$sess = ['filename' => $filename];
			$this->session->set_userdata($sess);

			$isi = "LIMIT-INDUK*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "|" . $list->mata_uang . "|" . date('Ymd', strtotime($list->tgl_nota)) . "|" . $list->nom_fasilitas . "|" . date('Ymd', strtotime($list->tgl_sp3)) . "|" . $list->nom_max_guna . "|" . date('Ymd', strtotime($list->tgl_cair)) . "|" . $list->segmen . "|" . date('Ymd', strtotime($list->tgl_cair)) . "|" . $list->rating_int . "|" . date('Ymd', strtotime($list->tgl_jth_tempo)) . "|" . $list->rating_eks . "|||||||" . "\r\n";

			/*$isi .= "AGEN-REG*".date('Ymd', strtotime($list->tgl_cair))."-".$list->cif."-".$list->no_fos."|".$list->nama_kop."|".$list->mata_uang."|".$list->nom_fasilitas."||".$list->nom_fasilitas."|".date('Ymd', strtotime($list->tgl_expired))."|".$list->cif_pemasok."|".$list->tenor_bank."|".$list->rate_bank."|".$list->rek_agent."|||".$list->no_pks."|".$list->no_skkp."|".date('Ymd', strtotime($list->tgl_komite))."|"."\r\n";*/

			$isi .= "LIMIT-ANAK*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "|" . $list->nama_nsbh . "|" . $list->mata_uang . "|" . $list->nom_fasilitas . "|" . date('Ymd', strtotime($list->tgl_cair)) . "|" . $list->nom_max_guna . "|" . date('Ymd', strtotime($list->tgl_jth_tempo)) . "|" . $list->id_fasilitas . "|||" . $list->orientasi . "|" . $list->sifat_piutang . "|" . $list->gol_piutang . "|" . $list->lokasi_proyek . "|" . $list->jenis_guna . "|" . $list->sektor_ekonomi . "|" . $list->sifat_pinjam . "|" . $list->tipe_guna . "|" . $list->status_cair . "|" . $list->nom_fasilitas . "||||" . $list->no_pks . "|" . date('Ymd', strtotime($list->tgl_cair)) . "|||||||" . "\r\n";

			$isi .= "LINK-JAMINAN*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "-" . $kode . "|" . $list->kode_jaminan . "||" . $list->cif . "|" . $list->alokasi . "|" . date('Ymd', strtotime($list->tgl_cair)) . "||" . date('Ymd', strtotime($list->tgl_jth_tempo)) . "|||" . "\r\n";

			$isi .= "DETAIL-JAMINAN*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "-" . $kode . "|" . $list->tipe_jaminan . "|" . $list->deskripsi . "|||" . $list->mata_uang . "|" . $list->negara . "|" . $list->nom_fasilitas . "|" . $list->nom_fasilitas . "|" . $list->njop . "|" . date('Ymd', strtotime($list->tgl_cair)) . "||" . date('Ymd', strtotime($list->tgl_jth_tempo)) . "|" . $list->alamat . "|||" . $list->surat_bukti . "||||||||||||||" . "\r\n";

			$isi .= "ASET-REG*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "|" . $list->nama_asset . "|" . $list->ket_asset . "|" . $list->cif . "|" . $list->mata_uang . "||" . $list->cif_pemasok . "|" . $list->nama_kop . "|" . $list->rek_agent . "|" . $list->harga_asset . "|" . $list->uang_muka . "|" . $list->jumlah_asset . "|" . $list->total_asset . "|" . "\r\n";

			// Versi 1. Mapping Excel
			/*$isi .= "PEMBIAYAAN*".date('Ymd', strtotime($list->tgl_cair))."-".$list->cif."-".$list->no_fos."|".$list->cif."|".$list->tgl_angsuran."|".$list->mata_uang."|".$list->tipe_produk."|||".$list->nom_max_guna."|".$list->kode_unit_kerja."|".$list->kode_ao."|".$list->kode_fao."|".$list->kode_pim."||".$list->tenor."|".($list->tipe_angsuran+1)."|".$list->pengusul."|".$list->pemutus."|".$list->rate_agent."|".$list->rek_agent."|".$list->no_sp3."|".$list->segmentasi."||".$list->rek_nsbh."|".$list->rek_pokok."|".$list->rek_margin."|".$list->wakalah."|".$list->tipe_margin."|||".$list->margin."||".$list->total_margin."|".$list->teratribusi."|".$list->kode_biaya."|".$list->nom_biaya."||".$list->rek_biaya."||||".$list->flag_agunan."||".$list->ratio."|".$list->status_piutang."|||".$list->gol_piutang."|35||||||||||||".$list->lokasi_proyek."|||||||||||".$list->gaji_thn."|||".$list->sektor_ekonomi."|".$list->jenis_guna."||||"."\r\n";*/

			// Versi 2. Mapping Core Banking
			$isi .= "PEMBIAYAAN*" . date('Ymd', strtotime($list->tgl_cair)) . "-" . $list->cif . "-" . $list->no_fos . "|" . $list->cif . "|" . $list->tgl_angsuran . "|" . $list->mata_uang . "|" . $list->tipe_produk . "|||" . $list->nom_max_guna . "|" . $list->kode_unit_kerja . "|" . $list->kode_ao . "|" . $list->kode_fao . "|" . $list->kode_pim . "||" . $list->tenor . "|" . $list->tipe_angsuran . "|" . $list->pengusul . "|" . $list->pemutus . "|" . $list->rate_agent . "|" . $list->rek_agent . "|" . $list->no_sp3 . "|" . $list->segmentasi . "||" . $list->rek_nsbh . "|" . $list->rek_pokok . "|" . $list->rek_margin . "|" . $list->wakalah . "|" . $list->tipe_margin . "|||" . $list->margin . "|||" . $list->teratribusi . "|" . $list->kode_biaya . "|" . $list->nom_biaya . "||" . $list->rek_biaya . "||||" . $list->flag_agunan . "||" . $list->ratio . "|" . $list->status_piutang . "|||" . $list->gol_piutang . "|" . $list->portofolio . "||||||||||||" . $list->gaji_thn . "|||" . $list->sektor_ekonomi . "|" . $list->jenis_guna . "||" . $list->lokasi_proyek . "|||" . "\r\n";

			// path file
			$path = './log_txt/' . $filename;

			// Cek apakah nama file sudah ada apa belum
			if (!file_exists($path)) {
				// jika belum ada maka tulis file
				$handle = fopen($path, "w");
				// menulis file
				fwrite($handle, $isi);
				// path of local server
				$source = $path;
				$this->load->library('ftp');
				$ftp_config = array(
					'hostname' => $this->config->item('ftp_host_local'),
					'username' => $this->config->item('ftp_user_local'),
					'password' => $this->config->item('ftp_pass_local'),
					'debug' => true
				);
				$this->ftp->connect($ftp_config);
				// path of remote server (FTP)
				$destination = './' . $filename;
				$this->ftp->upload($source, $destination);

				echo "<script type='text/javascript'>alert('File berhasil terkirim ke ftp');";
				echo "window.location.href='" . site_url(ucfirst('approval/dashboard/approve')) . "';</script>";
				$data = array(
					'nip_approval' => $this->session->userdata('nip'),
					'approve' => '4'
				);
				$this->m_input->updateData($key, $data);

				$update = array(
					'nip_approval' => $this->session->userdata('nip'),
					'file_proses' => $filename,
					'time_proses' => date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_log_file', $update);
			} else {
				echo "<script type='text/javascript'>alert('File sudah pernah diproses');";
				echo "window.location.href='" . site_url(ucfirst('approval/dashboard/approve')) . "';</script>";
			}

			$this->ftp->close();
		}
	}

	function getResult()
	{
		$filename = $this->session->userdata('filename');
		$no_fos = substr($filename, 31, 10);

		// if (!empty($filename) && !empty($no_fos)) {
		// connect and login to FTP server
		$ftp_server = $this->config->item('ftp_host_srv');
		$ftp_username = $this->config->item('ftp_user_srv');
		$ftp_userpass = $this->config->item('ftp_pass_srv');

		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

		$get_file = $this->db->get_where('tbl_log_file', ['nip_approval' => $this->session->userdata('nip')]);
		foreach ($get_file->result_array() as $file) {
			$local_file = "./result_txt/" . $file['file_proses'];
			$server_file = './PROSES/OUT/MMC/' . $file['file_proses'];
			// download server file
			$upload = ftp_get($ftp_conn, $local_file, $server_file, FTP_BINARY);

			if (!$upload) {
				$this->session->set_flashdata('Proses', $get_file->num_rows().' File sedang di proses...');
			} else {
				$get_file = $this->db->get_where('tbl_result', ['file_name' => $file['file_proses']]);
				if ($get_file->num_rows() > 0) {
					$this->send_mail();
				}
			}
		}

		// close connection
		ftp_close($ftp_conn);
		// }
	}

	// Send email sukses
	function send_mail()
	{
		$this->load->library('email');
		$filename = $this->session->userdata('filename');

		$config = array(
			'mailtype' => 'html',
			'protocol' => 'mail',
			'smtp_host' => 'webmail.syariahmandiri.co.id',
			'smtp_user' => 'adminmmc@syariahmandiri.co.id',
			'smtp_pass' => 'Bsm123',
			'smtp_port' => 25,
			'newline' => "\r\n"
		);
		$this->email->initialize($config);

		if (file_exists('./result_txt/' . $filename)) {	// cek apakah file sudah ada di directory atau belum
			$file = file_get_contents('./result_txt/' . $filename);

			$hasil = strstr(substr(trim($file), 0, -1), 'SUKSES|LD');
			$res = strstr($hasil, 'LD');

			if (!empty($res)) {
				date_default_timezone_set('Asia/Jakarta');
				$data = array(
					'file_name' => $filename,
					'cabang' => substr($filename, 13, 9),
					'time_upload' => date('Y-m-d H:i:s'),
					'status' => 'Sukses',
					'no_fos' => substr($filename, 31, 10),
					'no_loan' => $res
				);

				$log = array(
					'user_session' => $this->session->userdata('nip'),
					'nama_user' => $this->session->userdata('nama_user'),
					'akses_user' => $this->session->userdata('akses_user'),
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'browser' => $_SERVER['HTTP_USER_AGENT'],
					'url' => $_SERVER['REQUEST_URI'],
					'waktu' => date('Y-m-d H:i:s'),
					'detail' => 'Pencairan ' . $data['file_name'] . ' sukses dengan NOLOAN ' . $data['no_loan']
				);

				$isi = ['status' => 'Sukses'];

				// cek apakah nama file sudah ada atau belum
				$this->db->select('*')->from('tbl_input a');
				$this->db->join('tbl_cabang b', 'b.kd_cabang = a.kode_cabang', 'inner');
				$this->db->where(['a.status' => 'Sukses', 'a.no_fos' => $data['no_fos']]);
				$dt_mail = $this->db->get()->result();

				$this->db->insert('tbl_result', $data);
				$this->m_log->insert($log);
				$this->m_input->updateData($data['no_fos'], $isi);

				// kirim email notifikasi
				// isi pesan
				$msg = "<strong><i>Assalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br><br>";
				$msg .= "<p>Berikut hasil proses pencairan dengan menggunakan Aplikasi MMC <br><br>";
				$msg .= "<table>";
				$msg .= "<tr>";
				$msg .= "<td>No. Aplikasi</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->no_fos . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Koperasi</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_kop . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Nasabah</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_nsbh . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Cabang</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_cabang . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nominal Pencairan</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>Rp. " . number_format($dt_mail[0]->nom_fasilitas, 0, '', ',') . "</td>";
				$msg .= "</tr>";
				$msg .= "</table>";
				$msg .= "telah berhasil diproses pada " . $data['time_upload'] . " dengan NOLOAN : " . $data['no_loan'] . ".</p><br><br>";
				$msg .= "<strong><i>Wassalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br>";
				$msg .= "<i>*) Harap tidak membalas pesan ini.</i>";

				// kirim email ke user maker, checker, reviewer, approval
				$this->db->select('*')->from('tbl_input')->where('no_fos', $data['no_fos']);
				$query = $this->db->get();
				$result = $query->result();

				$mail = "";
				foreach ($result as $res) {
					$this->db->select('*')->from('tbl_users');
					$nip = array($res->nip_checker, $res->nip_user, $res->nip_reviewer, $res->nip_approval);
					foreach ($nip as $n) {
						$this->db->or_where('nip_user', $n);
					}
					$result = $this->db->get();

					foreach ($result->result() as $dt) {
						$mail .= $dt->email . ', ';
					}
				}

				$this->email->to(str_replace('syariahmandiri', 'bsm', substr($mail, 0, -2)));
				$this->email->from('no-reply@bsm.co.id', 'Multiposting Murabahah Chanelling');
				$this->email->subject('Pencairan ' . $res->nama_kop . ' Kepada ' . $res->nama_nsbh . ' Berhasil!');
				$this->email->message($msg);

				if ($this->email->send()) {
					$this->session->set_flashdata('Email', 'Hasil proses berhasil dikirim ke email');
					$this->session->unset_userdata('filename');
				}
			} else {
				date_default_timezone_set('Asia/Jakarta');
				$data = array(
					'file_name' => $filename,
					'cabang' => substr($filename, 13, 9),
					'time_upload' => date('Y-m-d H:i:s'),
					'status' => 'Gagal',
					'no_fos' => substr($filename, 31, 10)
				);

				$log = array(
					'user_session' => $this->session->userdata('nip'),
					'nama_user' => $this->session->userdata('nama_user'),
					'akses_user' => $this->session->userdata('akses_user'),
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'browser' => $_SERVER['HTTP_USER_AGENT'],
					'url' => $_SERVER['REQUEST_URI'],
					'waktu' => date('Y-m-d H:i:s'),
					'detail' => 'Pencairan ' . $data['file_name'] . ' gagal'
				);

				$isi = ['status' => 'Gagal'];

				// cek apakah nama file sudah ada atau belum
				$this->db->select('*')->from('tbl_input a');
				$this->db->join('tbl_cabang b', 'b.kd_cabang = a.kode_cabang', 'inner');
				$this->db->where(['a.status' => 'Gagal', 'a.no_fos' => $data['no_fos']]);
				$dt_mail = $this->db->get()->result();

				$this->db->insert('tbl_result', $data);
				$this->m_log->insert($log);
				$this->m_input->updateData($data['no_fos'], $isi);

				// kirim email notifikasi
				// isi pesan
				$msg = "<strong><i>Assalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br><br>";
				$msg .= "<p>Berikut hasil proses pencairan dengan menggunakan Aplikasi MMC <br><br>";
				$msg .= "<table>";
				$msg .= "<tr>";
				$msg .= "<td>No. Aplikasi</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->no_fos . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Koperasi</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_kop . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Nasabah</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_nsbh . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nama Cabang</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>" . $dt_mail[0]->nama_cabang . "</td>";
				$msg .= "</tr>";
				$msg .= "<tr>";
				$msg .= "<td>Nominal Pencairan</td>";
				$msg .= "<td>:</td>";
				$msg .= "<td>Rp. " . number_format($dt_mail[0]->nom_fasilitas, 0, '', ',') . "</td>";
				$msg .= "</tr>";
				$msg .= "</table>";
				$msg .= "telah gagal diproses pada " . $data['time_upload'] . " mohon periksa lagi saat kelengkapan / pengisian data.</p><br><br>";
				$msg .= "<strong><i>Wassalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br>";
				$msg .= "<i>*) Harap tidak membalas pesan ini.</i>";

				// kirim email ke user maker, checker, reviewer, approval
				$this->db->select('*')->from('tbl_input')->where('no_fos', $data['no_fos']);
				$query = $this->db->get();
				$result = $query->result();

				$mail = "";
				foreach ($result as $res) {
					$this->db->select('*')->from('tbl_users');
					$nip = array($res->nip_checker, $res->nip_user, $res->nip_reviewer, $res->nip_approval);
					foreach ($nip as $n) {
						$this->db->or_where('nip_user', $n);
					}
					$result = $this->db->get();

					foreach ($result->result() as $dt) {
						$mail .= $dt->email . ', ';
					}
				}

				$this->email->to(str_replace('syariahmandiri', 'bsm', substr($mail, 0, -2)));
				$this->email->from('no-reply@bsm.co.id', 'Multiposting Murabahah Chanelling');
				$this->email->subject('Pencairan ' . $res->nama_kop . ' Kepada ' . $res->nama_nsbh . ' Gagal!');
				$this->email->message($msg);

				if ($this->email->send()) {
					$this->session->set_flashdata('Email', 'Hasil proses berhasil dikirim ke email');
					$this->session->unset_userdata('filename');
				}
			}
		}
	}
}
