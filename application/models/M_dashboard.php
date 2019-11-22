<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_dashboard extends CI_Model
{
	// =======================================================================================================

	function details()
	{
		$key = $this->session->userdata('nip');
		$akses = $this->session->userdata('akses_user');

		if ($akses == 'Maker') {
			$this->db->select('*')->from('tbl_input')->where(['tbl_input.nip_user' => $key]);
			$tables = array('tbl_induk', 'tbl_anak', 'tbl_asset', 'tbl_jaminan', 'tbl_kontrak', 'tbl_link');
			foreach ($tables as $tab) {
				$this->db->join($tab, $tab . '.no_fos = tbl_input.no_fos', 'inner');
			}
			$this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
			$this->db->join('tbl_users', 'tbl_users.nip_user = tbl_input.nip_user', 'inner');
			$this->db->join('tbl_cabang', 'tbl_cabang.kd_cabang = tbl_input.kode_cabang', 'inner');
			$this->db->order_by('tbl_input.no_fos', 'desc');
			$result = $this->db->get();
			return $result;
		} else {
			$qry = $this->db->get_where('tbl_users', ['nip_user' => $key]);

			foreach ($qry->result_array() as $res) {
				$exp = explode("::", $res['jaringan']);

				$tables = array('tbl_induk', 'tbl_anak', 'tbl_asset', 'tbl_jaminan', 'tbl_kontrak', 'tbl_link');
				$this->db->select('*')->from('tbl_input');
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where('kode_cabang', $exp[$i]);
				}
				foreach ($tables as $tab) {
					$this->db->join($tab, $tab . '.no_fos = tbl_input.no_fos', 'inner');
				}
				$this->db->join('tbl_users', 'tbl_users.nip_user = tbl_input.nip_user', 'inner');
				$this->db->join('tbl_cabang', 'tbl_cabang.kd_cabang = tbl_input.kode_cabang', 'inner');
				$this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
				$this->db->order_by('tbl_input.no_fos', 'desc');
				$result = $this->db->get();
				return $result;
			}
		}
	}

	function get_proses()
	{
		$akses = $this->session->userdata('akses_user');

		$this->db->select('*')->from('tbl_input a')->join('tbl_cabang b', 'a.kode_cabang = b.kd_cabang', 'inner');
		if ($akses == 'Maker' || $akses == 'Checker') {
			$this->db->where(['a.approve' => '1']);
		} elseif ($akses == 'Reviewer') {
			$this->db->where(['a.approve' => '2']);
		} else {
			$this->db->where(['a.approve' => '3']);
		}

		$result = $this->db->get();
		return $result;
	}

	function proses_cair()
	{
		$akses = $this->session->userdata('akses_user');

		$this->db->select('*')->from('tbl_input');
		$tables = array('tbl_induk', 'tbl_anak', 'tbl_asset', 'tbl_jaminan', 'tbl_kontrak', 'tbl_link');
		foreach ($tables as $tab) {
			$this->db->join($tab, $tab . '.no_fos = tbl_input.no_fos', 'inner');
		}
		$this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
		$this->db->join('tbl_users', 'tbl_users.nip_user = tbl_input.nip_user', 'inner');
		$this->db->join('tbl_cabang', 'tbl_cabang.kd_cabang = tbl_input.kode_cabang', 'inner');

		if($akses == 'Reviewer'){
			$this->db->where(['tbl_input.tgl_cair' => '0000-00-00', 'tbl_koperasi.id_fasilitas !=' => '', 'tbl_input.approve >' => '1']);
		} else {
			$this->db->where(['tbl_input.approve' => '3']);
		}

		$result = $this->db->get();
		return $result;
	}

	function get_existing()
	{
		$nip = $this->session->userdata('nip');
		$akses = $this->session->userdata('akses_user');

		if ($akses == 'Maker') {
			$this->db->select('*')->from('tbl_input')->where(['tbl_input.nip_user' => $nip]);
			$tables = array('tbl_induk', 'tbl_anak', 'tbl_asset', 'tbl_jaminan', 'tbl_kontrak', 'tbl_link');
			foreach ($tables as $tab) {
				$this->db->join($tab, $tab . '.no_fos = tbl_input.no_fos', 'inner');
			}
			$this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
			$this->db->join('tbl_users', 'tbl_users.nip_user = tbl_input.nip_user', 'inner');
			$this->db->join('tbl_cabang', 'tbl_cabang.kd_cabang = tbl_input.kode_cabang', 'inner');
			$this->db->order_by('tbl_input.no_fos', 'desc');
			$result = $this->db->get();
			return $result;
		} else {
			$qry = $this->db->get_where('tbl_users', ['nip_user' => $nip]);

			foreach ($qry->result_array() as $res) {
				$exp = explode("::", $res['jaringan']);

				$tables = array('tbl_induk', 'tbl_anak', 'tbl_asset', 'tbl_jaminan', 'tbl_kontrak', 'tbl_link');
				$this->db->select('*')->from('tbl_input');
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where('kode_cabang', $exp[$i]);
				}
				foreach ($tables as $tab) {
					$this->db->join($tab, $tab . '.no_fos = tbl_input.no_fos', 'inner');
				}
				$this->db->join('tbl_users', 'tbl_users.nip_user = tbl_input.nip_user', 'inner');
				$this->db->join('tbl_cabang', 'tbl_cabang.kd_cabang = tbl_input.kode_cabang', 'inner');
				$this->db->join('tbl_koperasi', 'tbl_koperasi.cif_induk = tbl_input.cif_induk', 'inner');
				$this->db->order_by('tbl_input.no_fos', 'desc');
				$result = $this->db->get();
				return $result;
			}
		}
	}

	function get_revisi()
	{
		$akses = $this->session->userdata('akses_user');

		$this->db->select('*')->from('tbl_input a')->join('tbl_cabang b', 'a.kode_cabang = b.kd_cabang', 'inner');
		$this->db->join('tbl_kontrak c', 'a.no_fos = c.no_fos', 'inner');
		if ($akses == 'Checker' || $akses == 'Maker') {
			$this->db->where(['a.approve' => '0']);
		} else {
			$this->db->where(['a.approve' => '3']);
		}

		$result = $this->db->get();
		return $result;
	}

	function get_approve()
	{
		$akses = $this->session->userdata('akses_user');

		$this->db->select('*')->from('tbl_input a')->join('tbl_cabang b', 'a.kode_cabang = b.kd_cabang', 'inner');
		$this->db->join('tbl_kontrak c', 'a.no_fos = c.no_fos', 'inner');
		if ($akses == 'Checker' || $akses == 'Maker') {
			$this->db->where(['a.approve' => '2']);
		} else {
			$this->db->where(['a.approve' => '3']);
		}

		$result = $this->db->get();
		return $result;
	}

	function count_cif()
	{
		$nip = $this->session->userdata('nip');
		$akses = $this->session->userdata('akses_user');

		if ($akses == 'Maker') {
			$this->db->select('*')->from('tbl_input a')->join('tbl_kontrak b', 'a.no_fos = b.no_fos');
			$this->db->where(['a.nip_user' => $nip])->group_by('a.cif');

			$result = $this->db->get();
			return $result->num_rows();
		} else {
			$result = $this->db->get_where('tbl_users', ['nip_user' => $nip]);

			foreach ($result->result_array() as $res) {
				$exp = explode("::", $res['jaringan']);

				$this->db->select('*')->from('tbl_input a')->join('tbl_kontrak b', 'a.no_fos = b.no_fos');
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where(['a.kode_cabang' => $exp[$i]]);
				}
				$this->db->group_by('a.cif');

				$result = $this->db->get();
				return $result->num_rows();
			}
		}
	}


	function count_kop()
	{
		$nip = $this->session->userdata('nip');
		$akses = $this->session->userdata('akses_user');

		if ($akses == 'Maker') {
			$result = $this->db->get_where('tbl_koperasi', ['nip_user' => $nip]);
			return $result->num_rows();
		} else {
			$result = $this->db->get_where('tbl_users', ['nip_user' => $nip]);

			foreach ($result->result_array() as $res) {
				$exp = explode("::", $res['jaringan']);

				$this->db->select('*')->from('tbl_koperasi');
				for ($i = 0; $i < count($exp); $i++) {
					$this->db->or_where(['cabang' => $exp[$i]]);
				}

				$result = $this->db->get();
				return $result->num_rows();
			}
		}
	}
}
