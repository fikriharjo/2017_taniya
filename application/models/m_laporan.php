<?php

class m_laporan extends CI_model
{
    public function insertJurnal($kode, $tgl, $nominal, $posisi)
    {
        $data = [
            'kode_akun'  => $kode,
            'tgl_jurnal'    => $tgl,
            'nominal'       => $nominal,
            'posisi_dr_cr'       => $posisi,
        ];
        $this->db->insert('jurnal', $data);
    }
    // function get_jurnal($bulan, $tahun)
    // {
    //     $this->db->select('distinct(realisasi.kd_realisasi), detail_realisasi.nominal as nominal, coa1, coa2, tgl_realisasi,');
    //     $this->db->from('realisasi');
    //     $this->db->join('detail_realisasi', 'realisasi.kd_realisasi = detail_realisasi.kd_realisasi');
    //     $this->db->join('anggaran', 'anggaran.no_anggaran = realisasi.no_anggaran');
    //     $this->db->join('kegiatan', 'kegiatan.unique_id = anggaran.kd_kegiatan');
    //     $this->db->where('DATE_FORMAT(tgl_realisasi,"%m")', $bulan);
    //     $this->db->where('DATE_FORMAT(tgl_realisasi,"%Y")', $tahun);
    //     $this->db->order_by('detail_realisasi.nominal');
    //     return $this->db->get()->result_array();
    // }
    function get_jurnal($bulan, $tahun)
    {
        $this->db->select('distinct(realisasi.kd_realisasi), (
                                                                    select      sum(nominal)
                                                                    from        detail_realisasi
                                                                    where       detail_realisasi.kd_realisasi = realisasi.kd_realisasi
        ) as nominal, coa1, coa2, tgl_realisasi,');
        $this->db->from('realisasi');
        $this->db->join('anggaran', 'anggaran.no_anggaran = realisasi.no_anggaran');
        $this->db->join('kegiatan', 'kegiatan.unique_id = anggaran.kd_kegiatan');
        $this->db->where('DATE_FORMAT(tgl_realisasi,"%m")', $bulan);
        $this->db->where('DATE_FORMAT(tgl_realisasi,"%Y")', $tahun);
        $this->db->order_by('realisasi.kd_realisasi');
        return $this->db->get()->result_array();
    }
    function get_total_db($bulan, $tahun)
    {
        $this->db->select('sum(nominal)as total');
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%m")', $bulan);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%Y")', $tahun);
        $this->db->where('posisi_dr_cr', 'debit');
        return $this->db->get('jurnal')->row()->total;
    }
    function get_total_cr($bulan, $tahun)
    {
        $this->db->select('sum(nominal)as total');
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%m")', $bulan);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%Y")', $tahun);
        $this->db->where('posisi_dr_cr', 'kredit');
        return $this->db->get('jurnal')->row()->total;
    }
    public function get_buku_besar($akun, $tanggal)
    {
        $tanggal = "'".$tanggal."'";
        $cari =
        $this->db->query('  Select  detail_realisasi.nominal, kegiatan.nama_kegiatan, realisasi.tgl_realisasi, jenis_anggaran.jenis_anggaran, coa1, coa2
                            From    realisasi
                            Join    detail_realisasi ON realisasi.kd_realisasi = detail_realisasi.kd_realisasi
                            Join    anggaran ON detail_realisasi.no_anggaran = anggaran.no_anggaran
                            Join    kegiatan ON anggaran.kd_kegiatan = kegiatan.unique_id
                            Join    jenis_anggaran ON jenis_anggaran.no_jenis_anggaran = anggaran.kd_jenis_anggaran
                            Where   (kegiatan.coa1 = '.$akun.' or 
                                    kegiatan.coa2 = '.$akun.') and
                                    realisasi.periode = '.$tanggal);
        return $cari->result_array();
    }
    public function get_buku_besar_before($akun, $tanggal)
    {
        $tanggal = "'".$tanggal."'";
        $cari =
        $this->db->query('  Select  detail_realisasi.nominal, kegiatan.nama_kegiatan, realisasi.tgl_realisasi, jenis_anggaran.jenis_anggaran, coa1, coa2
                            From    realisasi
                            Join    detail_realisasi ON realisasi.kd_realisasi = detail_realisasi.kd_realisasi
                            Join    anggaran ON detail_realisasi.no_anggaran = anggaran.no_anggaran
                            Join    kegiatan ON anggaran.kd_kegiatan = kegiatan.unique_id
                            Join    jenis_anggaran ON jenis_anggaran.no_jenis_anggaran = anggaran.kd_jenis_anggaran
                            Where   (kegiatan.coa1 = '.$akun.' or 
                                    kegiatan.coa2 = '.$akun.') and
                                    realisasi.periode < '.$tanggal);
        return $cari->result();
    }
    public function total_db($akun, $bulan, $tahun){
        $this->db->select('sum(nominal) as nominal');
        $this->db->from('jurnal');
        $this->db->where('kode_akun', $akun);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%m")<=', $bulan);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%Y")<=', $tahun);
        $this->db->where('posisi_dr_cr', 'debit');
        return $this->db->get()->row()->nominal;
    }
    public function total_cr($akun, $bulan, $tahun)
    {
        $this->db->select('sum(nominal) as nominal');
        $this->db->from('jurnal');
        $this->db->where('kode_akun', $akun);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%m")<=', $bulan);
        $this->db->where('DATE_FORMAT(tgl_jurnal,"%Y")<=', $tahun);
        $this->db->where('posisi_dr_cr', 'kredit');
        return $this->db->get()->row()->nominal;
    }
    public function get_akun()
    {
        return $this->db->get('coa')->result_array();
    }
    public function get_dataAkun($kode_akun)
    {
        $this->db->where('kode_akun', $kode_akun);
        return $this->db->get('coa')->row_array();
    }
    function getLaporanAnggaran($bulan, $tahun, $condition)
    {
        $this->db->select('coa.nominal,nama_kegiatan');
        $this->db->from('anggaran');
        $this->db->join('coa', 'coa.kode_akun=anggaran.kode_akun');
        $this->db->join('kegiatan', 'detail_anggaran.kd_kegiatan=kegiatan.unique_id');
        $this->db->join('jenis_kegiatan', 'jenis_kegiatan.kd_jenis_kegiatan=kegiatan.kd_jenis_kegiatan');
        $this->db->join('jenis_anggaran', 'detail_anggaran.kd_jenis_anggaran=jenis_anggaran.no_jenis_anggaran');
        $this->db->where('DATE_FORMAT(anggaran.tgl_anggaran,"%m")', $bulan);
        $this->db->where('DATE_FORMAT(anggaran.tgl_anggaran,"%Y")', $tahun);
        $this->db->where('jenis_kegiatan.kd_jenis_kegiatan', $condition);
        $this->db->order_by('anggaran.id');
        return $this->db->get()->result_array();
    }
}
