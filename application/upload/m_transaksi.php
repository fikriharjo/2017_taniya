<?php

class m_transaksi extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function join($table, $table1, $condition)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($table1, $condition);
        return $this->db->get()->result_array();
    }
    public function insert_table($table, $data)
    {
        return $this->db->insert($table, $data);
    }
    public function get_detail_anggaran($params)
    {
        $this->db->select('*');
        $this->db->from('detail_anggaran a');
        $this->db->join('jenis_anggaran b', 'a.kd_jenis_anggaran=b.no_jenis_anggaran');
        $this->db->join('kegiatan c', 'a.kd_kegiatan=c.unique_id');
        $this->db->join('jenis_kegiatan d', 'c.kd_jenis_kegiatan=d.kd_jenis_kegiatan');
        $this->db->where('no_anggaran', $params);
        return $this->db->get()->result_array();
    }
    public function ambil_budget_by_date($date){
        $hasil = $this->db->where('tgl_anggaran', $date)
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    public function get_distinct_anggaran(){
        $hasil = $this->db->select('distinct(tgl_anggaran)')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result_array();
        } else {
            return array();
        }
                          
    }
    public function kode_anggaran()
    {
        $this->db->select('right(anggaran.no_anggaran,3)as kode', false);
        $this->db->order_by('no_anggaran', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('anggaran');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax    = str_pad($kode, 3, '0', STR_PAD_LEFT);
        $kodejadi    = "AGR-"  . $kodemax;
        return $kodejadi;
    }
    public function kode($table, $kode, $str)
    {
        $this->db->select('right(' . $table . '.' . $kode . ',3)as kode', false);
        $this->db->order_by('' . $kode . '', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('' . $table . '');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax    = str_pad($kode, 3, '0', STR_PAD_LEFT);
        $kodejadi    = "" . $str . "-"  . $kodemax;
        return $kodejadi;
    }
    public function selesai_anggaran($id, $nominal)
    {
        $data = [
            'no_anggaran'   => $id,
            'tgl_anggaran'  => date('Y-m-d'),
            'nominal'       => $nominal,
        ];
        $this->insert_table('anggaran', $data);
    }
    public function saveRealisasi()
    {
        $this->db->where(array(
            'kd_realisasi' => $_POST['kd_realisasi'],
            'kd_kegiatan' => $_POST['nama_kegiatan'],
            'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
        ));
        $query = $this->db->get('detail_realisasi');
        if ($query->num_rows() == 0) {
            $data = [
                'kd_realisasi' => $_POST['kd_realisasi'],
                'kd_kegiatan' => $_POST['nama_kegiatan'],
                'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
                'nominal'   => $_POST['nominal'],
                'keterangan'   => $_POST['keterangan'],
            ];
            $this->db->insert('detail_realisasi', $data);
        } else {
            $this->db->set('nominal', 'nominal + ' . $_POST['nominal'] . '', false);
            $this->db->where(array(
                'kd_realisasi' => $_POST['kd_realisasi'],
                'kd_jenis_kegiatan' => $_POST['kd_jenis_kegiatan'],
                'kd_kegiatan' => $_POST['kd_kegiatan'],
                'kd_jenis_anggaran' => $_POST['kd_jenis_anggaran'],
            ));
            $this->db->update('detail_realisasi');
        }
    }
    public function getDetailRealisasi($id)
    {
        $this->db->select('*');
        $this->db->from('detail_realisasi a');
        $this->db->join('jenis_anggaran b', 'a.kd_jenis_anggaran=b.no_jenis_anggaran');
        $this->db->join('kegiatan d', 'a.kd_kegiatan=d.unique_id');
        $this->db->join('jenis_kegiatan c', 'd.kd_jenis_kegiatan=c.kd_jenis_kegiatan');
        $this->db->where('kd_realisasi', $id);
        return $this->db->get()->result_array();
    }
}
