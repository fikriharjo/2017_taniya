<?php

class laporan extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('m_laporan');
        $this->load->model('m_coa');
        $this->load->model('m_transaksi');
    }
    public function lihat_jurnal(){
        $pages = 'laporan/jurnal';
        if (isset($_POST['month'])) {
            $bulan = date('m', strtotime(set_value('month')));
            $tahun = date('Y', strtotime(set_value('month')));
            // var_dump($tahun); die();
        } else {
            $bulan = '0';
            $tahun = '0';
        }
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Jurnal',
            'subtitle'      => 'List Data Jurnal',
        ];
        
        $data['bulan']  = $bulan;
        $data['coa']    = $this->m_coa->get2('coa');
        $data['jurnal'] = $this->m_laporan->get_jurnal($bulan, $tahun);
        $data['menu']   = 'journal';
        $this->main_generic->layout($pages, $data);
    }
    public function bukuBesar()
    {
        $pages = 'laporan/bukuBesar';
        if (isset($_POST['akun']) && $_POST['month']) {
            $akun       = $_POST['akun'];
            $tanggal    = date('Y-m-01', strtotime($_POST['month']));
            $bulan      = date('m', strtotime($_POST['month']));
            $tahun      = date('Y', strtotime($_POST['month']));
            // $buku_besar = $this->m_laporan->get_buku_besar($akun, $tanggal);
            // var_dump($buku_besar);
            // die();
        } else {
            $akun       = '0';
            $bulan      = '0';
            $tahun      = '0';
            $tanggal    = '0';
        }
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Buku Besar',
            'subtitle'      => 'List Data Buku Besar',
        ];
        $data['inisial']    = $tahun . '-' . $bulan . '-01';
        $data['coa']        = $this->m_coa->get('coa');
        $data['akun']       = $akun;
        $data['before']     = $this->m_laporan->get_buku_besar_before($akun, $tanggal);
        $data['buku_besar'] = $this->m_laporan->get_buku_besar($akun, $tanggal);
        // var_dump($data['akun']);
        // die;
        $data['menu'] = 'ledger';
        $this->main_generic->layout($pages, $data);
    }
    public function laporanAnggaran()
    {
        $pages = 'laporan/laporanAnggaran';
        if (isset($_POST['month'])) {
            $bulan = date('m', strtotime($_POST['month']));
            $tahun = date('Y', strtotime($_POST['month']));
            $tanggal = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-01'));
            // $pendapatan = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-556')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            $anggaran = $this->m_transaksi->get_all_anggaran_by_periode($tanggal);
            // $pengeluaran = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-664')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            
            $pendapatan = 0;
            $pengeluaran = 0;
            $jumlah = 0;
            // var_dump($anggaran); die();
            foreach ($anggaran as $val) {
                $jumlah++;
                $jenisnya = strtoupper($val->jenis_anggaran);
                if($jenisnya == 'PENDAPATAN'){
                    $pendapatan = $pendapatan+$val->nominal;
                } else {
                    $pengeluaran = $pengeluaran+$val->nominal;
                }
            }
            $lap = $anggaran;
        } else {
            $bulan = '0';
            $tahun = '0';
            $pendapatan = 0;
            $pengeluaran = 0;
            $anggaran = 0;
            $jumlah = 0;
            $lap = null;
        }
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Laporan',
            'subtitle'      => 'Laporan Anggaran',
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'pendapatan'    => $pendapatan,
            'pengeluaran'   => $pengeluaran,
            'lap'           => $lap,
            'jumlah'        => $jumlah
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function bandingkanAnggaran()
    {
        // $hasil = 10000;
        // var_dump(number_format($hasil,0,',','.')); die();
        $pages = 'laporan/bandingkanAnggaran';
        if (isset($_POST['month'])) {
            $bulan = date('m', strtotime($_POST['month']));
            $tahun = date('Y', strtotime($_POST['month']));
            $tanggal = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-01'));
            // $pendapatan = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-556')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            $anggaran = $this->m_transaksi->get_all_anggaran_by_periode($tanggal);
            // var_dump($tanggal);die();
            $realisasi = $this->m_transaksi->lihat_realisasi_sum_detail($tanggal);
            // $pengeluaran = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-664')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            
            $pendapatan = 0;
            $pengeluaran = 0;
            $jumlah = 0;
            // var_dump($anggaran); die();
            foreach ($anggaran as $val) {
                $jumlah++;
                $jenisnya = strtoupper($val->jenis_anggaran);
                if($jenisnya == 'PENDAPATAN'){
                    $pendapatan = $pendapatan+$val->nominal;
                } else {
                    $pengeluaran = $pengeluaran+$val->nominal;
                }
            }
            $lap = $anggaran;
        } else {
            $bulan = '0';
            $tahun = '0';
            $pendapatan = 0;
            $pengeluaran = 0;
            $anggaran = 0;
            $jumlah = 0;
            $realisasi = 0;
            $lap = null;
        }
        // var_dump($realisasi); die();
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Laporan',
            'subtitle'      => 'Laporan Anggaran',
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'pendapatan'    => $pendapatan,
            'pengeluaran'   => $pengeluaran,
            'lap'           => $lap,
            'jumlah'        => $jumlah,
            'realisasi'     => $realisasi
        ];
        $this->main_generic->layout($pages, $data);
    }
    public function bandingkanPendapatan()
    {
        // $hasil = 10000;
        // var_dump(number_format($hasil,0,',','.')); die();
        $pages = 'laporan/bandingkanPendapatan';
        if (isset($_POST['month'])) {
            $bulan = date('m', strtotime($_POST['month']));
            $tahun = date('Y', strtotime($_POST['month']));
            $tanggal = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-01'));
            // $pendapatan = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-556')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            $anggaran = $this->m_transaksi->get_all_anggaran_by_periode($tanggal);
            // var_dump($tanggal);die();
            $realisasi = $this->m_transaksi->lihat_realisasi_sum_detail($tanggal);
            // $pengeluaran = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-664')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            
            $pendapatan = 0;
            $pengeluaran = 0;
            $jumlah = 0;
            // var_dump($anggaran); die();
            foreach ($anggaran as $val) {
                $jumlah++;
                $jenisnya = strtoupper($val->jenis_anggaran);
                if($jenisnya == 'PENDAPATAN'){
                    $pendapatan = $pendapatan+$val->nominal;
                } else {
                    $pengeluaran = $pengeluaran+$val->nominal;
                }
            }
            $lap = $anggaran;
        } else {
            $bulan = '0';
            $tahun = '0';
            $pendapatan = 0;
            $pengeluaran = 0;
            $anggaran = 0;
            $jumlah = 0;
            $realisasi = 0;
            $lap = null;
        }
        // var_dump($realisasi); die();
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Laporan',
            'subtitle'      => 'Laporan Anggaran',
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'pendapatan'    => $pendapatan,
            'pengeluaran'   => $pengeluaran,
            'lap'           => $lap,
            'jumlah'        => $jumlah,
            'realisasi'     => $realisasi
        ];
        $this->main_generic->layout($pages, $data);
    }
}
