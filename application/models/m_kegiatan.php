<?php

class m_kegiatan extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
}
