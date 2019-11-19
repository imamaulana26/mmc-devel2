<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_checker extends CI_Model{
	function getData($key){
		$this->db->where('nip', $key);
		$result = $this->db->get('tbl_checker');
		return $result;
	}

	function updateData($key, $data){
		$this->db->where('nip', $key);
		$this->db->update('tbl_checker', $data);
	}

	function insertData($data){
		$this->db->insert('tbl_checker', $data);
	}
}