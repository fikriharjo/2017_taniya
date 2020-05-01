<?php

class master_data extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('m_coa');
        $this->load->model('m_kegiatan');
        $this->load->model('m_master_data');
    }
    public function coa(){
        $pages = 'master_data/coa';
        $data = [
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title' => 'Chart Of Account',
            'subtitle' => 'List COA',
            'result' => $this->m_coa->get('coa'),
        ];
        $this->form_validation->set_rules('coa', 'COA', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('header_akun', 'Header Akun', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kode_akun', 'Kode Akun', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->insert('coa', [
                'kode_akun'     => $_POST['header_akun'].$_POST['kode_akun'],
                'nama'          => $_POST['coa'],
            ]);
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('master_data/coa');
        }
    }
    public function edit_coa()
    {
        $idnya = $this->m_coa->cari_by_id($_POST['coa_id']);
        $idnya = $idnya->kode_akun;

        $this->db->set('kode_akun', $_POST['header_akun'].$_POST['kode_akun']);
        $this->db->set('nama', $_POST['coa']);
        $this->db->where('id', $_POST['coa_id']);
        if($_POST['kode_akun'] > 99){
            var_dump('Error, kode tidak boleh diatas 99');die();
        } else if(($_POST['header_akun'] > 5) or ($_POST['header_akun'] < 1)){
            var_dump('Error, header harus 1-5');die();
        }
        $this->db->update('coa');

        $this->db->set('coa2', $_POST['header_akun'].$_POST['kode_akun']);
        $this->db->where('coa2', $idnya);
        $this->db->update('kegiatan');

        $this->db->set('coa1', $_POST['header_akun'].$_POST['kode_akun']);
        $this->db->where('coa1', $idnya);
        $this->db->update('kegiatan');

        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil diubah', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('master_data/coa');
    }
    public function kegiatan()
    {
        $pages = 'master_data/kegiatan';
        $data = [
            'user'      => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'     => 'Kegiatan',
            'subtitle'  => 'Data Kegiatan',
            'unique'    => 'KGT-' . rand(100, 999),
            'result'    => $this->m_master_data->join(
                'kegiatan a',
                'jenis_kegiatan b',
                'a.kd_jenis_kegiatan=b.kd_jenis_kegiatan'
            ),
            'jenis_kegiatan'    => $this->m_kegiatan->get('jenis_kegiatan'),
            'jenis_anggaran'    => $this->m_kegiatan->get('jenis_anggaran'),
            'coa'               => $this->m_coa->get('coa'),
            'coa'               => $this->m_coa->get('coa'),
        ];
        // var_dump($data['result']);
        // die;
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->insert('kegiatan', [
                'unique_id'         => $_POST['kode'],
                'nama_kegiatan'     => $_POST['nama_kegiatan'],
                'kd_jenis_kegiatan' => $_POST['jenis_kegiatan'],
                'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
                'coa1'              => $_POST['coa1'],
                'coa2'              => $_POST['coa2'],
            ]);

            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('master_data/kegiatan');
        }
    }
    public function edit_jkegiatan()
    {
        // var_dump($_POST['kgt'], $_POST['kgt_id']);
        // die;
        $this->db->set('nama_kegiatan', $_POST['kgt']);
        $this->db->where('id', $_POST['kgt_id']);
        $this->db->update('kegiatan');
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil diubah', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('master_data/kegiatan');
    }
    public function jenis_kegiatan()
    {
        $pages = 'master_data/jenis_kegiatan';
        $data = [
            'user'      => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'     => 'Jenis Kegiatan',
            'subtitle'  => 'Data jenis_kegiatan',
            'unique'    => 'JKGT-' . rand(100, 999),
            'result'    => $this->m_master_data->get('jenis_kegiatan'),
        ];
        $this->form_validation->set_rules('kegiatan', 'Jenis Kegiatan', 'required', [
            'required' => 'kolom %s tidak boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->insert('jenis_kegiatan', [
                'kd_jenis_kegiatan' => $_POST['kode'],
                'jenis_kegiatan' => $_POST['kegiatan'],
            ]);
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('master_data/jenis_kegiatan');
        }
    }
    public function edit_kegiatan()
    {
        $this->db->set('jenis_kegiatan', $_POST['kgt']);
        $this->db->where('id', $_POST['kgt_id']);
        $this->db->update('jenis_kegiatan');
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil diubah', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('master_data/jenis_kegiatan');
    }
    public function delete_jenis_kegiatan($id){
        var_dump('coming soon');die();
    }
    public function delete_kegiatan($id){
        var_dump('coming soon');die();
    }
    public function delete_coa($id){
        var_dump('coming soon');die();
    }
}
