<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_kontrak extends CI_Model
{
	public function getAll()
	{
		$query = $this->db->get('tbl_kontrak');
		return $query->result();
	}

	public function getData($key)
	{
		$get = $this->db->get_where('tbl_input', ['no_fos' => $key, 'approve' => '4', 'status' => 'Sukses']);
		if ($get->num_rows() > 0) {
			redirect('NotFound');
		} else {
			$result = $this->db->get_where('tbl_kontrak', ['no_fos' => $key]);
			return $result;
		}
	}

	public function updateData($key, $data)
	{
		$this->db->where('no_fos', $key);
		$this->db->update('tbl_kontrak', $data);
	}

	public function insertData($data)
	{
		$this->db->insert('tbl_kontrak', $data);
	}

	public function selectJoin($key)
	{
		$get = $this->db->get_where('tbl_input', ['no_fos' => $key, 'approve' => '4', 'status' => 'Sukses']);
		if ($get->num_rows() > 0) {
			redirect('NotFound');
		} else {
			$this->db->select('*');
			$this->db->from('tbl_input');
			$this->db->join('tbl_induk', 'tbl_input.no_fos = tbl_induk.no_fos', 'inner');
			$this->db->join('tbl_kontrak', 'tbl_input.no_fos = tbl_kontrak.no_fos', 'inner');
			$this->db->join('tbl_koperasi', 'tbl_input.cif_induk = tbl_koperasi.uniqid', 'inner');
			$this->db->join('tbl_anak', 'tbl_input.no_fos = tbl_anak.no_fos', 'inner');
			$this->db->where('tbl_input.no_fos', $key);
			$query = $this->db->get();
			return $query;
		}
	}

	public function getJoin($key)
	{
		$get = $this->db->get_where('tbl_input', ['no_fos' => $key, 'approve' => '4', 'status' => 'Sukses']);
		if ($get->num_rows() > 0) {
			redirect('NotFound');
		} else {
			$this->db->select('*');
			$this->db->from('tbl_input');
			$this->db->join('tbl_induk', 'tbl_input.no_fos = tbl_induk.no_fos', 'inner');
			$this->db->join('tbl_anak', 'tbl_input.no_fos = tbl_anak.no_fos', 'inner');
			$this->db->join('tbl_koperasi', 'tbl_input.cif_induk = tbl_koperasi.uniqid', 'inner');
			// $this->db->join('tbl_agent', 'tbl_input.no_fos = tbl_agent.no_fos', 'inner');
			$this->db->where('tbl_input.no_fos', $key);
			$query = $this->db->get();
			return $query;
		}
	}
}
