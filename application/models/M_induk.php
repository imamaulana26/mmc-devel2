<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_induk extends CI_Model{
	public function getAll(){
		$query = $this->db->get('tbl_induk');
		return $query->result();
	}

	public function getData($key){
		$this->db->where('no_fos', $key);
		$result = $this->db->get('tbl_induk');
		return $result;
	}

	public function updateData($key, $data){
		$this->db->where('no_fos', $key);
		$this->db->update('tbl_induk', $data);
	}

	public function insertData($data){
		$this->db->insert('tbl_induk', $data);
	}

	public function selectJoin($key){
		$this->db->select('*');
		$this->db->from('tbl_input');
		$this->db->join('tbl_induk', 'tbl_input.no_fos = tbl_induk.no_fos', 'inner');
		$this->db->join('tbl_koperasi', 'tbl_input.cif_induk = tbl_koperasi.cif_induk', 'inner');
		$this->db->where('tbl_input.no_fos', $key);
		$query = $this->db->get();
		return $query;
	}
}