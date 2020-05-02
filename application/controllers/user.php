<?php

class user extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('m_master_data');
    }
    public function index()
    {
        $pages = 'user/index';
        $data = [
            'title' => 'Profil',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            $this->db->join('user_role', 'user.role_id=user_role.id'),
            $this->db->where('role_id', $this->session->userdata('role_id')),
            'role' => $this->db->get('user')->row_array(),
        ];
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->edit();
        }
    }
    public function edit()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $name = $_POST['name'];
        $email = $_POST['email'];
        //cek jika ada gambar yang diupload
        $uploadImage = $_FILES['image']['name'];
        if ($uploadImage) {
            $config['upload_path'] = './assets/plugins/lte/dist/img';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']     = '4096';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $old_image = $data['user']['image'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->display_errors();
                redirect('user');
            }
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your profile has been updated </div>');
            redirect('user');
        }
    }
    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[3]|trim|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Repeat Password', 'required|min_length[3]|trim|matches[new_password]');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/changePassword', $data);
            $this->load->view('template/footer', $data);
        } else {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            if (!password_verify($current_password, $data['user']['password'])) {
                //jika password yg ada tidak sama
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> wrong current password </div>');
                redirect('user/changePassword');
            } else {
                if ($current_password == $new_password) {
                    //password lama tidak boleh sama dengan password baru 
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New password cannot be the same as current password! </div>');
                    redirect('user/changePassword');
                } else {
                    //password ok
                    $password_has = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_has);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password has successful changed! </div>');
                    redirect('user/changePassword');
                }
            }
        }
    }

    public function listUser(){
        $pages = 'user/listUser';
        $lihat_user = $this->m_master_data->lihat_all_user();
        $data = [
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'     => 'List User',
            'subtitle'  => 'List All User',
            'result'    => $lihat_user
        ];
        $this->main_generic->layout($pages, $data);
    }
    public function tambah_user(){
        $cari_username = $this->m_master_data->cari_username(set_value('username'));
        if($cari_username == null){
            $config['upload_path']          = './assets/foto/';
            // $config['allowed_types']        = '*';
            // $config['max_size']             = '*';
            var_dump(set_value('userfile')); die();
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('userfile')){
                var_dump('jos'); die();
                $fileName 	= $this->upload->data('file_name');
                $targetPath = getcwd() . '/assets/foto/';
                $targetFile = $targetPath . $fileName ;
                $inputFileName = $targetFile;

                $data = array(
                    'username'      => set_value('username'),
                    'name'          => set_value('nama_user'),
                    'email'         => set_value('email'),
                    'password'      => password_hash(set_value('password'), PASSWORD_DEFAULT),
                    'role_id'       => set_value('role'),
                    'is_active'     => 1,
                    'date_created'  => 1,
                    'foto'          => $fileName
                );
                $this->m_master_data->tambah_user($data);
                $alert = $this->main_generic->alert('Berhasil', 'Data berhasil ditambahkan', 'success');
                $this->session->set_flashdata('message', $alert);
            } else {
                $alert = $this->main_generic->alert('Gagal', 'Foto gagal diupload', 'danger');
                $this->session->set_flashdata('message', $alert);
            }
        } else {    
            $alert = $this->main_generic->alert('Gagal', 'Data sudah tersedia', 'danger');
            $this->session->set_flashdata('message', $alert);
        }
        redirect('user/listUser');
    }
    public function edit_user(){
        $data = array(
            'name'  => set_value('name'),
            'email' => set_value('email')
        );
        // var_dump(set_value('id')); die();
        $this->m_master_data->edit_user(set_value('id'), $data);
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('user/listUser');
    }
}
