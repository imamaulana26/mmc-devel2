<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Agent extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('layout/_header');
		$this->load->view('layout/_footer');
		$model = array('m_input','m_induk','m_agent');
		foreach($model as $mod){
			$this->load->model($mod);
		}
		$email = $this->session->userdata('email');
		if(empty($email)){
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function add_agent(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/add_agent',
			'data' => $this->m_input->getData($key)
		);

		$this->load->view('layout/_content', $isi);
	}

	public function edit_agent(){
		$key = $this->uri->segment(4);
		$isi = array(
			'konten' => 'maker/edit_agent',
			'data' => $this->m_agent->selectJoin($key)
		);

		$this->load->view('layout/_content', $isi);
	}

	public function simpanData(){
		$key = input($this->input->post('no_fos'));
		$data = array(
			'nip_member_kop' => input($this->input->post('nip')),
			'nip_user' => $this->session->userdata('nip'),
			'no_fos' => input($this->input->post('no_fos')),
			'tenor_bank' => input($this->input->post('tenor_bank')),
			'rate_bank' => input($this->input->post('rate_bank')),
			'no_skkp' => input($this->input->post('no_skkp')),
			'tgl_komite' => input($this->input->post('tgl_komite')),
			'rek_agent' => input($this->input->post('rek_agent'))
		);

		$query = $this->m_agent->getData($key);
		if($query->num_rows() > 0){
			$this->m_agent->updateData($key, $data);
			redirect(ucfirst('maker/kontrak/edit_kontrak/'.$data['no_fos']));
		} else{
			$this->m_agent->insertData($data);
			redirect(ucfirst('maker/kontrak/add_kontrak/'.$data['no_fos']));
		}
	}
}