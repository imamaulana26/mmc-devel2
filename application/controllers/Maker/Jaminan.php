<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Jaminan extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$model = array('m_jaminan','m_asset','m_log');
		foreach($model as $mod){	
			$this->load->model($mod);
		}

		$email = $this->session->userdata('email');
		if(empty($email)){
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_jaminan(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_jaminan',
			'data' => $this->m_jaminan->selectJoin($key),
			'li_jaminan' => array(1=>'CC - Current Account', 2=>'CC - Saving Account', 3=>'CC - Time Deposit', 4=>'CC - Gold (Prec Metal)', 5=>'CC - Gold (Non Prec Metal)', 6=>'CC - Guarantee', 7=>'CC - Non Gold', 10=>'Lainnya', 11=>'Vehicle - Motorcyle', 12=>'Vehicle - Car', 13=>'Vehicle - Ship < 20m3', 14=>'Vehicle - Aircraft', 15=>'Vehicle - Non Ship', 16=>'Vehicle - Others', 17=>'NonCC - Electronic', 21=>'Kredit', 28=>'Dummy', 29=>'Dummy', 30=>'Tanaman Saja', 31=>'Land/Building - Land', 32=>'Land/Building - Houses', 33=>'Land/Building - Trade House/Office', 34=>'Land/Building - Trade Buildg/Offc B', 35=>'Land/Building - Factory Building', 36=>'Land/Building - Storage Building', 37=>'Vehicle - Aircraft', 38=>'Vehicle - Helicopter', 39=>'Vehicle - Ship > 20m3', 40=>'Vehicle - Machines', 41=>'Inventory - Commercial Goods', 42=>'Inventory - Industry Goods', 43=>'Commercial Paper Lainnya', 44=>'Polis Asuransi', 50=>'Personal Garansi (Borgtocht)', 51=>'Commercial Paper - Promes Sales', 52=>'Commercial Paper - COD', 53=>'Commercial Paper - Sharia Bonds', 54=>'Commercial Paper - Promes Endorsed', 55=>'Commercial Paper - Stock', 56=>'Letter of Undertaking', 57=>'SBPU', 58=>'Asuransi - Askrindo', 59=>'Asuransi - Jamkrindo', 60=>'Asuransi - ASEI', 61=>'Asuransi - STACO', 62=>'Asuransi - TAKAFUL', 63=>'Pemerintah - Kemenkop dan UKM', 64=>'Pemerintah - Kementerian Pertanian', 65=>'Asuransi - PT ITPT', 66=>'Pemerintah - DNS Kementerian LH', 67=>'Swiss Contact - Kemitraan dg Pemda', 68=>'Swiss Contact - CSR', 71=>'Other Movable Assets', 72=>'Account Receivable (A/R)', 81=>'Government/Institution/Bank', 82=>'Salary Slip', 83=>'Lembar Putih BPIH', 99=>'Lainnya', 100=>'Contents Customer Portfolio', 200=>'Cash Deposits', 300=>'Guarantee Issued', 400=>'Cover Note Received', 500=>'Commercial Real Estate', 600=>'Private Real Estate', 700=>'Fixed Assets', 800=>'Art', 900=>'Bills')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_jaminan(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_jaminan',
			'data' => $this->m_jaminan->getJoin($key),
			'li_jaminan' => array(1=>'CC - Current Account', 2=>'CC - Saving Account', 3=>'CC - Time Deposit', 4=>'CC - Gold (Prec Metal)', 5=>'CC - Gold (Non Prec Metal)', 6=>'CC - Guarantee', 7=>'CC - Non Gold', 10=>'Lainnya', 11=>'Vehicle - Motorcyle', 12=>'Vehicle - Car', 13=>'Vehicle - Ship < 20m3', 14=>'Vehicle - Aircraft', 15=>'Vehicle - Non Ship', 16=>'Vehicle - Others', 17=>'NonCC - Electronic', 21=>'Kredit', 28=>'Dummy', 29=>'Dummy', 30=>'Tanaman Saja', 31=>'Land/Building - Land', 32=>'Land/Building - Houses', 33=>'Land/Building - Trade House/Office', 34=>'Land/Building - Trade Buildg/Offc B', 35=>'Land/Building - Factory Building', 36=>'Land/Building - Storage Building', 37=>'Vehicle - Aircraft', 38=>'Vehicle - Helicopter', 39=>'Vehicle - Ship > 20m3', 40=>'Vehicle - Machines', 41=>'Inventory - Commercial Goods', 42=>'Inventory - Industry Goods', 43=>'Commercial Paper Lainnya', 44=>'Polis Asuransi', 50=>'Personal Garansi (Borgtocht)', 51=>'Commercial Paper - Promes Sales', 52=>'Commercial Paper - COD', 53=>'Commercial Paper - Sharia Bonds', 54=>'Commercial Paper - Promes Endorsed', 55=>'Commercial Paper - Stock', 56=>'Letter of Undertaking', 57=>'SBPU', 58=>'Asuransi - Askrindo', 59=>'Asuransi - Jamkrindo', 60=>'Asuransi - ASEI', 61=>'Asuransi - STACO', 62=>'Asuransi - TAKAFUL', 63=>'Pemerintah - Kemenkop dan UKM', 64=>'Pemerintah - Kementerian Pertanian', 65=>'Asuransi - PT ITPT', 66=>'Pemerintah - DNS Kementerian LH', 67=>'Swiss Contact - Kemitraan dg Pemda', 68=>'Swiss Contact - CSR', 71=>'Other Movable Assets', 72=>'Account Receivable (A/R)', 81=>'Government/Institution/Bank', 82=>'Salary Slip', 83=>'Lembar Putih BPIH', 99=>'Lainnya', 100=>'Contents Customer Portfolio', 200=>'Cash Deposits', 300=>'Guarantee Issued', 400=>'Cover Note Received', 500=>'Commercial Real Estate', 600=>'Private Real Estate', 700=>'Fixed Assets', 800=>'Art', 900=>'Bills')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function simpanData(){
		$key = input($this->input->post('no_fos'));
		$data = array(
			'no_fos' => $key,
			'nip_user' => $this->session->userdata('nip'),
			'nip_member_kop' => input($this->input->post('nip')),
			'tipe_jaminan' => input($this->input->post('tipe_jaminan')),
			'deskripsi' => input($this->input->post('deskripsi')),
			'negara' => input($this->input->post('negara')),
			'njop' => str_replace(',', '', input($this->input->post('njop'))),
			'nilai_pasar' => str_replace(',', '', input($this->input->post('nilai_pasar'))),
			'nilai_likuidasi' => str_replace(',', '', input($this->input->post('nilai_likuidasi'))),
			'surat_bukti' => input($this->input->post('surat_bukti'))
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

		$cek = $this->db->get_where('tbl_asset', ['no_fos' => $key]);

		if($this->input->post('method') == 'add'){
			$log['detail'] = 'DETAIL-JAMINAN '.$key.' berhasil disimpan';

			$this->m_jaminan->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/asset/add_asset/'.$key)));
		} else {
			$log['detail'] = 'DETAIL-JAMINAN '.$key.' berhasil diubah';

			$this->m_jaminan->updateData($key, $data);
			$this->m_log->insert($log);

			if($cek->num_rows() > 0){
				redirect(site_url(ucfirst('maker/asset/edit_asset/'.$key)));
			} else {
				redirect(site_url(ucfirst('maker/asset/add_asset/'.$key)));
			}
		}

		// $query = $this->m_jaminan->getData($key);
		// if($query->num_rows() > 0){
		// 	$this->m_jaminan->updateData($key, $data);
		// 	$log['detail'] = 'Berhasil mengubah data pada Pendaftaran Nilai Jaminan dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
			
		// 	$cek = $this->m_asset->getData($key);
		// 	if($cek->num_rows() > 0){	
		// 		redirect(ucfirst('maker/asset/edit_asset/'.$data['no_fos']));
		// 	} else{
		// 		redirect(ucfirst('maker/asset/add_asset/'.$data['no_fos']));
		// 	}
		// } else{
		// 	$this->m_jaminan->insertData($data);
		// 	$log['detail'] = 'Berhasil menambahkan data pada Pendaftaran Nilai Jaminan dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
		// 	redirect(ucfirst('maker/asset/add_asset/'.$data['no_fos']));
		// }
	}
}