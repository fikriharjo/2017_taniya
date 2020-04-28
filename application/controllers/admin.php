<?php

/**
 * 
 */
class admin extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $pages = 'admin/index';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $data['menu'] = $this->management_model->get_join_user();
        // $data['submenu'] = $this->management_model->get_menu_user();
        $data = [
            'title' => 'Dashboard',
            'user'  => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }
    public function role()
    {
        $pages = 'admin/role';
        $data = [
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'role' => $this->db->get('user_role')->result_array(),
            'title' => 'Hak Akses',
            'subtitle' => 'Users'
        ];
        $this->main_generic->layout($pages, $data);
    }
    public function roleAccess($role_id)
    {
        $pages = 'admin/roleAccess';
        $data = [
            'title' => 'Hak Akses',
            'subtitle' => 'Akses Menu',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'role' => $this->db->get_where('user_role', ['id' => $role_id])->row_array(),
            'menu' => $this->db->get_where('user_menu', ['id !=' => 1])->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function changeaccess()
    {
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        $data = [
            'role_id' => $roleId,
            'menu_id' => $menuId
        ];
        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $alert = $this->main_generic->alert('berhasil', 'data berhasil di ubah', 'success');
        $this->session->set_flashdata('message', $alert);
    }
    public function manage()
    {
        $data['user1'] = $this->general_model->getResult('user');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Management User';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/manageUser', $data);
        $this->load->view('template/footer', $data);
    }
    public function manage_account()
    {
        $email = $this->input->post('email');
        $data = [
            'email' => $email,
        ];
        $result = $this->db->get('user')->row_array();
        if ($result['is_active'] == 0) {
            $this->db->set('is_active', 1);
            $this->db->update('user');
            $this->db->where('id_user', $email);
        } else {
            $this->db->set('is_active', 0);
            $this->db->update('user');
            $this->db->where('id_user', $email);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        User has been activated </div>');
    }
}
