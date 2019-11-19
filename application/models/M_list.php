<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_list extends CI_Model
{
	public function getAllCabang()
	{
		$this->db->select('*')->group_by('kd_cabang');
		$query = $this->db->get('tbl_cabang');
		return $query->result_array();
	}

	public function getAllLokasi()
	{
		$query = $this->db->get('tbl_lokasi');
		return $query->result();
	}

	public function getAllSektor()
	{
		$this->db->select('*')->like('deskripsi', '(Konsumtif)');
		$query = $this->db->get('tbl_sektor');
		return $query->result();
	}

	public function getAllProduk()
	{
		$query = $this->db->get('tbl_produk');
		return $query->result();
	}

	public function getAllKop()
	{
		$query = $this->db->get('tbl_koperasi');
		return $query->result();
	}

	public function getAllUser()
	{
		$query = $this->db->get('tbl_users');
		return $query->result();
	}

	public function getDistKop()
	{
		$akses = $this->session->userdata('akses_user');
		$cabang = $this->session->userdata('cabang');
		$nip = $this->session->userdata('nip');

		if ($akses == 'Maker') {
			$this->db->select('a.*, b.nama_cabang')->from('tbl_koperasi a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
			$this->db->where('a.cabang', $cabang)->group_by('cif_induk');
			$query = $this->db->get();
			return $query;
		} else {
			$query = $this->db->get_where('tbl_users', ['nip_user' => $nip]);
			$result = $query->result_array();

			foreach ($result as $res) {
				$exp = explode("::", $res['jaringan']);

				$this->db->select('a.*, b.nama_cabang')->from('tbl_koperasi a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where('a.cabang', $exp[$i]);
				}
				// $this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
				$this->db->order_by('a.cabang', 'asc');
				$result = $this->db->get();
				return $result;
			}
		}
	}
}
