<?php

class m_master_data extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function lihat_all_user(){
        $hasil = $this->db->get('user');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    public function join($table, $table1, $condition)
    {
        $this->db->select('a.id,unique_id,nama_kegiatan,jenis_kegiatan');
        $this->db->from($table);
        $this->db->join($table1, $condition);
        return $this->db->get()->result_array();
    }
    public function cari_username($username){
        $hasil = $this->db->where('username', $username)
                          ->limit(1)
                          ->get('user');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function cari_kegiatan_on_anggaran($kd_kegiatan){
        $hasil = $this->db->where('kd_kegiatan', $kd_kegiatan)
                          ->limit(1)
                          ->get('anggaran');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function cari_jenis_kegiatan_on_kegiatan($kd_jenis_kegiatan){
        $hasil = $this->db->where('kd_jenis_kegiatan', $kd_jenis_kegiatan)
                          ->limit(1)
                          ->get('kegiatan');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function cari_coa_on_kegiatan($kode_akun){
        $hasil = $this->db->query('
                                Select      *
                                from        kegiatan
                                where       coa1 = '.$kode_akun.' or
                                            coa2 = '.$kode_akun);
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function cari_sub_menu_by_user_menu($id){
        $hasil = $this->db->where('menu_id', $id)
                          ->limit(1)
                          ->get('user_sub_menu');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function tambah_user($data){
        $this->db->insert('user', $data);
    }
    public function edit_user($id_user, $data){
        $this->db->where('id_user', $id_user)
                 ->update('user', $data);
    }
    public function delete_kegiatan_by_unique_id($unique_id){
        $this->db->where('unique_id', $unique_id)
                 ->delete('kegiatan');
    }
    public function delete_coa_by_kode_akun($kode_akun){
        $this->db->where('kode_akun', $kode_akun)
                 ->delete('coa');
    }
    public function delete_jenis_kegiatan_by_kd_jenis_kegiatan($kd_jenis_kegiatan){
        $this->db->where('kd_jenis_kegiatan', $kd_jenis_kegiatan)
                 ->delete('jenis_kegiatan');
    }
}
