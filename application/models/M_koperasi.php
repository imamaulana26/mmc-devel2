<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_koperasi extends CI_Model{
	function getAllKop(){
		$this->db->where('cabang', $this->session->userdata('cabang'));
		$query = $this->db->get('tbl_koperasi');
		return $query;
	}

	function getAll(){
		$query = $this->db->get('tbl_koperasi');
		return $query;
	}

	function getData($key){
		$this->db->where('uniqid', $key);
		$result = $this->db->get('tbl_koperasi');
		return $result;
	}

	function updateData($key, $data){
		$this->db->where('uniqid', $key);
		$this->db->update('tbl_koperasi', $data);
	}

	function insertData($data){
		$this->db->insert('tbl_koperasi', $data);
	}
}