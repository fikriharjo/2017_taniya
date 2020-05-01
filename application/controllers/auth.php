<?php

class auth extends CI_controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run() == false) {

			// $this->load->view('core/html-header');
			$this->load->view('auth/login');
			$this->load->view('core/html-footer');
		} else {
			$this->_login();
		}
	}
	
	private function _login()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$user = $this->db->get_where('user', ['username' => $username])->row_array();
		//cek email apakah sudah teregister atau belum
		if ($user) {
			//cek akun apakah aktif atau tidak aktiv
			if ($user['is_active'] == 1) {
				//cek password
				if (password_verify($password, $user['password'])) {
					$data = [
						'email'   => $user['email'],
						'role_id' => $user['role_id'],
					];
					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					 Wrong password! </div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				This email has not been activated! </div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Email is not registered! </div>');
			redirect('auth');
		}
	}
	public function register()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('bagian', 'Bagian', 'required|trim');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.email]', [
			'is_unique' => 'this %s has already exist!'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'this email has already registered!'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => "Password Don't Match!",
			'min_length' => "Password too short!"
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');


		if ($this->form_validation->run() == false) {
			$this->load->view('core/html-header');
			$this->load->view('auth/register');
			$this->load->view('core/html-footer');
		} else {
			$data = [
				'name' 			=> $_POST['name'],
				'email' 		=> $_POST['email'],
				'image' 		=> 'default.jpg',
				'username'		=> $_POST['username'],
				'password'		=> password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' 		=> $_POST['bagian'],
				'is_active'		=> 1,
				'date_created' 	=> time(),
			];
			//siapkan token
			$token = md5(uniqid(rand(32), true));
			$user_token = [
				'email' => $_POST['email'],
				'token' => $token,
				'date_created' => time()
			];
			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);
			$this->_sendemail($token, 'verify');
			$alert = $this->main_generic->alert('berhasil', 'Congratulation! your account has been created. Please Activate Your account', 'success');
			$this->session->set_flashdata('message', $alert);
			redirect('auth');
		}
	}
	private function _sendemail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'gumelarrtx@gmail.com',
			'smtp_pass' => 'rtx2080ti',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
		];
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('gumelarrtx@gmail.com', 'Rizal gumelar');
		$this->email->to($_POST['email']);
		if ($type == 'verify') {
			$this->email->subject('Account verification');
			$this->email->message('Click this link to verify your account : 
				<a href="' . base_url('') . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>
				');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password : 
					<a href="' . base_url('') . 'auth/resetPassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>
					');
		}
		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}
	public function verify()
	{
		$get = $this->input->get();
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get('user_token')->row_array();
			if ($user_token) {
				// if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
				$this->db->set('is_active', 1);
				$this->db->where('email', $email);
				$this->db->update('user');
				$this->db->delete('user_token', ['email' => $email]);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login</div>');
				redirect('auth');
				// } else {
				// 	$this->db->delete('user', ['email' => $email]);
				// 	$this->db->delete('user_token', ['email' => $email]);
				// 	$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation fail: Email expired </div>');
				// 	redirect('auth');
				// }
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation fail: wrong Token </div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation fail: wrong Email </div>');
			redirect('auth');
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
		You have been logout </div>');
		redirect('auth');
	}
	public function blocked()
	{

		$this->load->view('auth/blocked');
	}
	public function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Forgot Password';
			$this->load->view('template/auth_header', $data);
			$this->load->view('auth/forgot_password');
			$this->load->view('template/auth_footer');
		} else {
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
			if ($user) {
				$token = bin2hex(openssl_random_pseudo_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				$this->db->insert('user_token', $user_token);
				$this->_sendemail($token, 'forgot');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Please check your email to reset your password! </div>');
				redirect('auth/forgot_password');
			} else {
				var_dump($user);
				die;
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registered or Activated! </div>');
				redirect('auth/forgot_password');
			}
		}
	}
	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Reset password fail! Wrong token </div>');
				redirect('auth/forgot_password');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Reset password fail! Wrong email </div>');
			redirect('auth/forgot_password');
		}
	}
	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Change Password';
			$this->load->view('template/auth_header', $data);
			$this->load->view('auth/changePassword');
			$this->load->view('template/auth_footer');
		} else {
			$new_password = $_POST['password1'];
			$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');


			$this->db->set('password', $password_hash);
			$this->db->where('email', $email);
			$this->db->update('user');
			$this->session->unset_userdata('reset_email');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password has been change! please login </div>');
			redirect('auth');
		}
	}
}
