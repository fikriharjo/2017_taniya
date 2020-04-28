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

    public function anggaran()
    {
        $pages = 'transaksi/anggaran/index';
        $data = [
            'user'          => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'         => 'Anggaran',
            'subtitle'      => 'List Data Anggaran',
            'result'        => $this->db->select('no_anggaran, tgl_anggaran, SUM(nominal) as nominal', FALSE)->group_by('tgl_anggaran')->get('anggaran')->result_array(),
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
            'result'        => $this->db->where('tgl_anggaran', $tanggal)
                                        ->join('detail_anggaran', 'detail_anggaran.no_anggaran = anggaran.no_anggaran') 
                                        ->join('jenis_anggaran', 'jenis_anggaran.no_jenis_anggaran = kd_jenis_anggaran')
                                        ->join('kegiatan', 'kegiatan.unique_id = detail_anggaran.kd_kegiatan')
                                        ->get('anggaran')->result_array(),
            'jenis_anggaran' => $this->m_transaksi->get('jenis_anggaran'),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function tambah_anggaran()
    {
        if(empty($_POST['jenis_anggaran'])) {
            $kdJenisKegiatan = $this->session->userdata('kd_jenis_kegiatan');
        } else {
            $this->session->set_userdata(['kd_jenis_kegiatan' => $_POST['jenis_anggaran']]);
            $kdJenisKegiatan = $this->session->userdata('kd_jenis_kegiatan');
        }
       
        $data = $this->db->select('kd_jenis_kegiatan')->where('kd_jenis_anggaran', $kdJenisKegiatan)->from('jenis_kegiatan')->get()->result();
        $result = [];

        foreach($data as $hasil) {
            array_push($result, $hasil->kd_jenis_kegiatan);
        }

        error_reporting(0);
        ini_set('display_errors', 0);
        $pages = 'transaksi/anggaran/tambah_anggaran';
        $data['no_anggaran'] = $this->m_transaksi->kode_anggaran();
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Anggaran',
            'subtitle'          => 'Detail Anggaran',
            'subsubtitle'       => 'Tambah Data Anggaran',
            'jenis_kegiatan'    => $this->db->where_in('kd_jenis_kegiatan', $result)->get('kegiatan')->result_array(),
            'jenis_anggaran'    => $_POST['jenis_anggaran'],
            'bulan'             => $_POST['bulan'],
            'tahun'             => $_POST['tahun'],
            'no_anggaran'       => $this->m_transaksi->kode_anggaran(),
            'detail_anggaran'   => $this->m_transaksi->get_detail_anggaran($data['no_anggaran']),
        ];
        // var_dump($data['detail_anggaran']);
        // die;
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required', [
            'required' => '%s Harus diisi'
        ]);
        $this->form_validation->set_rules('nominal', 'Nominal', 'required', [
            'required' => '%s Harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->db->where(array(
                'no_anggaran'       => $_POST['no_anggaran'],
                'kd_kegiatan' => $_POST['jenis_kegiatan'],
            ));
            $query = $this->db->get('detail_anggaran');
            if ($query->num_rows() == 0) {
                $this->db->select('kd_jenis_anggaran,periode');
                $this->db->from('detail_anggaran');
                $this->db->where('no_anggaran', $_POST['no_anggaran']);
                $query2 = $this->db->get()->row_array();

                $data = [
                    'no_anggaran'       => $_POST['no_anggaran'],
                    'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
                    'kd_kegiatan'       => $_POST['jenis_kegiatan'],
                    //'periode'           => date("Y-m-d", mktime(0, 0, 0, $_POST['bulan'], 1, $_POST['tahun'])),
                    'nominal'           => $_POST['nominal'],
                ];
                if (!empty($query2)) {
                    $data['periode'] =  $query2['periode'];
                } else {
                    $data['periode'] = date("Y-m-d", mktime(0, 0, 0, $_POST['bulan'], 1, $_POST['tahun']));
                }

                // var_dump($_POST['jenis_anggaran']);
                // die;
                $this->m_transaksi->insert_table('detail_anggaran', $data);
            } else {
                $this->db->set('nominal', 'nominal+' . $_POST['nominal'] . '', False);
                $this->db->where(array(
                    'no_anggaran'       => $_POST['no_anggaran'],
                    'kd_jenis_anggaran' => $_POST['jenis_anggaran'],
                    'kd_kegiatan' => $_POST['jenis_kegiatan'],
                ));
                $this->db->update('detail_anggaran');
            }
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('transaksi/tambah_anggaran');
        }
    }

    public function selesai_anggaran()
    {
        $data = [
            'no_anggaran' => $_POST['no_anggaran'],
            'tgl_anggaran' => $_POST['period'],
            'nominal' => $_POST['nominal'],
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
            'result'            => $this->db->select('kd_realisasi, tgl_realisasi, SUM(nominal_realisasi) as nominal_realisasi', FALSE)->group_by('tgl_realisasi')->get('realisasi_anggaran')->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function detail_realisasi($tanggal)
    {
        $pages = "transaksi/realisasi/detail_realisasi_view";
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Detail Realisasi',
            'result'            => $this->db->where('tgl_realisasi', $tanggal)->get('realisasi_anggaran')->result_array(),
        ];
        $this->main_generic->layout($pages, $data);
    }

    public function ambil_budget(){
        $hasil = $this->m_transaksi->ambil_budget_by_date(set_value('isi_tanggal'));
        $total = 0;
        foreach ($hasil as $val) {
            $total = $total+$val->nominal;
        }
        echo json_encode($total);
    }

    public function tambahRealisasi()
    {
        $pages = "transaksi/realisasi/realisasi_form";
        $data = [
            'user'              => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title'             => 'Realisasi',
            'subtitle'          => 'Form Input Realisasi',
            'kode'              => $this->m_transaksi->kode('realisasi_anggaran', 'kd_realisasi', 'KRA'),
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
        if ($this->form_validation->run() == false) {
            $this->main_generic->layout($pages, $data);
        } else {
            $this->m_transaksi->saveRealisasi();
            $alert = $this->main_generic->alert('Berhasil', 'Data berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $alert);
            redirect('transaksi/tambahRealisasi');
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
}
