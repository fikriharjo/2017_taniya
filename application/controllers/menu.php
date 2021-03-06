<?php

class menu extends CI_controller
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
        $pages = 'menu/index';
        $data['title'] = 'Manajemen menu';
        $data['subtitle'] = 'Data Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $data['menu'] = $this->management_model->get_join_user();
        // $data['submenu'] = $this->management_model->get_menu_user();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required', [
            'required' => 'Kolom %s harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->insert('user_menu', ['menu' => $_POST['menu']]);
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil ditambahkan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('menu');
        }
    }
    public function submenu()
    {
        $data['title'] = 'Sub Menu management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['submenu'] = $this->menu_model->get_join_sub_menu();
        $data['menu']    = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->db->insert('user_sub_menu', [
                'title' => $_POST['title'],
                'menu_id' => $_POST['menu_id'],
                'url' => $_POST['url'],
                'icon' => $_POST['icon'],
                'is_active' => $_POST['is_active'],
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your data has been saved </div>');
            redirect('menu/submenu');
        }
    }
    public function edit_menu($id){
        $pages  = 'menu/edit_menu';
        $data['user']           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu']           = $this->db->get_where('user_menu', ['id' => $id])->row();
        $data['title']          = 'Edit menu';
        $data['subsubtitle']    = 'Fill the form';
        $this->form_validation->set_rules('menu', 'Menu', 'required', [
            'required' => 'Kolom %s harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->set('menu', $_POST['menu']);
            $this->db->where('id', $id);
            $this->db->update('user_menu');
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil ditambahkan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('menu');
        }
    }
    public function deleteData($id)
    {
        $cari_sub_menu = $this->m_master_data->cari_sub_menu_by_user_menu($id);
        if($cari_sub_menu == null){
            $this->db->where('id', $id);
            $this->db->delete('user_menu');
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil didelete', 'success');
            $this->session->set_flashdata('message', $alert);
        } else {
            $alert = $this->main_generic->alert('Gagal', 'Data masih tersedia di sub menu', 'danger');
            $this->session->set_flashdata('message', $alert);
        }
        redirect('menu');
    }
    public function deleteDataSubmenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil didelete', 'success');
        $this->session->set_flashdata('message', $alert);
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        // Congratulation! your data has been Deleted </div>');
        redirect('menu/submenu');
    }
}
