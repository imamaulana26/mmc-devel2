<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_input extends CI_Model
{
	function getAll()
	{
		$query = $this->db->get('tbl_input');
		return $query->result();
	}

	function getData($key)
	{
		$get = $this->db->get_where('tbl_input', ['no_fos' => $key, 'approve' => '4', 'status' => 'Sukses']);
		if ($get->num_rows() > 0) {
			redirect('NotFound');
		} else {
			$this->db->select('*')->from('tbl_input a')->join('tbl_koperasi b', 'a.cif_induk = b.uniqid', 'inner');
			$this->db->where('no_fos', $key);
			$result = $this->db->get();
			return $result;
		}
	}

	function getCif($key)
	{
		$this->db->where('cif', $key);
		$result = $this->db->get('tbl_input');
		return $result;
	}

	function updateData($key, $data)
	{
		$this->db->where('no_fos', $key);
		$this->db->update('tbl_input', $data);
	}

	function insertData($data)
	{
		$this->db->insert('tbl_input', $data);
	}

	function deleteData($key)
	{
		$this->db->where('no_fos', $key);
		$this->db->delete('tbl_input');
	}

	function deleteAll($key)
	{
		$tables = array('tbl_input', 'tbl_induk', 'tbl_link', 'tbl_asset', 'tbl_agent', 'tbl_kontrak', 'tbl_jaminan');
		foreach ($tables as $tabs) {
			$this->db->where($tabs . '.no_fos', $key);
			$this->db->delete($tabs);
		}
	}

	function ubahDetail($key, $data)
	{
		$this->db->where('no_fos', $key);
		$this->db->update('tbl_input', $data);
		return true;
	}
}
