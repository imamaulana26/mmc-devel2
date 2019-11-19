<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_log extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function insert($log){
		$this->db->insert('tbl_log', $log);
	}

	function getAll(){
		$this->db->from('tbl_log')->order_by('waktu', 'desc');
		$query = $this->db->get();
		return $query;
	}
}