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
		$this->getResult();
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
		// connect and login to FTP server
		$ftp_server = $this->config->item('ftp_host_srv');
		$ftp_username = $this->config->item('ftp_user_srv');
		$ftp_userpass = $this->config->item('ftp_pass_srv');

		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

		$get_file = $this->db->get_where('tbl_log_file', ['nip_approval' => $this->session->userdata('nip'), 'time_proses' => date('Y-m-d')]);
		// $count = $get_file->num_rows();

		foreach ($get_file->result_array() as $get_file) {
			$local_file = "./result_txt/" . $get_file['file_proses'];
			$server_file = './PROSES/OUT/MMC/' . $get_file['file_proses'];
			// download server file
			$upload = ftp_get($ftp_conn, $local_file, $server_file, FTP_BINARY);
			if (!$upload) {
				$this->session->set_flashdata('Proses', 'file sedang di proses...');
			} else {
				$get_res = $this->db->get_where('tbl_result', ['file_name' => $get_file['file_proses']]);
				// jika file_proses belum ada di tbl_result maka kirim email
				if ($get_res->num_rows() < 1) {
					// Send email
					$this->load->library('email');

					$config = array(
						'mailtype' => 'html',
						'protocol' => $this->config->item('protocol'),
						'smtp_host' => $this->config->item('smtp_host'),
						'smtp_user' => $this->config->item('smtp_user'),
						'smtp_pass' => $this->config->item('smtp_pass'),
						'smtp_port' => 25,
						'newline' => "\r\n"
					);
					$this->email->initialize($config);

					if (file_exists('./result_txt/' . $get_file['file_proses'])) {	// cek apakah file sudah ada di directory atau belum
						$file = file_get_contents('./result_txt/' . $get_file['file_proses']);

						$hasil = strstr(substr(trim($file), 0, -1), 'SUKSES|LD');
						$res = strstr($hasil, 'LD');

						if (!empty($res)) {
							date_default_timezone_set('Asia/Jakarta');
							$data = array(
								'file_name' => $get_file['file_proses'],
								'cabang' => substr($get_file['file_proses'], 13, 9),
								'time_upload' => date('Y-m-d H:i:s'),
								'status' => 'Sukses',
								'no_fos' => substr($get_file['file_proses'], 31, 10),
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
							$this->m_input->updateData($data['no_fos'], $isi);

							// cek apakah nama file sudah ada atau belum
							$this->db->select('*')->from('tbl_input a');
							$this->db->join('tbl_cabang b', 'b.kd_cabang = a.kode_cabang', 'inner');
							$this->db->where(['a.status' => 'Sukses', 'a.no_fos' => $data['no_fos']]);
							$dt_mail = $this->db->get()->row_array();

							$this->db->insert('tbl_result', $data);
							$this->m_log->insert($log);

							// kirim email notifikasi
							// isi pesan
							$msg = "<strong><i>Assalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br><br>";
							$msg .= "<p>Berikut hasil proses pencairan dengan menggunakan Aplikasi MMC <br><br>";
							$msg .= "<table>";
							$msg .= "<tr>";
							$msg .= "<td>No. Aplikasi</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['no_fos'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Koperasi</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_kop'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Nasabah</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_nsbh'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Cabang</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_cabang'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nominal Pencairan</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>Rp. " . number_format($dt_mail['nom_fasilitas'], 0, '', ',') . "</td>";
							$msg .= "</tr>";
							$msg .= "</table>";
							$msg .= "telah berhasil diproses pada " . $data['time_upload'] . " dengan NOLOAN : " . $data['no_loan'] . ".</p><br><br>";
							$msg .= "<strong><i>Wassalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br>";
							$msg .= "<i>*) Harap tidak membalas pesan ini.</i>";

							// update sisa nominal pada koperasi
							$sisa_nom = $this->db->get_where('tbl_koperasi', ['cif_induk' => $dt_mail['cif_induk']])->row_array();
							$this->db->update('tbl_koperasi', ['sisa_nom' => $sisa_nom['sisa_nom'] - $dt_mail['nom_fasilitas']], ['cif_induk' => $dt_mail['cif_induk']]);

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
							// $this->email->to('adminmmc@bsm.co.id');
							$this->email->from('no-reply@bsm.co.id', 'Multiposting Murabahah Chanelling');
							$this->email->subject('Pencairan ' . $res->nama_kop . ' Kepada ' . $res->nama_nsbh . ' Berhasil!');
							$this->email->message($msg);

							if ($this->email->send()) {
								$this->session->set_flashdata('Email', 'hasil proses berhasil dikirim ke email');
								$this->session->unset_userdata('Proses');
							}
						} else {
							date_default_timezone_set('Asia/Jakarta');
							$data = array(
								'file_name' => $get_file['file_proses'],
								'cabang' => substr($get_file['file_proses'], 13, 9),
								'time_upload' => date('Y-m-d H:i:s'),
								'status' => 'Gagal',
								'no_fos' => substr($get_file['file_proses'], 31, 10)
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
							$this->m_input->updateData($data['no_fos'], $isi);

							// cek apakah nama file sudah ada atau belum
							$this->db->select('*')->from('tbl_input a');
							$this->db->join('tbl_cabang b', 'b.kd_cabang = a.kode_cabang', 'inner');
							$this->db->where(['a.status' => 'Gagal', 'a.no_fos' => $data['no_fos']]);
							$dt_mail = $this->db->get()->row_array();

							$this->db->insert('tbl_result', $data);
							$this->m_log->insert($log);

							// kirim email notifikasi
							// isi pesan
							$msg = "<strong><i>Assalamu'alaikum Warahmatullahi Wabarakatuh</i></strong><br><br>";
							$msg .= "<p>Berikut hasil proses pencairan dengan menggunakan Aplikasi MMC <br><br>";
							$msg .= "<table>";
							$msg .= "<tr>";
							$msg .= "<td>No. Aplikasi</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['no_fos'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Koperasi</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_kop'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Nasabah</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_nsbh'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nama Cabang</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>" . $dt_mail['nama_cabang'] . "</td>";
							$msg .= "</tr>";
							$msg .= "<tr>";
							$msg .= "<td>Nominal Pencairan</td>";
							$msg .= "<td>:</td>";
							$msg .= "<td>Rp. " . number_format($dt_mail['nom_fasilitas'], 0, '', ',') . "</td>";
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
							// $this->email->to('adminmmc@bsm.co.id');
							$this->email->from('no-reply@bsm.co.id', 'Multiposting Murabahah Chanelling');
							$this->email->subject('Pencairan ' . $res->nama_kop . ' Kepada ' . $res->nama_nsbh . ' Gagal!');
							$this->email->message($msg);

							if ($this->email->send()) {
								$this->session->set_flashdata('Email', 'hasil proses berhasil dikirim ke email');
								$this->session->unset_userdata('Proses');
							}
						}
					}
				}
			}
		}

		// close connection
		ftp_close($ftp_conn);
	}

	// print detail pembiayaan nasabah
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
		$this->db->join('tbl_koperasi g', 'g.uniqid = a.cif_induk', 'inner');
		$this->db->join('tbl_kontrak h', 'h.no_fos = a.no_fos', 'inner');
		$this->db->join('tbl_cabang i', 'i.kd_cabang = a.kode_cabang', 'inner');
		$this->db->where('a.no_fos', $id);
		$result = $this->db->get();
		// load data

		foreach ($result->result_array() as $res) {
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'U.p.:Yth. RFO Head/AFO Manager/BFO Manager.', 0, 1);
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Perihal : Pencairan a/n ' . $res['nama_nsbh'], 0, 0);
			$fpdf->SetFont('Times', 'I', 10);
			$fpdf->Ln(10);
			$fpdf->Cell(30, 6, 'Assalamu`alaikum Warahmatullahi Wabarakatuh.', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			
			$bln = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
			$tgl_akad = explode('-', $res['tgl_akad']);
			$tgl_pks = explode('-', $res['tgl_pks']);

			$bln_akad = substr($tgl_akad[1], 0, 1) > 0 ? $tgl_akad[1] : substr($tgl_akad[1], -1);
			$bln_pks = substr($tgl_pks[1], 0, 1) > 0 ? $tgl_pks[1] : substr($tgl_pks[1], -1);

			$fpdf->Cell(30, 6, 'Sehubungan dengan telah ditandatanganinya akad pembiayaan tanggal ' . $tgl_akad[2] . ' ' . $bln[$bln_akad] . ' ' . $tgl_akad[0] . ' dan surat nasabah ', 0, 1);
			$fpdf->Cell(30, 6, $res['nama_nsbh'] . ' No. ' . $res['no_pks'] . ' tanngal ' . $tgl_pks[2] . ' ' . $bln[$bln_pks] . ' ' . $tgl_pks[0] . ' agar dilakukan pencairan kepada', 0, 1);
			$fpdf->Cell(30, 6, 'nasabah tersebut. Untuk kebutuhan itu, kami lampirkan data nasabah dan data jaminan pembiayaan/collateral maintenance.', 0, 0);
			$fpdf->Ln(10);

			// echo data nasabah
			$fpdf->SetFont('Times', '', 10);
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
			$fpdf->Cell(30, 6, 'Nama Aset', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_asset'], 0, 0);
			$fpdf->Cell(30, 6, 'Harga Aset', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['harga_asset'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Keterangan Aset', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['ket_asset'], 0, 0);
			$fpdf->Cell(30, 6, 'Uang Muka', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['uang_muka'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'Mata Uang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['mata_uang'], 0, 0);
			$fpdf->Cell(30, 6, 'Jumlah Aset', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['jumlah_asset'] . ' Unit', 0, 1);
			$fpdf->Cell(30, 6, 'Nomor CIF', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif'], 0, 0);
			$fpdf->Cell(30, 6, 'Total Aset', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['total_asset'], 0, '.', ','), 0, 1);
			$fpdf->Cell(30, 6, 'CIF Pemasok', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif_pemasok'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Pemasok', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_pemasok'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Pemasok', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_pemasok'], 0, 0);
			$fpdf->Ln(10);
			// Pendaftaran Aset Murabahah

			// Pendaftaran Agent
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Pendaftaran Agent', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'CIF Induk', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['cif_induk'], 0, 1);
			$fpdf->Cell(30, 6, 'Nama Koperasi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['nama_kop'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Agent', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_agent'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Escrow', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_escrow'], 0, 1);
			$fpdf->Cell(30, 6, 'Tenor Bank', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$exp = explode('::', $res['tenor_bank']);
			if (count($exp) < 1) {
				$fpdf->Cell(70, 6, $exp[0] . ' Bulan', 0, 1);
			} else {
				$fpdf->Cell(70, 6, $exp[0] . ' Bulan', 0, 1);
				for ($i = 1; $i < count($exp); $i++) {
					$fpdf->Cell(35, 6, '', 0, 0);
					$fpdf->Cell(70, 6, $exp[$i] . ' Bulan', 0, 1);
				}
			}
			$fpdf->Cell(30, 6, 'Rate Bank', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$exp = explode('::', $res['rate_bank']);
			if (count($exp) < 1) {
				$fpdf->Cell(70, 6, $exp[0] . ' %', 0, 1);
			} else {
				$fpdf->Cell(70, 6, $exp[0] . ' %', 0, 1);
				for ($i = 1; $i < count($exp); $i++) {
					$fpdf->Cell(35, 6, '', 0, 0);
					$fpdf->Cell(70, 6, $exp[$i] . ' %', 0, 1);
				}
			}
			$fpdf->Cell(30, 6, 'Nomor PKS', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['no_pks'], 0, 1);
			$fpdf->Cell(30, 6, 'Nomor SKKP', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['no_skkp'], 0, 1);
			$fpdf->Cell(30, 6, 'Tgl. Keputusan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_komite'], 0, 1);
			$fpdf->Cell(30, 6, 'Komite', 0, 1);
			$fpdf->Cell(30, 6, 'Tanggal Expire', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_expired'], 0, 0);
			$fpdf->Ln(10);
			// Pendaftaran Agent

			// Kontrak Pembiayaan
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'Kontrak Pembiayaan', 0, 1);
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Tanggal Angsuran', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, strlen($res['tgl_angsuran']) > 1 ? $res['tgl_angsuran'] : '0' . $res['tgl_angsuran'], 0, 0);
			$fpdf->Cell(30, 6, 'Penanda Wakalah', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['wakalah'], 0, 1);
			$fpdf->Cell(30, 6, 'Mata Uang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['mata_uang'], 0, 0);
			$fpdf->Cell(30, 6, 'Tipe Margin', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_margin'] == 1 ? $res['tipe_margin'] . ' - Margin Single' : $res['tipe_margin'], 0, 1);
			$fpdf->Cell(30, 6, 'Nilai Maksimal', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, 'Rp. ' . number_format($res['nom_max_guna'], 0, '.', ','), 0, 0);
			$fpdf->Cell(30, 6, 'Margin', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['margin'] . ' %', 0, 1);
			$fpdf->Cell(105, 6, 'Pembiayaan', 0, 0);
			$fpdf->Cell(105, 6, '(Rate Bank + Fee Agent)', 0, 1);
			$fpdf->Cell(30, 6, 'Tenor', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tenor'] . ' Bulan', 0, 1);
			$fpdf->Cell(30, 6, 'Kode Unit Kerja', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_unit_kerja'] . ' - BBG B2B', 0, 0);
			$fpdf->Cell(30, 6, 'Biaya Teratribusi', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['teratribusi'], 0, 1);
			$fpdf->Cell(30, 6, 'Tipe Produk', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_produk'], 0, 0);
			$fpdf->Cell(30, 6, 'Rekening Biaya', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_biaya'], 0, 1);
			$fpdf->Cell(30, 6, 'Kode Biaya', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$exp_kode = explode('::', $res['kode_biaya']);
			$exp_biaya = explode('::', $res['nom_biaya']);
			$biaya = array(
				'FINAPP' => 'Biaya Penilaian',
				'FINDIS' => 'Biaya Pencairan Murabahah',
				'FININS' => 'Biaya Asuransi',
				'FINNTRY' => 'Biaya Notaris',
				'FINOTH' => 'Biaya Lain-lain',
				'FINSMTP' => 'Biaya Materai'
			);
			if (count($exp_kode) < 1) {
				foreach ($biaya as $key => $val) {
					if ($exp_kode[0] == $key) {
						$fpdf->Cell(70, 6, $key . ' - ' . $val, 0, 0);
						$fpdf->Cell(30, 6, 'Nilai Biaya', 0, 0);
						$fpdf->Cell(5, 6, ':', 0, 0);
						$fpdf->Cell(70, 6, 'Rp. ' . number_format($exp_biaya[0], 0, '', ','), 0, 1);
					}
				}
			} else {
				foreach ($biaya as $key => $val) {
					if ($exp_kode[0] == $key) {
						$fpdf->Cell(70, 6, $key . ' - ' . $val, 0, 0);
						$fpdf->Cell(30, 6, 'Nilai Biaya', 0, 0);
						$fpdf->Cell(5, 6, ':', 0, 0);
						$fpdf->Cell(70, 6, 'Rp. ' . number_format($exp_biaya[0], 0, '', ','), 0, 1);
					}

					for ($i = 1; $i < count($exp_kode); $i++) {
						if ($exp_kode[$i] == $key) {
							$fpdf->Cell(35, 6, '', 0, 0);
							$fpdf->Cell(70, 6, $key . ' - ' . $val, 0, 0);
							$fpdf->Cell(35, 6, '', 0, 0);
							$fpdf->Cell(70, 6, 'Rp. ' . number_format($exp_biaya[$i], 0, '', ','), 0, 1);
						}
					}
				}
			}
			$fpdf->Cell(30, 6, 'Kode AO Kepala', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_pim'], 0, 0);
			$fpdf->Cell(30, 6, 'Status Piutang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['status_piutang'] == 20 ? $res['status_piutang'] . ' - Bkn Dlm Restrukturisasi' : $res['status_piutang'], 0, 1);
			$fpdf->Cell(30, 6, 'Cabang', 0, 1);
			$fpdf->Cell(30, 6, 'Kode AO Risk', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_fao'], 0, 0);
			$fpdf->Cell(30, 6, 'Orientasi Penggunaan', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['orientasi'] == 9 ? $res['orientasi'] . ' - Lainnya' : $res['orientasi'] . ' - Ekspor', 0, 1);
			$fpdf->Cell(30, 6, 'Officer', 0, 1);
			$fpdf->Cell(30, 6, 'Kode AO Marketing', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['kode_ao'], 0, 0);
			$fpdf->Cell(30, 6, 'Sifat Piutang', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['sifat_piutang'] == 1 ? $res['sifat_piutang'] . ' - Dengan Akad' : $res['sifat_piutang'] . ' - Tanpa Akad', 0, 1);
			$segmen = array(
				'CONS' => 'Konsumer (Konsumtif)',
				'INV' => 'Investasi (Produktif)',
				'WCAP' => 'Modal Kerja (Produktif)'
			);
			$fpdf->Cell(30, 6, 'Segmentasi Produk', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			foreach ($segmen as $key => $val) {
				if ($res['segmentasi'] == $key) {
					$fpdf->Cell(70, 6, $key . ' - ' . $val, 0, 0);
				}
			}
			$fpdf->Cell(30, 6, 'Tipe Angsuran', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tipe_angsuran'] == 1 ? $res['tipe_angsuran'] . ' - Efektif Tetap' : $res['tipe_angsuran'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Agent', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_agent'], 0, 0);
			$fpdf->Cell(30, 6, 'Nomor Akad', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['no_akad'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Nasabah', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_nsbh'], 0, 0);
			$fpdf->Cell(30, 6, 'Tanggal Akad', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['tgl_akad'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Pokok', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_pokok'], 0, 1);
			$fpdf->Cell(30, 6, 'Rekening Margin', 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(70, 6, $res['rek_margin'], 0, 0);
			$fpdf->Ln(10);
			// Kontrak Pembiayaan
			$fpdf->SetFont('Times', '', 10);
			$fpdf->Cell(30, 6, 'Demikian atas perhatian dan bantuan Saudara, kami ucapkan terima kasih.', 0, 1);
			$fpdf->SetFont('Times', 'I', 10);
			$fpdf->Cell(30, 6, 'Wassalamu`alaikum Warahmatullahi Wabarakatuh', 0, 0);
			$fpdf->Ln(10);
			$fpdf->SetFont('Times', 'B', 10);
			$fpdf->Cell(30, 6, 'PT BANK SYARIAH MANDIRI', 0, 1);
			$fpdf->Cell(30, 6, $res['nama_cabang'], 0, 0);
			$fpdf->Ln(10);
		}

		// echo data user
		$fpdf->SetFont('Times', '', 10);

		$qry = $this->db->get_where('tbl_input', ['no_fos' => $id])->row_array();
		$n = array($qry['nip_user'], $qry['nip_checker'], $qry['nip_reviewer'], $qry['nip_approval']);

		$this->db->select('akses_user, nama_user, jabatan')->from('tbl_users a');
		$this->db->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		foreach ($n as $n) {
			$this->db->or_where('a.nip_user', $n);
		}
		$users = $this->db->get()->result_array();
		foreach ($users as $user) {
			$fpdf->Cell(20, 6, $user['akses_user'], 0, 0);
			$fpdf->Cell(5, 6, ':', 0, 0);
			$fpdf->Cell(30, 6, $user['nama_user'] . ' / ' . $user['jabatan'], 0, 1);
		}
		// echo data user
		$fpdf->SetFont('Times', 'I', 10);
		$fpdf->Cell(30, 6, '*) Dengan ini kami menyatakan sebenar-benarnya bahwa data pada aplikasi ini sesuai dengan dokumen yang ada dan dapat', 0, 1);
		$fpdf->Cell(30, 6, 'dipertanggung jawabkan.', 0, 1);
		$fpdf->Cell(30, 6, '**) Print out ini tidak memerlukan paraf dan atau tanda tangan basah', 0, 1);

		// give the name file
		$fpdf->Output('I', 'CF-' . $res['nama_nsbh'] . '-20' . substr($res['no_fos'], 0, 6) . '.pdf');
	}
}
