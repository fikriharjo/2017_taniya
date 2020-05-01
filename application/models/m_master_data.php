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
    public function tambah_user($data){
        $this->db->insert('user', $data);
    }
    public function edit_user($id_user, $data){
        $this->db->where('id_user', $id_user)
                 ->update('user', $data);
    }
}
