<?php

class transaksi extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('m_transaksi');
        $this->load->model('m_laporan');
        $this->load->library('session');
    }

    public function anggaran(){
        $this->session->set_userdata('kd_jenis_kegiatan', null);
        $this->session->set_userdata('tanggalan', null);
        $pages = 'transaksi/anggaran/index';
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Anggaran',
            'subtitle'      => 'List Data Anggaran',
            'result'        => $this->db->select('no_anggaran, periode, SUM(nominal) as nominal', FALSE)->group_by('periode')->get('anggaran')->result_array(),
            'jenis_anggaran' => $this->m_transaksi->get('jenis_anggaran'),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function detail_anggaran($tanggal)
    {
        $pages = 'transaksi/anggaran/detail_anggaran_view';
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Anggaran',
            'subtitle'      => 'List Data Anggaran',
            'result'        => $this->db->where('periode', $tanggal)
                                        ->join('jenis_anggaran', 'jenis_anggaran.no_jenis_anggaran = anggaran.kd_jenis_anggaran')
                                        ->join('kegiatan', 'kegiatan.unique_id = anggaran.kd_kegiatan')
                                        ->get('anggaran')->result_array(),
            'jenis_anggaran' => $this->m_transaksi->get('jenis_anggaran'),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function transfer_anggaran($no_anggaran){
        $pages = 'transaksi/anggaran/transfer_anggaran';
        $anggaran = $this->m_transaksi->lihat_anggaran_by_no_anggaran($no_anggaran);
        $realisasi = $this->m_transaksi->lihat_realisasi($no_anggaran);
        $this->form_validation->set_rules('transfer', 'Nominal transfer', 'required', [
            'required' => 'Jumlah transfer harus diisi'
        ]);
        $this->form_validation->set_rules('bulan', 'Bulan', 'required', [
            'required' => 'Bulan harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $data = [
                'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
                'title'         => 'Anggaran',
                'subtitle'      => 'Transfer Anggaran',
                'subsubtitle'   => 'Transfer Anggaran',
                'no_anggaran'   => $no_anggaran,
                'anggaran'      => $anggaran,
                'realisasi'     => $realisasi
            ];
            $this->main_generic->layout($pages, $data);
        } else {
            $sisa_anggaran = $anggaran->nominal-$realisasi->realisasi;
            if(set_value('transfer') > $sisa_anggaran){
                var_dump('Transfer melebihi sisa anggaran');
                die();
            } else {
                $data = array(
                    'nominal'   => $anggaran->nominal-set_value('transfer')
                );
                $this->m_transaksi->update_anggaran($anggaran->id, $data);

                $tanggal = date('Y-m-01', strtotime(set_value('bulan')));
                $cari    = $this->m_transaksi->cari_anggaran_by_kd_kegiatan_and_periode($anggaran->kd_kegiatan, $tanggal);
                if($cari == null){
                    $max_id = $this->m_transaksi->cari_max('anggaran');
                    if($max_id == null){
                        $idnya = 'AGR-001';
                    } else {
                        $use = $max_id->id+1;
                        $panjangnya = strlen($use);
                        if($panjangnya == 3){
                            $idnya = 'AGR-'.$use;
                        } else if($panjangnya == 2){
                            $idnya = 'AGR-0'.$use;
                        } else {
                            $idnya = 'AGR-00'.$use;
                        }
                    }
                    $data = array(
                        'no_anggaran'       => $idnya,
                        'periode'           => $tanggal,
                        'kd_jenis_anggaran' => $anggaran->kd_jenis_anggaran,
                        'kd_kegiatan'       => $anggaran->kd_kegiatan,
                        'nominal'           => set_value('transfer')
                    );
                    $this->m_transaksi->insert_table('anggaran', $data);
                    redirect('transaksi/sisa_anggaran');
                } else {
                    $nominal_ada = $cari->nominal+set_value('transfer');
                    $data = array(
                        'nominal'   => $nominal_ada
                    );
                    $this->m_transaksi->update_anggaran($cari->id, $data);
                    redirect('transaksi/sisa_anggaran');
                }
            }
        }
        
    }

    public function tambah_anggaran(){
        if(empty($_POST['jenis_anggaran'])) {
            $kdJenisKegiatan = $this->session->userdata('kd_jenis_kegiatan');
        } else {
            $this->session->set_userdata('kd_jenis_kegiatan', $_POST['jenis_anggaran']);
            $kdJenisKegiatan = $this->session->userdata('kd_jenis_kegiatan');
        }
        // var_dump($this->session->userdata('kd_jenis_kegiatan'));die();

        $data = $this->db->select('kd_jenis_kegiatan')->where('kd_jenis_anggaran', $kdJenisKegiatan)->from('kegiatan')->get()->result();
        if($data == null){
            var_dump('pastikan sudah ada kegiatan untuk jenis anggaran yang dipilih (pendapatan/pengeluaran)'); die();
        } // var_dump($data); die();
        $result = [];

        foreach($data as $hasil) {
            array_push($result, $hasil->kd_jenis_kegiatan);
        }
        error_reporting(0);
        if($_POST['month'] != null){    
            $bulan = intval(date('m', strtotime($_POST['month'])));
            $tahun = intval(date('Y', strtotime($_POST['month'])));
            $tanggalan = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-01'));
            $this->session->set_userdata('tanggalan', $tanggalan);
        }

        ini_set('display_errors', 0);
        $pages = 'transaksi/anggaran/tambah_anggaran';
        $data['no_anggaran'] = $this->m_transaksi->kode_anggaran();
        // var_dump($kdJenisKegiatan); die();
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Anggaran',
            'subtitle'          => 'Detail Anggaran',
            'subsubtitle'       => 'Tambah Data Anggaran',
            'jenis_kegiatan'    => $this->db->where('kd_jenis_anggaran', $kdJenisKegiatan)->get('kegiatan')->result_array(),
            'jenis_anggaran'    => $_POST['jenis_anggaran'],
            'bulan'             => $bulan,
            'tahun'             => $tahun,
            'no_anggaran'       => $this->m_transaksi->kode_anggaran(),
            'detail_anggaran'   => $this->m_transaksi->get_detail_anggaran_by_date_and_jenis($this->session->userdata('tanggalan'), $kdJenisKegiatan),
        ];
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required', [
            'required' => '%s Harus diisi'
        ]);
        $this->form_validation->set_rules('nominal', 'Nominal', 'required', [
            'required' => '%s Harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $query = $this->m_transaksi->cari_anggaran_by_periode_and_kd_kegiatan($this->session->userdata('tanggalan'), $_POST['jenis_kegiatan']);
            if ($query == null) {
                $this->db->select('kd_jenis_anggaran,periode');
                $this->db->from('anggaran');
                $this->db->where('no_anggaran', $_POST['no_anggaran']);
                
                $data = [
                    'no_anggaran'       => $_POST['no_anggaran'],
                    'kd_jenis_anggaran' => $this->session->userdata('kd_jenis_kegiatan'),
                    'kd_kegiatan'       => $_POST['jenis_kegiatan'],
                    'periode'           => $this->session->userdata('tanggalan'),
                    'nominal'           => $_POST['nominal'],
                ];
                $data['periode'] = $this->session->userdata('tanggalan');
                $this->m_transaksi->insert_table('anggaran', $data);
            } else {
                $nominal = $query->nominal+$_POST['nominal'];
                $data = array(
                    'nominal'   => $nominal
                );
                $this->m_transaksi->update_anggaran($query->id, $data);
            }
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('transaksi/tambah_anggaran');
        }
    }

    public function selesai_anggaran()
    {
        $data = [
            'no_anggaran'   => $_POST['no_anggaran'],
            'periode'       => $_POST['period'],
            'nominal'       => $_POST['nominal'],
        ];
        $this->db->insert('anggaran', $data);
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('transaksi/anggaran');
    }

    public function realisasi()
    {
        $pages = "transaksi/realisasi/realisasi_view";
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Data Realisasi',
            'result'            => $this->db->select('realisasi.kd_realisasi, tgl_realisasi, kd_jenis_anggaran, SUM(nominal) as nominal_realisasi', FALSE)
                                            ->join('detail_realisasi', 'detail_realisasi.kd_realisasi = realisasi.kd_realisasi')
                                            ->group_by('kd_realisasi')
                                            ->get('realisasi')
                                            ->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function detail_realisasi($kd_realisasi)
    {
        $pages = "transaksi/realisasi/detail_realisasi_view";
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Detail Realisasi',
            'result'            => $this->db->where('realisasi.kd_realisasi', $kd_realisasi)
                                            ->join('detail_realisasi', 'detail_realisasi.kd_realisasi = realisasi.kd_realisasi')
                                            ->get('realisasi')->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function ambil_budget(){
        $hasil = $this->m_transaksi->ambil_budget_by_date_test(set_value('isi_tanggal'), set_value('jenis'));
        // $hasil = $this->m_transaksi->ambil_budget_by_date(set_value('isi_tanggal'), set_value('jenis'));
        // $hasil = $this->m_transaksi->ambil_budget_by_date('2019-10-01', 'JGR-556');
        $total = 0;
        foreach ($hasil as $val) {
            $total = $total+$val->nominal;
        }
        echo json_encode($total);
        // var_dump($total);
    }

    public function ambil_kegiatan(){
        $hasil = $this->m_transaksi->ambil_kegiatan(set_value('isi_tanggal'), set_value('jenis'));
        echo json_encode($hasil);
    }

    public function anggaran_kegiatan(){
        // $hasil = $this->m_transaksi->ambil_anggaran_kegiatan('2019-10-01', 'KGT-970');
        $hasil = $this->m_transaksi->ambil_anggaran_kegiatan_test(set_value('tanggal'), set_value('no_anggaran'));
        echo json_encode($hasil);
        // var_dump($hasil);
        // die();
    }

    public function ambil_periode(){
        $hasil = $this->m_transaksi->ambil_periode(set_value('jenis'));
        echo json_encode($hasil);
    }

    public function tambahRealisasi()
    {
        $pages = "transaksi/realisasi/realisasi_form";
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Form Input Realisasi',
            'kode'              => $this->m_transaksi->kode('realisasi', 'kd_realisasi', 'KRA'),
            'kegiatan'          => $this->m_transaksi->get('kegiatan'),
            'periode'           => $this->m_transaksi->get_distinct_anggaran(),
            'jenis_kegiatan'    => $this->m_transaksi->get('jenis_kegiatan'),
        ];
        $data['detail'] = $this->m_transaksi->getDetailRealisasi($data['kode']);
        $this->form_validation->set_rules('nama_kegiatan', 'Jenis Kegiatan', 'required', [
            'required' => '%s Harus diisi'
        ]);
        $this->form_validation->set_rules('jenis_anggaran', 'Jenis Kegiatan', 'required', [
            'required' => '%s Harus diisi'
        ]);
        $this->form_validation->set_rules('nominal', 'Nominal', 'required', [
            'required' => '%s Harus diisi'
        ]);
        $this->form_validation->set_rules('nominal_hasil_kurang', 'Anda harus check terlebih dahulu', 'required', [
            'required' => '%s Harus diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            // var_dump(set_value('jenis_anggaran'));die();
            if((set_value('sisa_anggaran') < set_value('nominal')) and (set_value('jenis_anggaran') == 'JGR-664')){
                // var_dump('1');die();
                redirect('transaksi/tambah_kekurangan_anggaran/'.set_value('nama_kegiatan').'/'.set_value('nominal_hasil_kurang'));
            } else if((set_value('nominal_hasil_kurang') < 0) and (set_value('jenis_anggaran') == 'JGR-664')){
                // var_dump('jos2'); die();
                $data1 = [
                    'kd_realisasi'      => $_POST['kd_realisasi'],
                    'no_anggaran'       => $_POST['nama_kegiatan'],
                    'tgl_realisasi'     => date('Y-m-d'),
                    'periode'           => $_POST['periode'],
                    'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
                ];
                $data2 = [
                    'kd_realisasi'      => $_POST['kd_realisasi'],
                    'no_anggaran'       => $_POST['nama_kegiatan'],
                    'nominal'           => $_POST['nominal'],
                    'keterangan'        => $_POST['keterangan'],
                ];
                $this->session->set_userdata('data_1', $data1);
                $this->session->set_userdata('data_2', $data2);
                redirect('transaksi/tambahKekuranganRealisasi/'.set_value('kd_realisasi').'/'.set_value('periode').'/'.set_value('jenis_anggaran'));
            } else {
                // var_dump('jos3'); die();
                $this->m_transaksi->saveRealisasi();
                $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
                $this->session->set_flashdata('message', $alert);
                redirect('transaksi/realisasi');
            }
        }
    }

    public function tambah_kekurangan_anggaran($no_anggaran, $kurang){
        $pages = "transaksi/anggaran/tambah_kekurangan_anggaran";
        $anggaran = $this->m_transaksi->lihat_anggaran_by_no_anggaran($no_anggaran);
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Tambah anggaran',
            'subtitle'          => 'Form Input anggaran',
            'subsubtitle'       => '',
            'no_anggaran'       => $no_anggaran,
            'nominal'           => $anggaran->nominal,
            'kurang'            => $kurang
        ];
        $this->form_validation->set_rules('tambah', 'Tambah', 'required', [
            'required' => 'Tambah harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            if(set_value('tambah') >= $kurang){
                $tambahin = $anggaran->nominal+set_value('tambah');
                $data = array(
                    'nominal'   => $tambahin
                );
                $this->m_transaksi->update_anggaran_by_no_anggaran($no_anggaran, $data);
                redirect('transaksi/realisasi');
            } else {
                redirect('transaksi/tambah_kekurangan_anggaran/'.$no_anggaran.'/'.$kurang);
            }
        }
    }
    public function sisa_anggaran(){
        $pages = 'transaksi/anggaran/sisa_anggaran';
        $data = [
            'user'      => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'     => 'Sisa Anggaran',
            'subtitle'  => 'Sisa Anggaran',
            'result'    => $this->db->order_by('periode', 'asc')
                                    ->select('distinct(periode)')
                                    ->get('anggaran')->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function detail_sisa_anggaran($periode){
        $pages = 'transaksi/anggaran/detail_sisa_anggaran';
        $data = [
            'user'      => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'     => 'Sisa Anggaran',
            'subtitle'  => 'Sisa Anggaran',
            'result'    => $this->db->order_by('id', 'asc')
                                    ->where('periode', $periode)
                                    ->select("no_anggaran, nominal as anggaran, (
                                        select  sum(detail_realisasi.nominal)
                                        from    detail_realisasi
                                        join    realisasi on realisasi.kd_realisasi = detail_realisasi.kd_realisasi
                                        where   detail_realisasi.no_anggaran = anggaran.no_anggaran and
                                                realisasi.periode = anggaran.periode
                                    ) as nominal")
                                    ->get('anggaran')->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function tambahKekuranganRealisasi($kd_realisasi, $periode, $jenis_anggaran){
        $this->form_validation->set_rules('selisinya_dua_nilai', 'Selisih', 'required',
            array('required'	=> 'Anda harus mengklik tombol check')
        );
        $cari_anggaran = $this->m_transaksi->cari_anggaran_by_periode_test($periode, $jenis_anggaran);
        if ($this->form_validation->run() == False) {
            // var_dump($this->session->userdata('data_2'));die();
            $pages = 'transaksi/realisasi/tambahKekuranganRealisasi';
            $data = [
                'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
                'title'             => 'Realisasi',
                'subtitle'          => 'Alokasi dana',
            ];
            $data['anggaran']   = $cari_anggaran;
            $this->main_generic->layout($pages, $data);
		} else {
            $jumlah = count($cari_anggaran);
            $data = array(
                'kd_realisasi'      => $this->session->userdata('data_1')['kd_realisasi'],
                'no_anggaran'       => $this->session->userdata('data_2')['no_anggaran'],
                'tgl_realisasi'     => $this->session->userdata('data_1')['tgl_realisasi'],
                'periode'           => $this->session->userdata('data_1')['periode'],
                'kd_jenis_anggaran' => $this->session->userdata('data_1')['kd_jenis_anggaran']
            );
            $this->m_transaksi->saveJustRealisasi($data);

            $max_id = $this->m_transaksi->cari_max_id_realisasi();
            $idnya  = $max_id->kd_realisasi;

            $data = array(
                'kd_realisasi'  => $idnya,
                'no_anggaran'   => $this->session->userdata('data_2')['no_anggaran'],
                'nominal'       => set_value('nominal')-set_value('anggaran_seharusnya'),
                'keterangan'    => set_value('keterangan')
            );
            $this->m_transaksi->saveDetailRealisasi($data);

            $a = 1;
            while ($a < $jumlah) {
                if(set_value('nominal'.$a) > 0){
                    $data = array(
                        'kd_realisasi'  => $idnya,
                        'no_anggaran'   => set_value('no_anggaran'.$a),
                        'nominal'       => set_value('nominal'.$a),
                        'keterangan'    => set_value('keterangan'.$a)
                    );
                    $this->m_transaksi->saveDetailRealisasi($data);
                }
                $a++;
            }
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('transaksi/realisasi');
        }
    }

    public function selesaiRealisasi()
    {
        $detail = $this->m_transaksi->getDetailRealisasi($_POST['kd_realisasi']);
        foreach ($detail as $cols) {
            //var_dump($detail);
            if ($cols['kd_kegiatan'] == 'KGT-643') {
                $kd_akun = '515';
            } else if ($cols['kd_kegiatan'] == 'KGT-728') {
                $kd_akun = '515';
            } else if ($cols['kd_kegiatan'] == 'KGT-338') {
                $kd_akun = '515';
            } else if ($cols['kd_kegiatan'] == 'KGT-642') {
                $kd_akun = '515';
            } else if ($cols['kd_kegiatan'] == 'KGT-727') {
                $kd_akun = '515';
            } else if ($cols['kd_kegiatan'] == 'KGT-974') {
                $kd_akun = '511';
            } else if ($cols['kd_kegiatan'] == 'KGT-401') {
                $kd_akun = '513';
            } else if ($cols['kd_kegiatan'] == 'KGT-240') {
                $kd_akun = '512';
            } else if ($cols['kd_kegiatan'] == 'KGT-270') {
                $kd_akun = '121';
            } else if ($cols['kd_kegiatan'] == 'KGT-859') {
                $kd_akun = '516';
            } else if ($cols['kd_kegiatan'] == 'KGT-510') {
                $kd_akun = '113';
            } else if ($cols['kd_kegiatan'] == 'KGT-288') {
                $kd_akun = '113';
            } else if ($cols['kd_kegiatan'] == 'KGT-510') {
                $kd_akun = '517';
            }
            $this->m_laporan->insertJurnal($kd_akun, date('Y-m-d'), $cols['nominal'], 'debit');
        }
        $this->m_laporan->insertJurnal('111', date('Y-m-d'), $_POST['nominal'], 'kredit');
        $data = [
            'kd_realisasi' => $_POST['kd_realisasi'],
            'tgl_realisasi' => date('Y-m-d'),
            'nominal_realisasi'       => $_POST['nominal'],
        ];
        $this->db->insert('realisasi_anggaran', $data);
        $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
        $this->session->set_flashdata('message', $alert);
        redirect('transaksi/realisasi');
    }

    public function detailRealisasi($params)
    {
        $pages = 'transaksi/realisasi/detail_realisasi';
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Laporan Realisasi',
        ];
        $data['detail'] = $this->m_transaksi->getDetailRealisasi($params);
        // $this->db->insert('realisasi_anggaran', $data);
        // $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
        // $this->session->set_flashdata('message', $alert);
        // redirect('transaksi/realisasi');
        $this->main_generic->layout($pages, $data);
    }

    public function test(){
        $this->load->model('m_coa');
        $hasil = $this->m_coa->get_all_kredit();
    }
}
