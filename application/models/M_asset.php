<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_asset extends CI_Model
{
	public function getAll()
	{
		$query = $this->db->get('tbl_asset');
		return $query->result();
	}

	public function getData($key)
	{
		$get = $this->db->get_where('tbl_input', ['no_fos' => $key, 'approve' => '4', 'status' => 'Sukses']);
		if ($get->num_rows() > 0) {
			redirect('NotFound');
		} else {
			$result = $this->db->get_where('tbl_asset', ['no_fos' => $key]);
			return $result;
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
			$this->db->join('tbl_asset', 'tbl_input.no_fos = tbl_asset.no_fos', 'inner');
			$this->db->where('tbl_input.no_fos', $key);
			$query = $this->db->get();
			return $query;
		}
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
			$this->db->where('tbl_input.no_fos', $key);
			$query = $this->db->get();
			return $query;
		}
	}

	public function updateData($key, $data)
	{
		$this->db->where('no_fos', $key);
		$this->db->update('tbl_asset', $data);
	}

	public function insertData($data)
	{
		$this->db->insert('tbl_asset', $data);
	}
}
