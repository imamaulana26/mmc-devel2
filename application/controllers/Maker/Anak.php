<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Anak extends CI_Controller{
	public function __construct(){
		parent::__construct();		
		$model = array('m_input','m_induk','m_anak','m_link','m_list','m_log');
		foreach($model as $mod){
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if(empty($email)){
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_anak(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_anak',
			'data' => $this->m_anak->getJoin($key),
			'lokasi' => $this->m_list->getAllLokasi(),
			'sektor' => $this->m_list->getAllSektor(),
			'li_jns_guna' => array(10=>'Kredit Modal kerja Permanen (KMKP)',16=>'Kredit Umum Pedesaan (Kupedes)',18=>'Kredit Kelolaan',25=>'Kredit Perkebunan Swata Nasional (PSN)',26=>'Kredit Ekspor',28=>'Modal Kerja - Kredit Koperasi - Kredit Usaha Tani (KUT)',32=>'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Unit',36=>'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Prim',38=>'Modal Kerja - Kredit Koperasi - Lainnya',39=>'Kredit modal kerja lainnya',42=>'Investasi - Kredit Investasi Kecil (KIK)',45=>'Investasi - PIR-BUN - Kredit Kebun Inti',46=>'Investasi - PIR-BUN - Kredit Kebun Plasma',47=>'Investasi - PIR-BUN - Kredit Pasca Konversi PIR-BUN',48=>'Investasi - UPP - Kredit Peremajaan Rehabilitasi Perluasan',49=>'Investasi - UPP - Kredit Pasca konversi PRPTE',50=>'Investasi - UPP - Lainnya',51=>'Investasi - PIR-TRANS - Kredit Kebun Inti',52=>'Investasi - PIR-TRANS - Kredit Kebun Plasma',53=>'Investasi - PIR-TRANS - Kredit Pasca Konversi',54=>'Investasi - Kredit Perkebunan Swasta Nasional (PSN)',55=>'Investasi - Bantuan Proyek - Nilai lawan valuta asing',56=>'Investasi - Bantuan Proyek - Biaya lokal Rekening Dana Inve',57=>'Investasi - Bantuan Proyek - Biaya lokal dana perbankan',59=>'Investasi - Kredit kelolaan di luar bantuan proyek',60=>'Investasi - Kredit Umum Pedesaan (Kupedes)',62=>'Investasi - Kredit Koperasi - Kredit kepada Koperasi Primer',63=>'Investasi - Kredit Koperasi - Lainnya',64=>'Investasi - DLBS - Nilai lawan valuta asing',67=>'Investasi - DLBS - Kredit Rupiah',74=>'Investasi - Kredit Investasi sampai dengan Rp 75 juta',75=>'Investasi - Kredit Investasi Biasa',76=>'Invesatsi - Kredit Ekspor',79=>'Investasi - Kredit Investasi Lainnya',80=>'KPR Sangat Sederhana(KPRSS) dan Kredit Pemilikan Kapling Si',81=>'Pemilikan Rumah KPR Sederhana (KPRS) s.d. tipe 21',82=>'Pemilikan Rumah di atas tipe 21 s.d. tipe 70',83=>'Pemilikan Rumah di atas tipe 21 s.d. tipe 70',85=>'Perbaikan/Pemugaran Rumah',86=>'Kredit Kepada Guru untuk Pembelian Sepeda Motor(KPG)',87=>'Kredit Mahasiswa Indonesia',88=>'Kredit Rumah Toko',89=>'Kredit Konsumsi Lainnya'),
			'li_jns_pinjam' => array(10=>'Dalam rangka pembiayaan bersama',15=>'Dalam rangka restrukturisasi kredit',20=>'Penyaluran kredit melalui lembaga lain',30=>'Kartu kredit',40=>'Pengambilalihan kredit',45=>'Surat berharga dengan NPA',50=>'Pembiayaan Musyarakah',55=>'Pembiayaan Mudharabah',60=>'Piutang Murabahah',65=>'Piutang Salam',70=>'Piutang Istishna',79=>'Lainnya dengan PK',80=>'Giro bersaldo debet',85=>'Tagihan atas transaksi perdagangan',99=>'Lainnya tanpa PK'),
			'li_tipe_guna' => array(1=>'MODAL KERJA (Pembiayaan Produktif)',10=>'Modal Kerja - Properti',2=>'INVESTASI (Pembiayaan Produktif)',20=>'Modal Kerja - Agrobisnis',29=>'Modal Kerja - Lainnya',3=>'KONSUMSI (Pembiayaan Konsumtif)',40=>'Investasi - Properti',50=>'Investasi - Agrobisnis',59=>'Investasi - Lainnya',71=>'Konsumsi - Dalam rangka pemilikan rumah/apartemen sampai dengan type',72=>'Konsumsi - Dalam rangka pemilikan rumah/apartemen di atas type 70',80=>'Konsumsi - Dalam rangka pemilikan Rumah Toko (Ruko)/Rumah Kantor',85=>'Konsumsi - Dalam rangka pemilikan kendaraan bermotor',89=>'Konsumsi - Lainnya',98=>'Khusus untuk penjamin kedua dan seterusnya'),
			'li_gol_piutang' => array(10=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Mikro', 19=>'Pembiayaan Konsumtif/Konsumer', 20=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Kecil', 30=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Menengah', 40=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Mikro', 50=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Kecil', 60=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Menengah', 70=>'Debitur UMKM-UMKM Lainnya-Mikro', 80=>'Debitur UMKM-UMKM Lainnya-Kecil', 90=>'Debitur UMKM-UMKM Lainnya-Menengah', 99=>'Pembiayaan Kepada Korporasi/Bukan UMKM')
		);

		ob_start('ob_gzhandler');
		$this->load->view('layout/_header');
		$this->load->view('layout/_content', $isi);
	}

	public function edit_anak(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_anak',
			'data' => $this->m_anak->selectJoin($key),
			'lokasi' => $this->m_list->getAllLokasi(),
			'sektor' => $this->m_list->getAllSektor(),
			'li_jns_guna' => array(10=>'Kredit Modal kerja Permanen (KMKP)',16=>'Kredit Umum Pedesaan (Kupedes)',18=>'Kredit Kelolaan',25=>'Kredit Perkebunan Swata Nasional (PSN)',26=>'Kredit Ekspor',28=>'Modal Kerja - Kredit Koperasi - Kredit Usaha Tani (KUT)',32=>'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Unit',36=>'Modal Kerja - Kredit Koperasi - Kredit kepada Koperasi Prim',38=>'Modal Kerja - Kredit Koperasi - Lainnya',39=>'Kredit modal kerja lainnya',42=>'Investasi - Kredit Investasi Kecil (KIK)',45=>'Investasi - PIR-BUN - Kredit Kebun Inti',46=>'Investasi - PIR-BUN - Kredit Kebun Plasma',47=>'Investasi - PIR-BUN - Kredit Pasca Konversi PIR-BUN',48=>'Investasi - UPP - Kredit Peremajaan Rehabilitasi Perluasan',49=>'Investasi - UPP - Kredit Pasca konversi PRPTE',50=>'Investasi - UPP - Lainnya',51=>'Investasi - PIR-TRANS - Kredit Kebun Inti',52=>'Investasi - PIR-TRANS - Kredit Kebun Plasma',53=>'Investasi - PIR-TRANS - Kredit Pasca Konversi',54=>'Investasi - Kredit Perkebunan Swasta Nasional (PSN)',55=>'Investasi - Bantuan Proyek - Nilai lawan valuta asing',56=>'Investasi - Bantuan Proyek - Biaya lokal Rekening Dana Inve',57=>'Investasi - Bantuan Proyek - Biaya lokal dana perbankan',59=>'Investasi - Kredit kelolaan di luar bantuan proyek',60=>'Investasi - Kredit Umum Pedesaan (Kupedes)',62=>'Investasi - Kredit Koperasi - Kredit kepada Koperasi Primer',63=>'Investasi - Kredit Koperasi - Lainnya',64=>'Investasi - DLBS - Nilai lawan valuta asing',67=>'Investasi - DLBS - Kredit Rupiah',74=>'Investasi - Kredit Investasi sampai dengan Rp 75 juta',75=>'Investasi - Kredit Investasi Biasa',76=>'Invesatsi - Kredit Ekspor',79=>'Investasi - Kredit Investasi Lainnya',80=>'KPR Sangat Sederhana(KPRSS) dan Kredit Pemilikan Kapling Si',81=>'Pemilikan Rumah KPR Sederhana (KPRS) s.d. tipe 21',82=>'Pemilikan Rumah di atas tipe 21 s.d. tipe 70',83=>'Pemilikan Rumah di atas tipe 21 s.d. tipe 70',85=>'Perbaikan/Pemugaran Rumah',86=>'Kredit Kepada Guru untuk Pembelian Sepeda Motor(KPG)',87=>'Kredit Mahasiswa Indonesia',88=>'Kredit Rumah Toko',89=>'Kredit Konsumsi Lainnya'),
			'li_jns_pinjam' => array(10=>'Dalam rangka pembiayaan bersama',15=>'Dalam rangka restrukturisasi kredit',20=>'Penyaluran kredit melalui lembaga lain',30=>'Kartu kredit',40=>'Pengambilalihan kredit',45=>'Surat berharga dengan NPA',50=>'Pembiayaan Musyarakah',55=>'Pembiayaan Mudharabah',60=>'Piutang Murabahah',65=>'Piutang Salam',70=>'Piutang Istishna',79=>'Lainnya dengan PK',80=>'Giro bersaldo debet',85=>'Tagihan atas transaksi perdagangan',99=>'Lainnya tanpa PK'),
			'li_tipe_guna' => array(1=>'MODAL KERJA (Pembiayaan Produktif)',10=>'Modal Kerja - Properti',2=>'INVESTASI (Pembiayaan Produktif)',20=>'Modal Kerja - Agrobisnis',29=>'Modal Kerja - Lainnya',3=>'KONSUMSI (Pembiayaan Konsumtif)',40=>'Investasi - Properti',50=>'Investasi - Agrobisnis',59=>'Investasi - Lainnya',71=>'Konsumsi - Dalam rangka pemilikan rumah/apartemen sampai dengan type',72=>'Konsumsi - Dalam rangka pemilikan rumah/apartemen di atas type 70',80=>'Konsumsi - Dalam rangka pemilikan Rumah Toko (Ruko)/Rumah Kantor',85=>'Konsumsi - Dalam rangka pemilikan kendaraan bermotor',89=>'Konsumsi - Lainnya',98=>'Khusus untuk penjamin kedua dan seterusnya'),
			'li_gol_piutang' => array(10=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Mikro', 19=>'Pembiayaan Konsumtif/Konsumer', 20=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Kecil', 30=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Tertentu-Menengah', 40=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Mikro', 50=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Kecil', 60=>'Debitur UMKM-UMK Jaminan Bersyarat-Penjamin Lainnya-Menengah', 70=>'Debitur UMKM-UMKM Lainnya-Mikro', 80=>'Debitur UMKM-UMKM Lainnya-Kecil', 90=>'Debitur UMKM-UMKM Lainnya-Menengah', 99=>'Pembiayaan Kepada Korporasi/Bukan UMKM')
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
			'gol_piutang' => input($this->input->post('gol_piutang')),
			'sifat_piutang' => input($this->input->post('sifat_piutang')),
			'jenis_guna' => input($this->input->post('jenis_guna')),
			'sektor_ekonomi' => input($this->input->post('sektor_ekon')),
			'sifat_pinjam' => input($this->input->post('sifat_pinjam')),
			'tipe_guna' => input($this->input->post('tipe_guna')),
			'status_cair' => input($this->input->post('status'))
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
			$log['detail'] = 'LIMIT-ANAK '.$key.' berhasil disimpan';

			$this->m_anak->insertData($data);
			$this->m_log->insert($log);

			redirect(site_url(ucfirst('maker/link/add_link/'.$key)));
		} else {
			$log['detail'] = 'LIMIT-ANAK '.$key.' berhasil diubah';

			$this->m_anak->updateData($key, $data);
			$this->m_log->insert($log);

			$cek = $this->db->get_where('tbl_link', ['no_fos' => $key]);
			if($cek->num_rows() > 0){
				redirect(site_url(ucfirst('maker/link/edit_link/'.$key)));
			} else {
				redirect(site_url(ucfirst('maker/link/add_link/'.$key)));
			}
		}

		// $query = $this->m_anak->getData($key);
		// if($query->num_rows() > 0){
		// 	$this->m_anak->updateData($key, $data);
		// 	$log['detail'] = 'Berhasil mengubah data pada Fasilitas Anak dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
			
		// 	$cek = $this->m_link->getData($key);
		// 	if($cek->num_rows() > 0){	
		// 		redirect(ucfirst('maker/link/edit_link/'.$data['no_fos']));
		// 	} else{
		// 		redirect(ucfirst('maker/link/add_link/'.$data['no_fos']));
		// 	}
		// } else{
		// 	$this->m_anak->insertData($data);
		// 	$log['detail'] = 'Berhasil menambahkan data pada Fasilitas Anak dengan No.MMC '.$data['no_fos'];
		// 	$this->m_log->insert($log);
		// 	redirect(ucfirst('maker/link/add_link/'.$data['no_fos']));
		// }
	}
}