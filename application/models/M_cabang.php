<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_cabang extends CI_Model{
	function getAll(){
		$this->db->select('a.*, b.nama_cabang')->from('tbl_users a')->join('tbl_cabang b', 'a.cabang = b.kd_cabang', 'inner');
		$this->db->where('a.akses_user !=', 'Admin');
		$this->db->order_by('a.cabang', 'asc');
		$result = $this->db->get();
		return $result->result();
	}

	function getData($key){
        $result = $this->db->get_where('tbl_cabang', ['kd_cabang' => $key]);
        return $result;
    }
}