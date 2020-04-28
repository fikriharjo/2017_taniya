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
    }
    public function lihat_jurnal()
    {
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
        $data['debit']  = $this->m_laporan->get_total_db($bulan, $tahun);
        $data['credit'] = $this->m_laporan->get_total_cr($bulan, $tahun);
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
        $previous1 = $this->m_laporan->total_db($akun, $bulan - 1, $tahun);
        $previous2 = $this->m_laporan->total_cr($akun, $bulan - 1, $tahun);
        $saldo = $previous1 - $previous2;
        if (!empty($saldo)) {
            $data['saldo_awal'] = $saldo;
        } else {
            $data['saldo_awal'] = 0;
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
    public function LaporanAnggaran()
    {
        $pages = 'laporan/laporanAnggaran';
        if (isset($_POST['bulan']) && $_POST['tahun']) {
            $bulan = $_POST['bulan'];
            $tahun = $_POST['tahun'];
            $pendapatan = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-556')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            $pengeluaran = @$this->db->select('periode, SUM(nominal) as nominal')->where('periode', $tahun.'-'.$bulan.'-'.'01')->where('kd_jenis_anggaran', 'JGR-664')->group_by('periode')->get('detail_anggaran')->result()[0]->nominal;
            $totalAnggaranPendapatan = empty($pendapatan) ? 0 : $pendapatan;
            $totalAnggaranPengeluaran = empty($pengeluaran) ? 0 : $pengeluaran;
        } else {
            $bulan = '0';
            $tahun = '0';
            $totalAnggaranPendapatan = 0;
            $totalAnggaranPengeluaran = 0;
        }
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Laporan',
            'subtitle'          => 'Laporan Anggaran',
        ];
        $data['lap'] = $this->m_laporan->getLaporanAnggaran($bulan, $tahun, 'JKGT-208');
        $data['lap2'] = $this->m_laporan->getLaporanAnggaran($bulan, $tahun, 'JKGT-216');
        $data['lap3'] = $this->m_laporan->getLaporanAnggaran($bulan, $tahun, 'JKGT-288');
        $data['totalAnggaranPendapatan'] = $totalAnggaranPendapatan;
        $data['totalAnggaranPengeluaran'] = $totalAnggaranPengeluaran;
        // $this->db->insert('realisasi_anggaran', $data);
        // $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
        // $this->session->set_flashdata('message', $alert);
        // redirect('transaksi/realisasi');
        $this->main_generic->layout($pages, $data);

    }
}
