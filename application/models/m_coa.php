<?php

class m_coa extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
    
    public function get2($table)
    {
        return $this->db->get($table)->result();
    }

    public function get_all_debit(){
        return $this->db->query('
                                    Select  *
                                    from    coa
                                    where   (((kode_akun > 100) and (kode_akun < 200)) or
                                            ((kode_akun > 500) and (kode_akun < 600)))
                                ')->result_array();
    }

    public function get_all_kredit(){
        return $this->db->query('
                                    Select  *
                                    from    coa
                                    where   kode_akun > 200 and 
                                            kode_akun < 500
                                ')->result_array(); 
    }
}
