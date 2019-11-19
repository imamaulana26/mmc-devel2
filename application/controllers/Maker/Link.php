<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Link extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$model = array('m_input','m_link','m_jaminan','m_log');
		foreach($model as $mod){
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if(empty($email)){
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_link(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_link',
			'data' => $this->m_input->getData($key),
			'list' => array(1=>'Cash Collateral', 10=>'Lainnya', 100=>'Portfolio', 2=>'NonCC-Brg Bergrk', 200=>'Cash Deposits', 3=>'NonCC-Brg Tdk B', 300=>'Guarantee', 4=>'NonCC-Persediaan', 400=>'Cover Note', 5=>'NonCC-Srt Brhrg', 500=>'Commercial RE', 6=>'NonCC-Lain', 600=>'Private RE', 7=>'Ass-Gov As-Pemerintah', 700=>'Fixed Assets', 8=>'Swiss Contact', 800=>'Art Antiques Et', 900=>'Bills Collat')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_link(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_link',
			'data' => $this->m_link->selectJoin($key),
			'list' => array(1=>'Cash Collateral', 10=>'Lainnya', 100=>'Portfolio', 2=>'NonCC-Brg Bergrk', 200=>'Cash Deposits', 3=>'NonCC-Brg Tdk B', 300=>'Guarantee', 4=>'NonCC-Persediaan', 400=>'Cover Note', 5=>'NonCC-Srt Brhrg', 500=>'Commercial RE', 6=>'NonCC-Lain', 600=>'Private RE', 7=>'Ass-Gov As-Pemerintah', 700=>'Fixed Assets', 8=>'Swiss Contact', 800=>'Art Antiques Et', 900=>'Bills Collat')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function simpanData(){
		$key = $this->input->post('no_fos');
		$data = array(
			'no_fos' => $key,
			'nip_user' => $this->session->userdata('nip'),
			'nip_member_kop' => $this->input->post('nip'),
			'alokasi' => $this->input->post('alokasi'),
			'kode_jaminan' => $this->input->post('kode_jaminan'),
			'cif' => $this->input->post('cif_nsbh'),
			'cif_induk' => $this->input->post('cif_induk')
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

		$cek = $this->db->get_where('tbl_jaminan', ['no_fos' => $key]);
		
		if($this->input->post('method') == 'add'){
			$log['detail'] = 'LINK-JAMINAN '.$key.' berhasil disimpan';

			$this->m_link->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/jaminan/add_jaminan/'.$key)));
		} else {
			$log['detail'] = 'LINK-JAMINAN '.$key.' berhasil diubah';

			$this->m_link->updateData($key, $data);
			$this->m_log->insert($log);

			if($cek->num_rows() > 0){
				redirect(site_url(ucfirst('maker/jaminan/edit_jaminan/'.$key)));
			} else {
				redirect(site_url(ucfirst('maker/jaminan/add_jaminan/'.$key)));
			}
		}

		// $query = $this->m_link->getData($key);
		// if($query->num_rows() > 0){
		// 	$this->m_link->updateData($key, $data);
		// 	$log['detail'] = 'Berhasil mengubah data pada Pendaftaran Link Jaminan dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
			
		// 	$cek = $this->m_link->getData($key);
		// 	if($cek->num_rows() > 0){	
		// 		redirect(ucfirst('maker/jaminan/edit_jaminan/'.$data['no_fos']));
		// 	} else{
		// 		redirect(ucfirst('maker/jaminan/add_jaminan/'.$data['no_fos']));
		// 	}
		// } else{
		// 	$this->m_link->insertData($data);
		// 	$log['detail'] = 'Berhasil menambahkan data pada Pendaftaran Link Jaminan dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
		// 	redirect(ucfirst('maker/jaminan/add_jaminan/'.$data['no_fos']));
		// }
	}
}