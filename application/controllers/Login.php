<?php defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
		$this->load->model('m_log');
	}

	public function index()
	{
		$email = $this->session->userdata('email');

		if (empty($email)) {
			// hitung interval waktu log_on, jika lebih dari 30 menit maka update data
			$query = "UPDATE tbl_users SET active=0 where TIMESTAMPDIFF(MINUTE, log_on, now())>30 and active=1";
			$this->db->query($query);

			ob_start('ob_gzhandler');
			$this->load->view('v_login');
		} else {
			echo $email . " Access Denied";
		}
	}

	// login user manual
	public function auth()
	{
		$username = input($this->input->post('username')) . '@syariahmandiri.co.id';
		$password = md5(input($this->input->post('password')));
		$valid = $this->m_login->getLogin($username, $password);

		if ($valid) {
			$sess = array(
				'nip' => $valid['nip_user'],
				'nama_user' => $valid['nama_user'],
				'email' => $valid['email'],
				'akses_user' => $valid['akses_user'],
				'cabang' => $valid['cabang']
			);
			$stat = $valid['active'];
			date_default_timezone_set('Asia/Jakarta');
			$log_on = date('Y-m-d H:i:s');

			if ($valid['enable'] == '0') {
				if ($stat == 0 && $sess['akses_user'] == 'Admin') {
					$this->session->set_userdata($sess);
					$status = 1;
					$this->m_login->update($sess['nip'], $status);
					$this->m_login->log_on($sess['nip'], $log_on);
					redirect(ucfirst('login/success'));
				} elseif ($stat == 0 && $sess['akses_user'] == 'Maker') {
					$this->session->set_userdata($sess);
					$status = 1;
					$this->m_login->update($sess['nip'], $status);
					$this->m_login->log_on($sess['nip'], $log_on);
					redirect(ucfirst('login/success'));
				} elseif ($stat == 0 && $sess['akses_user'] == 'Checker') {
					$this->session->set_userdata($sess);
					$status = 1;
					$this->m_login->update($sess['nip'], $status);
					$this->m_login->log_on($sess['nip'], $log_on);
					redirect(ucfirst('login/success'));
				} elseif ($stat == 0 && ($sess['akses_user'] == 'Approval')) {
					$this->session->set_userdata($sess);
					$status = 1;
					$this->m_login->update($sess['nip'], $status);
					$this->m_login->log_on($sess['nip'], $log_on);
					redirect(ucfirst('login/success'));
				} elseif ($stat == 0 && ($sess['akses_user'] == 'Reviewer')) {
					$this->session->set_userdata($sess);
					$status = 1;
					$this->m_login->update($sess['nip'], $status);
					$this->m_login->log_on($sess['nip'], $log_on);
					redirect(ucfirst('login/success'));
				} else {
					$this->session->set_flashdata('msg', 'Akun sedang digunakan!');
					redirect(ucfirst('login'));
				}
			} else {
				$this->session->set_flashdata('msg', 'Akun sudah tidak aktif!');
				redirect(ucfirst('login'));
			}
		}
	}

	// login LDAP //
	function ldap()
	{
		$user = $this->input->post('username');
		$pass = $this->input->post('password');

		$domainemail = "syariahmandiri.co.id";

		$ldap_user = $user . "@" . $domainemail;
		$ldap_dns = 'oc=bsm,dc=syariahmandiri,dc=co,dc=com';
		$ldap_host = 'svr-bsmdc5.syariahmandiri.co.id';
		$ldap_port = 389;

		$ldap_cons = ldap_connect($ldap_host, $ldap_port) or die('Could not connect to {$ldap_port}');

		ldap_set_option($ldap_cons, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap_cons, LDAP_OPT_REFERRALS, 0);

		if ($bind = @ldap_bind($ldap_cons, $ldap_user, $pass)) {
			$valid = $this->m_login->loginLDAP($ldap_user);

			if ($valid) {
				$sess = array(
					'nip' => $valid['nip_user'],
					'nama_user' => $valid['nama_user'],
					'email' => $valid['email'],
					'akses_user' => $valid['akses_user'],
					'cabang' => $valid['cabang']
				);
				$stat = $valid['active'];
				date_default_timezone_set('Asia/Jakarta');
				$log_on = date('Y-m-d H:i:s');

				if ($valid['enable'] == '0') {
					if ($stat == 0 && $sess['akses_user'] == 'Admin') {
						$this->session->set_userdata($sess);
						$status = 1;
						$this->m_login->update($sess['nip'], $status);
						$this->m_login->log_on($sess['nip'], $log_on);
						redirect(ucfirst('login/success'));
					} elseif ($stat == 0 && $sess['akses_user'] == 'Maker') {
						$this->session->set_userdata($sess);
						$status = 1;
						$this->m_login->update($sess['nip'], $status);
						$this->m_login->log_on($sess['nip'], $log_on);
						redirect(ucfirst('login/success'));
					} elseif ($stat == 0 && $sess['akses_user'] == 'Checker') {
						$this->session->set_userdata($sess);
						$status = 1;
						$this->m_login->update($sess['nip'], $status);
						$this->m_login->log_on($sess['nip'], $log_on);
						redirect(ucfirst('login/success'));
					} elseif ($stat == 0 && ($sess['akses_user'] == 'Approval')) {
						$this->session->set_userdata($sess);
						$status = 1;
						$this->m_login->update($sess['nip'], $status);
						$this->m_login->log_on($sess['nip'], $log_on);
						redirect(ucfirst('login/success'));
					} elseif ($stat == 0 && ($sess['akses_user'] == 'Reviewer')) {
						$this->session->set_userdata($sess);
						$status = 1;
						$this->m_login->update($sess['nip'], $status);
						$this->m_login->log_on($sess['nip'], $log_on);
						redirect(ucfirst('login/success'));
					} else {
						$this->session->set_flashdata('msg', 'Akun sedang digunakan!');
						redirect(ucfirst('login'));
					}
				} else {
					$this->session->set_flashdata('msg', 'Akun sudah tidak aktif!');
					redirect(ucfirst('login'));
				}
			}

			$filter = "(sAMAccountName=" . $ldap_user . ")";
			$attr = array("memberof");
			$result = ldap_search($ldap_cons, $ldap_dns, $filter, $attr) or exit('Unable to search LDAP server');
			$entries = ldap_get_entries($ldap_cons, $result);
		} else {
			$this->session->set_flashdata('msg', 'LDAP Login failed!');
			redirect(ucfirst('login'));
		}
	}

	public function success()
	{
		date_default_timezone_set('Asia/Jakarta');
		$log = array(
			'user_session' => $this->session->userdata('nip'),
			'nama_user' => $this->session->userdata('nama_user'),
			'akses_user' => $this->session->userdata('akses_user'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'url' => $_SERVER['REQUEST_URI'],
			'waktu' => date('Y-m-d H:i:s')
		);

		$akses = $this->session->userdata('akses_user');
		if ($akses == 'Admin') {
			$log['detail'] = 'Login berhasil';
			$this->m_log->insert($log);
			redirect(ucfirst('admin/dashboard'));
		} elseif ($akses == 'Maker') {
			$log['detail'] = 'Login berhasil';
			$this->m_log->insert($log);
			redirect(ucfirst('maker/dashboard'));
		} elseif ($akses == 'Checker') {
			$log['detail'] = 'Login berhasil';
			$this->m_log->insert($log);
			redirect(ucfirst('checker/dashboard'));
		} elseif ($akses == 'Reviewer') {
			$log['detail'] = 'Login berhasil';
			$this->m_log->insert($log);
			redirect(ucfirst('approval/dashboard'));
		} else {
			$log['detail'] = 'Login berhasil';
			$this->m_log->insert($log);
			redirect(ucfirst('approval/dashboard'));
		}
	}

	public function logout()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = array(
			'active' => false,
			'last_login' => date('Y-m-d H:i:s')
		);
		$id = $this->session->userdata('nip');
		$log = array(
			'user_session' => $this->session->userdata('nip'),
			'nama_user' => $this->session->userdata('nama_user'),
			'akses_user' => $this->session->userdata('akses_user'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'url' => $_SERVER['REQUEST_URI'],
			'waktu' => date('Y-m-d H:i:s')
		);
		if (isset($id)) {
			if ($this->m_login->logout($id, $data)) {
				$log['detail'] = 'Logout berhasil';
				$this->m_log->insert($log);
				$this->session->sess_destroy();
				redirect(ucfirst('login'));
			}
		} else {
			redirect(ucfirst('login'));
		}
	}
}
