<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_result extends CI_Model
{
	function getSukses()
	{
		// ambil data user
		$nip = $this->session->userdata('nip');
		$query = $this->db->get_where('tbl_users', ['nip_user' => $nip]);

		foreach ($query->result_array() as $res) {
			$exp = explode("::", $res['jaringan']);

			// sub-query
			$this->db->select('max(time_upload)')->from('tbl_result');
			// $this->db->where(['status' => 'Sukses', 'timestampdiff(day, time_upload, curdate()) <' => 3]);
			$this->db->group_by('no_fos');
			$subQuery = $this->db->get_compiled_select();

			// main query
			$this->db->select('a.*, d.nama_cabang, c.nama_kop, b.nama_nsbh')->from('tbl_result a');
			for ($i = 0; $i < count($exp); $i++) {
				$this->db->or_where('a.cabang', $exp[$i]);
				$this->db->where("time_upload IN ($subQuery)", null, false);
			}

			$this->db->join('tbl_input b', 'a.no_fos = b.no_fos', 'inner');
			$this->db->join('tbl_koperasi c', 'b.cif_induk = c.cif_induk', 'inner');
			$this->db->join('tbl_cabang d', 'a.cabang = d.kd_cabang', 'inner');
			$this->db->where(['b.status' => 'Sukses', 'b.approve' => '4']);

			$result = $this->db->get();
			return $result;
		}
	}

	function getGagal()
	{
		$nip = $this->session->userdata('nip');
		$query = $this->db->get_where('tbl_users', ['nip_user' => $nip]);

		foreach ($query->result_array() as $res) {
			$exp = explode("::", $res['jaringan']);

			// sub-query
			// timestampdiff menghitung interval hari, jika lebih dari 3 hari maka data tidak di tampilkan
			$this->db->select('max(time_upload)')->from('tbl_result');
			$this->db->where(['timestampdiff(day, time_upload, curdate()) <' => 3, 'status' => 'Gagal']);
			$this->db->group_by('no_fos');
			$subQuery = $this->db->get_compiled_select();

			// main query
			$this->db->select('a.*, d.nama_cabang, c.nama_kop, b.nama_nsbh, b.status')->from('tbl_result a');
			for ($i = 0; $i < count($exp); $i++) {
				$this->db->or_where('a.cabang', $exp[$i]);
				$this->db->where("time_upload IN ($subQuery)", null, false);
			}

			$this->db->join('tbl_input b', 'a.no_fos = b.no_fos', 'inner');
			$this->db->join('tbl_koperasi c', 'b.cif_induk = c.cif_induk', 'inner');
			$this->db->join('tbl_cabang d', 'a.cabang = d.kd_cabang', 'inner');
			$this->db->where(['b.status' => 'Gagal', 'b.approve' => '4']);

			$result = $this->db->get();
			return $result;
		}
	}
}
