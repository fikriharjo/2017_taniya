<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <!-- <?php echo form_error('nama_kegiatan', '<div class="alert alert-danger" role="alert">', '</div>') ?> -->
    <?php echo $this->session->flashdata('message'); ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $subtitle ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form class="form-horizontal" action="<?= base_url('transaksi/tambahRealisasi') ?>" method="POST" id='formnya'>
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Kode Realisasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $kode ?>" name="kd_realisasi" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Tanggal Realisasi</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="tgl">
                            <input type="hidden" id="hide">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                            $query = $this->db->get('jenis_anggaran')->result_array();
                            ?>
                            <label>
                                <?php 
                                    $a = 0;
                                    foreach ($query as $row) { 
                                        $a++; ?>
                                    <input type="radio" name="jenis_anggaran" 
                                            class='jenis_anggaran' id=<?php echo 'jenis_anggaran'.$a ?> 
                                            value="<?= $row['no_jenis_anggaran'] ?>" onclick='display_result(this.value)'> <?= $row['jenis_anggaran'] ?>
                                    <?= form_error('jenis_anggaran', '<small class="text-danger pl-3">', '</small>') ?>
                                <?php } ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Periode anggaran</label>
                        <div class="col-sm-6" id='isian_periode'>
                            <select name="periode" id='periode' class="form-control">
                                <option disabled selected>-- Pilih periode --</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="sisa_anggaran" name='sisa_anggaran' readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Nama Kegiatan</label>
                        <div class="col-sm-6">
                            <select name="nama_kegiatan" id="nama_kegiatan" name='nama_kegiatan' class="form-control">
                                <option disabled selected>-- Pilih nama kegiatan --</option>
                            </select>
                            <?= form_error('nama_kegiatan', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="anggaran_seharusnya" readonly>
                        </div>
                        <input type="hidden" class="form-control" id="namanya_kegiatan" name='namanya_kegiatan'>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nominal Realisasi</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="nominal" id='nominal'>
                            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type='button' class='col-sm-1 control-label' onclick='cek_kecukupan_anggaran();'>
                            <div align='center'>Check</div>
                        </button>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="nominal_hasil_kurang" id='nominal_hasil_kurang' readonly>
                            <?= form_error('nominal_hasil_kurang', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="keterangan"></textarea>
                            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info pull-right" id='boleh_dibuka'>
                    <i class="fa fa-plus"></i> Tambah
                </button>
                <button type="button" class="btn btn-info pull-right" id='boleh_dibuka2' onclick='next_page()'>
                    <i class="fa fa-plus"></i> Tambah
                </button>
                <button type="button" class="btn btn-info pull-right" id='boleh_dibuka3' onclick='tambah_anggaran()'>
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </form>
        </div>
    </div>
    <?php if (!empty($detail)) { ?>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Realisasi></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Realisasi</th>
                            <th>Jenis Realisasi</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            <th class="text:right">Nominal Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                            $nominal = 0;
                            foreach ($detail as $row) {
                                $no++;
                                $nominal += $row['nominal']; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['kd_realisasi'] ?></td>
                                <td><?= $row['jenis_anggaran'] ?></td>
                                <td><?= $row['jenis_kegiatan'] ?></td>
                                <td><?= $row['nama_kegiatan'] ?></td>
                                <td align="right"><?= formatRp($row['nominal']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-success pull-rigth" data-toggle="modal" data-target="#modal-warning">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
<div class="modal modal-warning fade" id="modal-warning" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title">Peringatan!!!!!!</h3>
            </div>
            <div class="modal-body">
                <p>Data Yang Telah Disimpan Tidak Dapat Diubah Dan Dihapus, Mohon Dicek kembali Data Yang Telah Diinputkan</p>
                <form action="<?= base_url('transaksi/selesaiRealisasi') ?>" method="post">
                    <input type="hidden" name="kd_realisasi" value="<?= $kode ?>">
                    <input type="hidden" name="nominal" value="<?= $nominal ?>">
                    <?php $i = 0;
                    foreach ($detail as $row) {
                        $i++; ?>
                        <input type="hidden" name="akt[<?= $i ?>]" value="<?= $row['kd_kegiatan'] ?>">
                    <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save changes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function(){
        $('#boleh_dibuka').hide();
        $('#boleh_dibuka2').hide();
        $('#boleh_dibuka3').hide();
    });
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    });
    $(document).on('click', '.btn-warning', function() {
        var kgt_id = $(this).attr('data-kgt_id'),
            name = $(this).attr('data-name'),
            kode = $(this).attr('data-kode');
        $('#kgt_id').val(kgt_id);
        $('#name').val(name);
        $('#kode').val(kode);

    });

    localStorage.setItem('isian', 0);
    function setMonthPicker() {
        $(".monthpicker").datetimepicker({
            format: "MM",
            useCurrent: false,
            viewMode: "months"
        })
    }

    function display_result(value){
        $('#boleh_dibuka').hide();
        $('#boleh_dibuka2').hide();
        $('#boleh_dibuka3').hide();
        $('#sisa_anggaran').val('');
        $('#anggaran_seharusnya').val('');
        $('#nominal_hasil_kurang').val('');
        $('#nominal').val('');
        $('#nama_kegiatan').html('<option disabled selected>-- Pilih nama kegiatan --</option>');
        var jenisnya = value;
        // alert(jenisnya);
        localStorage.setItem('isian', jenisnya);
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_periode') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                jenis : jenisnya
            },
            success : function(data){
                var periode = [];
                var bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

                data.map(val => {
                    periode.push(val.periode);
                })
                var html =  '<option disabled selected>-- Pilih periode --</option>';

                for (let index = 0; index < periode.length; index++) {
                    var hasilnya = periode[index].split('-');
                    hasilnya[1]  = Number(hasilnya[1]);
                    var bulannya = bulan[hasilnya[1]]+' - '+hasilnya[0];
                    html += '<option value='+periode[index]+'>'+bulannya+'</option>';
                }
                $('#periode').html(html);
                
                $('#hide').val(jenisnya);
            }
        })
    }

    function cek_kecukupan_anggaran(){
        var nama_kegiatan   = document.getElementById('nama_kegiatan').value;
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_namanya_kegiatan') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                no_anggaran : nama_kegiatan
            },
            success : function(data){
                var seharusnya      = document.getElementById('anggaran_seharusnya').value;
                var realisasinya    = document.getElementById('nominal').value;
                var sisa_anggaran   = document.getElementById('sisa_anggaran').value;
                var pengurangan     = seharusnya-realisasinya;
                var open_ga         = sisa_anggaran-realisasinya;
                $('#nominal_hasil_kurang').val(pengurangan);
                $('#namanya_kegiatan').val(data);
                var jenis = document.getElementById('hide').value;
                // alert(jenis);
                if(jenis != 'JGR-556'){
                    // alert(nama_kegiatan)
                    if(data == 'Investasi'){
                        alert('Bisa di proses');
                        $('#boleh_dibuka').show();
                        $('#boleh_dibuka2').hide();
                        $('#boleh_dibuka3').hide();
                    } else {
                        if(open_ga >= 0){
                            alert('Bisa di proses');
                            if((realisasinya > seharusnya)){
                                $('#boleh_dibuka').hide();
                                $('#boleh_dibuka2').show();
                                $('#boleh_dibuka3').hide();
                            } else {
                                $('#boleh_dibuka').show();
                                $('#boleh_dibuka2').hide();
                                $('#boleh_dibuka3').hide();
                            }
                        } else {
                            alert('Total anggaran kurang');
                            $('#boleh_dibuka').hide();
                            $('#boleh_dibuka2').hide();
                            $('#boleh_dibuka3').show();
                        }
                    }
                } else {
                    alert('Bisa di proses');
                    $('#boleh_dibuka').show();
                    $('#boleh_dibuka2').hide();
                    $('#boleh_dibuka3').hide();
                }
            }
        })
    }

    function tambah_anggaran(){
        var r = confirm('Apakah anda ingin menambah anggaran?');
        if(r == true){
            document.getElementById("formnya").submit();
        }
    }

    // $('#jenis_anggaran1').change(function(){
    //     $('#boleh_dibuka').hide();
    //     $('#boleh_dibuka2').hide();
    //     $('#sisa_anggaran').val('');
    //     $('#anggaran_seharusnya').val('');
    //     $('#nominal_hasil_kurang').val('');
    //     $('#nominal').val('');
    //     $('#nama_kegiatan').html('<option disabled selected>-- Pilih nama kegiatan --</option>');
    //     var jenisnya = document.getElementById('jenis_anggaran1').value;
    //     localStorage.setItem('isian', jenisnya);
    //     $.ajax({
    //         url : '<?php echo base_url('transaksi/ambil_periode') ?>',
    //         async : false,
    //         dataType : 'JSON',
    //         method : 'POST',
    //         data : {
    //             jenis : jenisnya
    //         },
    //         success : function(data){
    //             var periode = [];
    //             var bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    //             data.map(val => {
    //                 periode.push(val.periode);
    //             })
    //             var html =  '<option disabled selected>-- Pilih periode --</option>';

    //             for (let index = 0; index < periode.length; index++) {
    //                 var hasilnya = periode[index].split('-');
    //                 hasilnya[1]  = Number(hasilnya[1]);
    //                 var bulannya = bulan[hasilnya[1]]+' - '+hasilnya[0];
    //                 html += '<option value='+periode[index]+'>'+bulannya+'</option>';
    //             }
    //             $('#periode').html(html);
    //         }
    //     })
    // });

    // $('#jenis_anggaran2').change(function(){
    //     $('#sisa_anggaran').val('');
    //     $('#anggaran_seharusnya').val('');
    //     $('#nominal_hasil_kurang').val('');
    //     $('#nominal').val('');
    //     $('#boleh_dibuka').hide();
    //     $('#boleh_dibuka2').hide();
    //     $('#nama_kegiatan').html('<option disabled selected>-- Pilih nama kegiatan --</option>');
    //     var jenisnya = document.getElementById('jenis_anggaran2').value;
    //     localStorage.setItem('isian', jenisnya);
    //     $.ajax({
    //         url : '<?php echo base_url('transaksi/ambil_periode') ?>',
    //         async : false,
    //         dataType : 'JSON',
    //         method : 'POST',
    //         data : {
    //             jenis : jenisnya
    //         },
    //         success : function(data){
    //             var periode = [];
    //             var bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    //             data.map(val => {
    //                 periode.push(val.periode);
    //             })
    //             var html =  '<option disabled selected>-- Pilih periode --</option>';

    //             for (let index = 0; index < periode.length; index++) {
    //                 var hasilnya = periode[index].split('-');
    //                 hasilnya[1]  = Number(hasilnya[1]);
    //                 var bulannya = bulan[hasilnya[1]]+' - '+hasilnya[0];
    //                 html += '<option value='+periode[index]+'>'+bulannya+'</option>';
    //             }
    //             $('#periode').html(html);
    //         }
    //     })
    // });

    $('#periode').change(function(){
        $('#boleh_dibuka').hide();
        $('#boleh_dibuka2').hide();
        $('#boleh_dibuka3').hide();
        var isi_tanggal = document.getElementById('periode').value;
        $('#anggaran_seharusnya').val('');
        $('#nominal_hasil_kurang').val('');
        $('#nominal').val('');
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_budget') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                isi_tanggal : isi_tanggal,
                jenis       : localStorage.getItem('isian')
            },
            success : function(data){
                $('#sisa_anggaran').val(data);
            }
        })

        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_kegiatan') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                isi_tanggal : isi_tanggal,
                jenis       : localStorage.getItem('isian')
            }, 
            success : function(data){

                var nama_kegiatannya = [];
                var no_anggaran = [];

                data.map(val =>{
                    nama_kegiatannya.push(val.nama_kegiatan);
                    no_anggaran.push(val.no_anggaran);
                })

                var html =  '<option disabled selected>-- Pilih nama kegiatan --</option>';       
                for (let index = 0; index < nama_kegiatannya.length; index++) {
                    html += '<option value='+no_anggaran[index]+'>'+nama_kegiatannya[index]+'</option>';               
                }

                $('#nama_kegiatan').html(html);
            }
        })
    });

    function next_page(){
        var r = confirm('Apa anda yakin untuk alokasi dana?');
        if(r == true){
            document.getElementById("formnya").submit();
        }
    }

    $('#nama_kegiatan').change(function(){
        $('#boleh_dibuka').hide();
        $('#boleh_dibuka2').hide();
        var isi_tanggal = document.getElementById('periode').value;
        var no_anggaran = document.getElementById('nama_kegiatan').value;
        $.ajax({
            url : '<?php echo base_url('transaksi/anggaran_kegiatan') ?>',
            async : false,
            method : 'POST',
            dataType : 'JSON',
            data : {
                tanggal : isi_tanggal,
                no_anggaran : no_anggaran
            },
            success : function(data){
                var nilai = [];
                
                data.map(val=>{
                    nilai.push(val.nominal);
                })

                $('#anggaran_seharusnya').val(nilai[0])
            }
        })
    })

    // $('#nama_kegiatan').change(function(){
    //     var isi_tanggal         = document.getElementById('periode').value;
    //     var nama_kegiatannya    = document.getElementById('nama_kegiatan').value;
    //     $.ajax({
    //         url : '<?php echo base_url('transaksi/ambil_kegiatan') ?>',
    //         async : false,
    //         dataType : 'JSON',
    //         method : 'POST',
    //         data : {
    //             isi_tanggal : isi_tanggal,
    //             nama_kegiatannya : nama_kegiatannya
    //         },
    //         success : function(data){
    //             alert('jos');
    //         }
    //     })
    // })
</script>