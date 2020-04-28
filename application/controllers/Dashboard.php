<?php

class Dashboard extends CI_controller
{
    public function index()
    {
        $pages = 'dashboard/index';
        $data = [
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title' => 'Dashboard',

        ];
    }
}
