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
			$this->db->where(['status' => 'Sukses']);
			$this->db->group_by('no_fos');
			$subQuery = $this->db->get_compiled_select();

			// main query
			$this->db->select('a.*, d.nama_cabang, c.nama_kop, b.nama_nsbh')->from('tbl_result a');
			if ($res['akses_user'] == 'Maker') {
				$this->db->where(['a.cabang' => $res['cabang'], 'a.no_loan !=' => '']);
			} else {
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where('a.cabang', $exp[$i]);
					// $this->db->where("time_upload IN ($subQuery)", null, false);
					$this->db->where(['a.no_loan !=' => '']);
				}
			}

			$this->db->join('tbl_input b', 'a.no_fos = b.no_fos', 'inner');
			$this->db->join('tbl_koperasi c', 'b.cif_induk = c.uniqid', 'inner');
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
			$where = "";

			// main query
			$sql = "select * from tbl_input a inner join (";
			$sql .= "select * from tbl_result where file_name in (select max(file_name) from tbl_result where status = 'Gagal' ";
			$sql .= "and timestampdiff(day, time_upload, curdate()) < 3 group by no_fos)) b on a.no_fos = b.no_fos ";
			$sql .= "inner join tbl_koperasi c on a.cif_induk = c.uniqid ";
			$sql .= "inner join tbl_cabang d on d.kd_cabang = a.kode_cabang ";
			if ($res['akses_user'] != 'Maker') {
				for ($i = 0; $i < count($exp); $i++) {
					$where .= "a.kode_cabang = '" . $exp[$i] . "' or ";
				}
				$sql .= "where a.approve = 4 and a.status = 'Gagal' and " . substr($where, 0, -3);
			} else {
				$sql .= "where a.approve = 4 and a.status = 'Gagal' and a.kode_cabang = '" . $res['cabang'] . "'";
			}

			$result = $this->db->query($sql);
			return $result;
		}
	}
}
