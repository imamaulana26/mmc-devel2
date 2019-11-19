<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class M_session_user extends CI_Model{
	public function login($username, $password){
		// Is there a valid user?
		$this->db->select('id');
		$this->db->where('username', $username);
		$this->db->where('password', sha1($password));
		$query = $this->db->get('tbl_user');
		$user = $query->row_array();

		if($user['id']){
			// Is there an open session for this user?
			$this->db->select('id');
			$this->db->where('user_id', $user['id']);
			$this->db->where('inactive !=', 1);
			$query = $this->db->get('tbl_user_session');
			$session = $query->row_array();

			if($session['id']){
				// Close the session
				$this->destroy_session($session['id']);
			}
			// Create the new session
			$new_session['users_id'] = $user['id'];
			$new_session['ip'] = $_SERVER['REMOTE_ADDR'];
			$this->create_session($new_session);
			return true;
		} else{
			return false;
		}
	}

	public function create_session($data){
		// Set additional data
		$data = array(
			'created_date' => date('Y-m-d H:i:s'),
			'last_active' => date('Y-m-d H:i:s'),
			'inactive' => 0,
			'hash' => sha1($data['users_id'].time())
		);
		// Perform the insert
		$this->db->insert('tbl_user_session', $data);
		// Create cookie
		set_cookie('user_login', $data['hash'], 0, base_url());
	}

	public function session_check($hash){
		// Is there a session for this hash?
		$this->db->where('hash', $hash);
		$this->db->where('inactive !=', 1);
		$query = $this->db->get('tbl_user_session');
		$session = $query->row_array();

		if($session['id']){
			// Check the session isn't more than 30 days old and the ips match
			if((strtotime($session['last_active']) < strtotime('-30 days')) || $session['ip'] != $_SERVER['REMOTE_ADDR']){
				$this->destroy_session($session['id']);
				return false;
			} else{
				// Update the last active date to now
				$this->db->set('last_active', date('Y-m-d H:i:s'));
				$this->db->where('id', $session['id']);
				$this->db->update('tbl_user_session');
				// Track the URI
				$trackdata['session_id'] = $session['id'];
				$trackdata['uri'] = $this->uri->uri_string();
				$this->track_uri($trackdata);
				// Return the session
				return $session;
			}
		} else{
			return false;
		}
	}

	public function destroy_session($session_id){
		// Mark as inactive in database
		$this->db->set('inactive', 1);
		$this->db->where('id', $session['id']);
		$this->db->update('tbl_user_session');
		// Destroy the cookie
		delete_cookie('user_login', base_url());
	}

	public function track_uri($data){
		// Set additional data
		$data['last_visited'] = date('Y-m-d H:i:s');
		// Perform the insert
		$this->db->insert('session_track', $data);
	}
}
?>