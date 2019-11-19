<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_login extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function getLogin($username, $password){
		$this->db->where('email', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('tbl_users');
		if($query->num_rows() > 0){
			return $query->row_array();
		} else{
			$this->session->set_flashdata('msg', 'Email atau Password salah!');
			redirect('login');
		}
	}

	function loginLDAP($username){
		$this->db->where('email', $username);
		$query = $this->db->get('tbl_users');
		if($query->num_rows() > 0){
			return $query->row_array();
		} else{
			$this->session->set_flashdata('msg', 'Email atau Password salah!');
			redirect('login');
		}
	}

	function getData(){
		$query = $this->db->get('tbl_users');
		return $query;
	}

	function update($id, $active){
		$data['active'] = $active;
		$this->db->where('nip_user', $id);
		$this->db->update('tbl_users', $data);
		return true;
	}

	function log_on($id, $log){
		$data['log_on'] = $log;
		$this->db->where('nip_user', $id);
		$this->db->update('tbl_users', $data);
		return true;
	}

	function logout($id, $data){
		$this->db->where('nip_user', $id);
		$this->db->update('tbl_users', $data);
		return true;
	}
}