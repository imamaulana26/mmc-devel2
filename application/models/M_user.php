<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_user extends CI_Model{
	function getAll(){
		$this->db->select('a.*, b.nama_cabang, b.region')->from('tbl_users a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		$this->db->where('a.akses_user !=', 'Admin');
		$result = $this->db->get();
		return $result->result();
	}

	function getMaker(){
		$this->db->where('akses_user', 'Maker');
		$result = $this->db->get('tbl_users');
		return $result;
	}

	function getReviewer(){
		$this->db->where('akses_user', 'Reviewer');
		$result = $this->db->get('tbl_users');
		return $result;
	}

	function getChecker(){
		$this->db->where('akses_user', 'Checker');
		$result = $this->db->get('tbl_users');
		return $result;
	}

	function getApproval(){
		$this->db->where('akses_user', 'Approval');
		$result = $this->db->get('tbl_users');
		return $result;
	}

	function getData($key){
		$this->db->select('a.*, b.nama_cabang')->from('tbl_users a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		$this->db->where('a.nip_user', $key);
		$result = $this->db->get();
		return $result;
	}

	function updateData($key, $data){
		$this->db->where('nip_user', $key);
		$this->db->update('tbl_users', $data);
	}

	function insertData($data){
		$this->db->insert('tbl_users', $data);
	}

	function deleteData($key){
		$this->db->where('nip_user', $key);
		$this->db->delete('tbl_users');
	}
	
	function sendMail($key){
		$this->db->select('*')->from('tbl_input')->where('no_fos', $key);
		$query = $this->db->get();
		$result = $query->result();
		
		foreach($result as $res){
			$this->db->select('*')->from('tbl_users');
			$nip = array($res->nip_checker, $res->nip_user, $res->nip_reviewer, $res->nip_approval);
			foreach($nip as $n){
				$this->db->or_where('nip_user', $n);
			}
			$result = $this->db->get();
			return $result;
		}
	}
}