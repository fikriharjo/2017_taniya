<?php

class m_transaksi extends CI_model
{
    public function get($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function cari_anggaran_by_periode_and_kd_kegiatan($periode, $kd_kegiatan){
        $hasil = $this->db->where('kd_kegiatan', $_POST['jenis_kegiatan'])
                          ->where('periode', $this->session->userdata('tanggalan'))
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function lihat_realisasi_sum_detail($date){
        $hasil = $this->db->group_by('realisasi.kd_realisasi')
                          ->where('realisasi.periode', $date)
                          ->join('detail_realisasi', 'detail_realisasi.kd_realisasi = realisasi.kd_realisasi')
                          ->select('sum(detail_realisasi.nominal) as nominal, realisasi.kd_realisasi, realisasi.no_anggaran')
                          ->get('realisasi');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    public function lihat_anggaran_by_no_anggaran($no_anggaran){
        $hasil = $this->db->where('no_anggaran', $no_anggaran)
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function lihat_realisasi($no_anggaran){
        $hasil = $this->db->where('no_anggaran', $no_anggaran)
                          ->select('sum(nominal) as realisasi')
                          ->get('detail_realisasi');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
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
        $this->db->from('anggaran a');
        $this->db->join('jenis_anggaran b', 'a.kd_jenis_anggaran=b.no_jenis_anggaran');
        $this->db->join('kegiatan c', 'a.kd_kegiatan=c.unique_id');
        $this->db->join('jenis_kegiatan d', 'c.kd_jenis_kegiatan=d.kd_jenis_kegiatan');
        $this->db->where('no_anggaran', $params);
        return $this->db->get()->result_array();
    }

    public function get_detail_anggaran_by_date_and_jenis($date, $jenis){
        $this->db->select('*');
        $this->db->from('anggaran');
        $this->db->join('jenis_anggaran', 'anggaran.kd_jenis_anggaran=jenis_anggaran.no_jenis_anggaran');
        $this->db->join('kegiatan', 'anggaran.kd_kegiatan=kegiatan.unique_id');
        $this->db->join('jenis_kegiatan', 'kegiatan.kd_jenis_kegiatan=jenis_kegiatan.kd_jenis_kegiatan');
        $this->db->where('periode', $date);
        // $this->db->where('anggaran.kd_jenis_anggaran', $jenis);
        return $this->db->get()->result_array();
    }

    public function ambil_budget_by_date($date, $jenis){
        $hasil = $this->db->where('periode', $date)
                          ->where('kd_jenis_anggaran', $jenis)
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function get_all_anggaran_by_periode($date){
        $hasil = $this->db->order_by('jenis_kegiatan.kd_jenis_kegiatan', 'desc')
                          ->where('periode', $date)
                          ->join('jenis_anggaran', 'anggaran.kd_jenis_anggaran=jenis_anggaran.no_jenis_anggaran')
                          ->join('kegiatan', 'anggaran.kd_kegiatan=kegiatan.unique_id')
                          ->join('jenis_kegiatan', 'kegiatan.kd_jenis_kegiatan=jenis_kegiatan.kd_jenis_kegiatan')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    
    public function ambil_budget_by_date_test($date, $jenis){
        $hasil = $this->db->where('periode', $date)
                          ->where('kd_jenis_anggaran', $jenis)
                          ->select('(sum(nominal)-(
                                                    Select  case
                                                        when sum(detail_realisasi.nominal) > 0 then sum(detail_realisasi.nominal)
                                                        when sum(detail_realisasi.nominal) is null then 0
                                                    end
                                                    from    detail_realisasi
                                                    join    realisasi on realisasi.kd_realisasi = detail_realisasi.kd_realisasi
                                                    where   realisasi.periode = \''.$date.'\' and 
                                                            realisasi.kd_jenis_anggaran = \''.$jenis.'\'
                                    )) as nominal, no_anggaran, periode, kd_jenis_anggaran,kd_kegiatan')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function ambil_periode($jenis){
        $hasil = $this->db->order_by('periode')
                          ->where('kd_jenis_anggaran', $jenis)
                        //   ->where('periode >= ', date('Y-m-01'))
                          ->select('distinct(periode)')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function ambil_jenisnya_kegiatan($no_anggaran){
        $hasil = $this->db->where('no_anggaran', $no_anggaran)
                          ->limit(1)
                          ->join('kegiatan', 'kegiatan.unique_id = anggaran.kd_kegiatan')
                          ->join('jenis_kegiatan', 'jenis_kegiatan.kd_jenis_kegiatan = kegiatan.kd_jenis_kegiatan')
                          ->select('*')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        } else {
            return array();
        }
    }
    
    public function ambil_anggaran_kegiatan($date, $no_anggaran){
        $hasil = $this->db->where('periode', $date)
                          ->where('no_anggaran', $no_anggaran)
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function ambil_anggaran_kegiatan_test($date, $no_anggaran){
        // $hasil = $this->db->query('Select  sum(nominal)
        // from    detail_realisasi
        // join    realisasi on realisasi.kd_realisasi = detail_realisasi.kd_realisasi
        // where   realisasi.periode = \''.$date.'\' and
        //         detail_realisasi.no_anggaran = \''.$no_anggaran.'\'');
        $hasil = $this->db->where('periode', $date)
                          ->where('no_anggaran', $no_anggaran)
                          ->select('(nominal-(
                                                Select  Case
                                                    when sum(nominal) > 0 then sum(nominal)
                                                    when sum(nominal) is null then 0
                                                end
                                                from    detail_realisasi
                                                join    realisasi on realisasi.kd_realisasi = detail_realisasi.kd_realisasi
                                                where   realisasi.periode = \''.$date.'\' and
                                                        detail_realisasi.no_anggaran = \''.$no_anggaran.'\'
                          )) as nominal, no_anggaran, periode, kd_jenis_anggaran,kd_kegiatan')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function ambil_kegiatan($date, $jenis){
        $hasil = $this->db->where('periode', $date)
                          ->where('anggaran.kd_jenis_anggaran', $jenis)
                          ->join('kegiatan', 'anggaran.kd_kegiatan = kegiatan.unique_id')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }
    public function get_distinct_anggaran(){
        $hasil = $this->db->select('distinct(periode)')
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

    public function cari_anggaran_by_periode($periode, $jenis_anggaran){
        $hasil = $this->db->where('anggaran.kd_jenis_anggaran', $jenis_anggaran)
                          ->where('periode', $periode)
                          ->join('kegiatan', 'anggaran.kd_kegiatan = kegiatan.unique_id')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function cari_anggaran_by_periode_test($periode, $jenis_anggaran){
        $hasil = $this->db->where('anggaran.kd_jenis_anggaran', $jenis_anggaran)
                          ->where('periode', $periode)
                          ->join('kegiatan', 'anggaran.kd_kegiatan = kegiatan.unique_id')
                          ->select('((nominal) - (
                                                    select  case
                                                                when sum(nominal) > 0 then sum(nominal) 
                                                                when sum(nominal) is null then 0
                                                            end
                                                    from    detail_realisasi
                                                    where   anggaran.no_anggaran = detail_realisasi.no_anggaran
                          )) as nominal, no_anggaran, kegiatan.*')
                          ->get('anggaran');
        if($hasil->num_rows() > 0){
            return $hasil->result();
        } else {
            return array();
        }
    }

    public function cari_max_id_realisasi(){
        $hasil = $this->db->order_by('id', 'desc')
                          ->limit(1)
                          ->get('realisasi');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }

    public function cari_max($table){
        $hasil = $this->db->order_by('id', 'desc')
                          ->limit(1)
                          ->get($table);
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }

    public function saveRealisasi()
    {
        $data_awal = [
            'kd_realisasi'      => $_POST['kd_realisasi'],
            'no_anggaran'       => $_POST['nama_kegiatan'],
            'tgl_realisasi'     => date('Y-m-d'),
            'periode'           => $_POST['periode'],
            'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
        ];
        $this->db->insert('realisasi', $data_awal);
        $data = [
            'kd_realisasi'      => $_POST['kd_realisasi'],
            'no_anggaran'       => $_POST['nama_kegiatan'],
            'nominal'           => $_POST['nominal'],
            'keterangan'        => $_POST['keterangan'],
        ];
        $this->db->insert('detail_realisasi', $data);
    }

    public function saveJustRealisasi($data)
    {
        $this->db->insert('realisasi', $data);
    }
    public function saveDetailRealisasi($data){
        $this->db->insert('detail_realisasi', $data);
    }
    public function cari_anggaran_by_kd_kegiatan_and_periode($kd_kegiatan, $periode){
        $hasil = $this->db->where('kd_kegiatan', $kd_kegiatan)
                          ->where('periode', $periode)
                          ->limit(1)
                          ->get('anggaran');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }
    public function update_anggaran($id_anggaran, $data){
        $this->db->where('id', $id_anggaran)
                 ->update('anggaran', $data);
    }
    public function update_anggaran_by_no_anggaran($no_anggaran, $data){
        $this->db->where('no_anggaran', $no_anggaran)
                 ->update('anggaran', $data);
    }
    public function getDetailRealisasi($id)
    {
        $this->db->select('*');
        $this->db->from('realisasi');
        $this->db->join('detail_realisasi', 'detail_realisasi.kd_realisasi=realisasi.kd_realisasi');
        $this->db->join('anggaran', 'detail_realisasi.no_anggaran=detail_realisasi.no_anggaran');
        $this->db->join('jenis_anggaran', 'anggaran.kd_jenis_anggaran=jenis_anggaran.no_jenis_anggaran');
        $this->db->join('kegiatan', 'anggaran.kd_kegiatan=kegiatan.unique_id');
        $this->db->join('jenis_kegiatan', 'jenis_kegiatan.kd_jenis_kegiatan=kegiatan.kd_jenis_kegiatan');
        $this->db->where('realisasi.kd_realisasi', $id);
        return $this->db->get()->result_array();
    }
}
