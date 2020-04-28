<?php

class m_master_data extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function join($table, $table1, $condition)
    {
        $this->db->select('a.id,unique_id,nama_kegiatan,jenis_kegiatan');
        $this->db->from($table);
        $this->db->join($table1, $condition);
        return $this->db->get()->result_array();
    }
}
