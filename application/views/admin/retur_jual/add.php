<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Retur Penjualan Barang</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Menu Transaksi</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?=site_url('admin/retur_jual');?>">Retur Penjualan Barang</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah Retur Penjualan Barang</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height blue-madison">
                    <i class="icon-calendar">&nbsp; </i><span class="uppercase visible-lg-inline-block"><?=tgl_indo(date('Y-m-d'));?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="portlet box blue-madison">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-plus-circle"></i> Form Retur Penjualan
                                </div>
                            </div>

                            <div class="portlet-body form">
                                <form role="form" class="form-horizontal form" method="post" id="formInput" name="formInput">
                                <input type="hidden" name="pelanggan_id" id="pelanggan_id">
                                <input type="hidden" name="disc_pelanggan" id="disc_pelanggan">

                                    <div class="form-body">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Tanggal/Hari</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?=date('d-m-Y');?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="hari" id="hari" value="<?=getDay(date('Y-m-d'));?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Nama Pelanggan</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" autocomplete="off" placeholder="Cari Nama Pelanggan" autofocus>
                                                    </div>
                                                    <span class="input-group-btn">
                                                        <a data-toggle="modal" data-target="#formCariPelanggan" class="btn btn-success"><i class="fa fa-search"></i></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Alamat</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="alamat" id="alamat" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">No. Meja</label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" name="lstMeja" id="lstMeja">
                                                        <option value="">- Pilih No. Meja -</option>
                                                        <?php foreach($listMeja as $r) { ?>
                                                        <option value="<?=$r->meja_id;?>"><?=$r->meja_nama;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="portlet box blue-madison">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-plus-circle"></i> Total Transaksi : <?=$this->session->userdata('nama');?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form role="form" class="form-horizontal form" method="post" id="formTotal" name="formTotal">
                                    <div class="form-body">
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-12 value" id="totalinvoice"></div>
                                        </div>
                                    </div>
                                    <br><br>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>   
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue-madison">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Retur Penjualan Barang 
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form method="post" id="formBarang" role="form" name="formBarang" class="form">
                        <input type="hidden" name="barang_id" id="barang_id">
                        <input type="hidden" name="disc_rupiah" id="disc_rupiah">
                        <input type="hidden" name="retur_jual_temp_id" id="retur_jual_temp_id">

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Cari Kode Barang" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <a data-toggle="modal" data-target="#formDataBarang" title="Cari Data Barang">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
                                        </div>
                                    </div> 
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" class="form-control number" name="qty" id="qty" autocomplete="off" placeholder="0" onkeyup="hitungSubTotal()" disabled>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" name="harga" id="harga" autocomplete="off" placeholder="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Disc (%)</label>
                                            <input type="text" placeholder="0.00" class="form-control digit" name="disc" id="disc" onkeyup="hitungSubTotal()" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Sub Total</label>
                                            <input type="text" placeholder="0" class="form-control" name="total" id="total" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <input type="text" placeholder="Keterangan" autocomplete="off" class="form-control" name="keterangan" id="keterangan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" align="center">
                                <button class="btn btn-primary" id="btn_item" name="btn_item" disabled><i class="fa fa-floppy-o"></i> Simpan</button>
                                <a onclick="resetForm()" class="btn btn-danger" id="btn_reset" name="btn_reset" disabled><i class="fa fa-refresh"></i> Reset</a>
                                <a class="btn btn-primary" id="btn_bayar" data-toggle="modal" data-target="#formModalBayar" disabled><i class="fa fa-credit-card"></i> Bayar</a>
                                <a href="<?=site_url('admin/retur_jual');?>" type="button" class="btn btn-warning"><i class="fa fa-times"></i> Batal</a>
                            </div>
                        </form>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th>Nama Barang</th>
                                    <th width="5%">Jumlah</th>
                                    <th width="10%">Harga</th>
                                    <th width="5%">Disc (%)</th>
                                    <th width="10%">Sub Total</th>
                                    <th width="25%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#formDataBarang').on('shown.bs.modal', function () {
       var table = $('#tableDataBarang').DataTable();
       table.columns.adjust();
    });

    $('#formCariPelanggan').on('shown.bs.modal', function () {
       var table = $('#tableDataPelanggan').DataTable();
       table.columns.adjust();
    });
});

var statusinput;
statusinput = 'Tambah';

$(document).ready(function() {
    $('.number').maskMoney({thousands:',', precision:0});
    $('.digit').maskMoney({thousands:'', precision:2});
    hitungTotal();
    dataBarang();
    dataPelanggan();
    document.getElementById("btn_bayar").style.pointerEvents = "none";
});

function reload_table() {
    table.ajax.reload(null,false);
}

var table;
$(document).ready(function() {
    table = $('#tableData').DataTable({
        "paging": false,
        "info": false,
        "searching": false,
        "destoy": true,
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/retur_jual/data_temp_list')?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1 ],
                "className": "text-center",
            },
            {
                "targets": [ 4, 5, 6, 7 ],
                "className": "text-right",
            }
        ],
    });    
});

function dataPelanggan() {
    var tablePelanggan;
    tablePelanggan = $('#tableDataPelanggan').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/retur_jual/data_pelanggan_list'); ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1 ],
                "className": "text-center",
            }
        ],
    });
}

function dataBarang() {
    var tableBarang;
    tableBarang = $('#tableDataBarang').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/retur_jual/data_barang_list'); ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 5 ],
                "className": "text-center",
            },
            {
                "targets": [ 6 ],
                "className": "text-right",
            }
        ],
    });
}

function pilihPelanggan(id) {
    $.ajax({
        url : "<?=site_url('admin/retur_jual/get_data_pelanggan/'); ?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#pelanggan_id').val(data.pelanggan_id);
            $('#nama_pelanggan').val(data.pelanggan_nama);
            $('#alamat').val(data.pelanggan_alamat);
            $('#disc_pelanggan').val(data.pelanggan_disc);
            $("#btn_bayar").attr("disabled", false);
            document.getElementById("btn_bayar").style.pointerEvents = "auto";
            $('#formCariPelanggan').modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

$('#kode_barang').keydown(function (e) {
    if (e.which === 9 || e.which == 13){
        var kode_barang = $('#kode_barang').val();
        if (kode_barang === '') {
            swal({
                title:"Info",
                text: "Mohon Isi Kode Barang",
                timer: 2000,
                showConfirmButton: false,
                type: "info"
            });
        } else {
            $.ajax({
                url : "<?=site_url('admin/penjualan/get_data_barang_by_kode/'); ?>" + kode_barang,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data === null) {
                        swal({
                            title:"Info",
                            text: "Kode Barang tidak ditemukan",
                            timer: 2000,
                            showConfirmButton: false,
                            type: "info"
                        });
                    } else {
                        var locale          = 'en';
                        var options         = {minimumFractionDigits: 0, maximumFractionDigits: 0};
                        var formatter       = new Intl.NumberFormat(locale, options);
                        var disc_pelanggan  = document.getElementById("disc_pelanggan").value;
                        $('#barang_id').val(data.barang_id);
                        $('#kode_barang').val(data.barang_kode);
                        $('#nama_barang').val(data.barang_nama);
                        $('#kategori').val(data.kategori_nama);
                        $('#harga').val(formatter.format(data.barang_total));
                        $('#qty').val(1);
                        $('#disc').val(disc_pelanggan);
                        $('#total').val(formatter.format(data.barang_total));
                        document.formBarang.qty.disabled=false;
                        document.formBarang.disc.disabled=false;
                        document.formBarang.btn_item.disabled=false;
                        $("#btn_reset").attr("disabled", false);
                        hitungSubTotal();
                        $('#qty').focus();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data Barang from ajax');
                }
            });
        }
        e.preventDefault();
    }
});


function pilihData(id) {
    $.ajax({
        url : "<?=site_url('admin/retur_jual/get_data_barang/'); ?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale          = 'en';
            var options         = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter       = new Intl.NumberFormat(locale, options);
            var disc_pelanggan  = document.getElementById("disc_pelanggan").value;
            $('#barang_id').val(data.barang_id);
            $('#kode_barang').val(data.barang_kode);
            $('#nama_barang').val(data.barang_nama);
            $('#kategori').val(data.kategori_nama);
            $('#harga').val(formatter.format(data.barang_total));
            $('#qty').val(1);
            $('#disc').val(disc_pelanggan);
            $('#total').val(formatter.format(data.barang_total));
            document.formBarang.qty.disabled=false;
            document.formBarang.disc.disabled=false;
            document.formBarang.btn_item.disabled=false;
            $("#btn_reset").attr("disabled", false);
            $('#formDataBarang').modal('hide');
            hitungSubTotal();
            $('#qty').focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function hitungSubTotal() {
    var locale      = 'en';
    var options     = {minimumFractionDigits: 0, maximumFractionDigits: 0};
    var formatter   = new Intl.NumberFormat(locale, options);
    var myForm      = document.formBarang;
    var Qty         = myForm.qty.value;
    Qty             = Qty.replace(/[,]/g, ''); // Ini String
    Qty             = parseInt(Qty); // Ini Integer
    var Harga       = myForm.harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer
    var Disc        = myForm.disc.value;
    var SubTotal;
    if (Disc == '') {
        Disc        = 0;
        SubTotal    = (Qty*Harga);
    } else {
        Disc        = parseFloat(Disc); // Ini Float
        Disc        = (((Qty*Harga)*Disc)/100);
        SubTotal    = ((Qty*Harga)-Disc);
    }

    myForm.disc_rupiah.value = Disc;

    if (SubTotal > 0) {
        myForm.total.value = formatter.format(SubTotal);
    } else {
        myForm.total.value = 0;
    }
}

function resetForm() {
    statusinput = 'Tambah';
    $('#barang_id').val('');
    $('#kode_barang').val('');
    $('#nama_barang').val('');
    $('#qty').val('');
    $('#disc').val('');
    $('#disc_rupiah').val('');
    $('#harga').val('');
    $('#total').val('');
    $('#keterangan').val('');
    document.formBarang.qty.disabled=true;
    document.formBarang.disc.disabled=true;
    $("#btn_item").attr("disabled", true);
    $("#btn_reset").attr("disabled", true);
    $("#btn_bayar").attr("disabled", false);
    document.getElementById("btn_bayar").style.pointerEvents = "auto";
    dataBarang();
    $('#kode_barang').focus();

    var MValid = $("#formBarang");
    MValid.validate().resetForm();
}

$(document).ready(function() {
    var form    = $('form');
    var error   = $('.alert-danger', form);
    var success = $('.alert-success', form);

    $("form").validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            nama_pelanggan: { required: true },
            lstMeja: { required: true },
            kode_barang: { required: true },
            qty: { required: true }
        },
        messages: {
            nama_pelanggan: { required :'Nama Pelanggan required' },
            lstMeja: { required :'No. Meja required' },
            kode_barang: { required :'Kode Barang required' },
            qty: { required :'Jumlah required' }
        },
        invalidHandler: function (event, validator) {
            success.hide();
            error.show();
            Metronic.scrollTo(error, -200);
        },
        errorPlacement: function (error, element) {
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },
        highlight: function (element) {
            $(element)
            .closest('.form-group').removeClass("has-success").addClass('has-error');
        },
        unhighlight: function (element) {
        },
        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            icon.removeClass("fa-warning").addClass("fa-check");
        },
        submitHandler: function(form) {
            if (statusinput == 'Tambah') {
                dataString = $(".form").serialize();
                $.ajax({
                    url: '<?=site_url('admin/retur_jual/saveitem');?>',
                    type: "POST",
                    data: dataString,
                    success: function(data) {
                        resetForm();
                        reload_table();
                        hitungTotal();
                    },
                    error: function() {
                        swal({
                            title:"Error",
                            text: "Simpan Item Gagal",
                            timer: 2000,
                            showConfirmButton: false,
                            type: "error"
                        });
                    }
                });
            } else {
                dataString = $(".form").serialize();
                $.ajax({
                    url: '<?=site_url('admin/retur_jual/updateitem');?>',
                    type: "POST",
                    data: dataString,
                    success: function(data) {
                        resetForm();
                        reload_table();
                        hitungTotal();
                    },
                    error: function() {
                        swal({
                            title:"Error",
                            text: "Update Item Gagal",
                            timer: 2000,
                            showConfirmButton: false,
                            type: "error"
                        });
                    }
                });
            }
        }
    });
});

function hitungTotal() {
    $.ajax({
        url : "<?=site_url('admin/retur_jual/get_data_total_temp');?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale      = 'en';
            var options     = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter   = new Intl.NumberFormat(locale, options);

            var Total = 0;
            var TotalJual = 0;
            if (data == null) {
                Total        = 0;
                TotalJual    = 0;
            } else if (data.total == null) {
                Total        = 0;
                TotalJual    = 0;
            } else {
                TotalJual       = data.total;
                Total           = formatter.format(TotalJual);
            }

            $('#totalretur_jual').val(TotalJual);
            $('#bayar_subtotal').val(Total);
            $('#totalinvoice').text('Rp. '+Total);
            // $('#totalretur_jual').val(TotalJual);
            // $('#bayar_total').val(formatter.format(TotalJual));

            // var PPNJual     = '<?=$dataMeta->meta_ppn;?>';
            // var PPN         = 0;
            // var Bayar_Total = 0;
            // if (PPNJual === 0) {
            //     PPN             = 0;
            //     var Bayar_Total = TotalJual;
            // } else {
            //     PPN             = parseInt(((PPNJual*TotalJual)/100));
            //     var Bayar_Total = (parseInt(TotalJual)+PPN);
            // }

            // console.log(PPN, Bayar_Total);

            // $('#ppn_rupiah').val(PPN);
            $('#totalretur_jual').val(TotalJual);
            $('#bayar_total').val(formatter.format(TotalJual));
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get Total');
        }
    });
}

function editData(id) {
    statusinput = 'Edit';
    $.ajax({
        url : "<?=site_url('admin/retur_jual/get_data_item/');?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale      = 'en';
            var options     = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter   = new Intl.NumberFormat(locale, options);
            var options1    = {minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter1  = new Intl.NumberFormat(locale, options1);
            $('#retur_jual_temp_id').val(data.retur_jual_temp_id);
            $('#barang_id').val(data.barang_id);
            $('#kode_barang').val(data.retur_jual_temp_kode);
            $('#nama_barang').val(data.retur_jual_temp_nama);
            $('#qty').val(formatter.format(data.retur_jual_temp_qty));
            $('#disc').val(formatter1.format(data.retur_jual_temp_disc));
            $('#disc_rupiah').val(data.retur_jual_temp_disc_rp);
            $('#harga').val(formatter.format(data.retur_jual_temp_harga));
            $('#total').val(formatter.format(data.retur_jual_temp_subtotal));
            $('#keterangan').val(data.retur_jual_temp_keterangan);
            document.formBarang.qty.disabled=false;
            document.formBarang.disc.disabled=false;
            document.formBarang.harga.disabled=false;
            document.formBarang.btn_item.disabled=false;
            $("#btn_reset").attr("disabled", false);
            $('#kode_barang').focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function hapusData(retur_jual_temp_id) {
    var id = retur_jual_temp_id;
    swal({
        title: 'Anda Yakin ?',
        text: 'Item ini akan di Hapus !',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        closeOnConfirm: true
    }, function(isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url : "<?=site_url('admin/retur_jual/deleteitem')?>/"+id,
            type: "POST",
            success: function(data) {
                resetForm();
                reload_table();
                hitungTotal();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Hapus Item Gagal');
            }
        });
    });
}

function resetFormRetur() {
    statusinput = 'Tambah';
    $('#pelanggan_id').val('');
    $('#nama_pelanggan').val('');
    $('#alamat').val('');
    $('#lstMeja').val('');
    $('#barang_id').val('');
    $('#barang_kode').val('');
    $('#nama_barang').val('');
    $('#qty').val('');
    $('#disc').val('');
    $('#disc_rupiah').val('');
    $('#harga').val('');
    $('#total').val('');
    $('#keterangan').val('');
    $('#totalretur_jual').val('');
    $('#bayar_subtotal').val('');
    $('#bayar_total').val('');
    $('#lstTipe').val('');

    document.formBarang.qty.disabled=true;
    document.formBarang.disc.disabled=true;
    document.formBarang.harga.disabled=true;
    document.formBarang.btn_item.disabled=false;
    $("#btn_bayar").attr("disabled", true);
    $("#btn_reset").attr("disabled", true);
    document.getElementById("btn_bayar").style.pointerEvents = "none";
    dataBarang();
    dataPelanggan();
    hitungTotal();

    var MValid = $("form");
    MValid.validate().resetForm();
    MValid.find(".has-success, .has-warning, .fa-warning, .fa-check").removeClass("has-success has-warning fa-warning fa-check");
    MValid.find("i.fa[data-original-title]").removeAttr('data-original-title');
    document.getElementById("nama_pelanggan").focus();
}

function resetformPelanggan() {
    $("#nomor").val('');
    $("#nama").val('');
    $("#alamat_pelanggan").val('');
    $("#kota").val('');
    $("#telp").val('');
    $("#tgl_expired").val('');
    $("#disc_plg").val('');

    var MValid = $("#formPelanggan");
    MValid.validate().resetForm();
    MValid.find(".has-error").removeClass("has-error");
    MValid.removeAttr('aria-describedby');
    MValid.removeAttr('aria-invalid');
}

$(document).ready(function() {
    var form        = $('#formPelanggan');
    var error       = $('.alert-danger', form);
    var success     = $('.alert-success', form);

    $("#formPelanggan").validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            nomor: { required: true, 
                remote: {
                    url: "<?=site_url('admin/retur_jual/register_nomor_exists'); ?>",
                    type: "post",
                    data: {
                        nomor: function() { 
                            return $("#nomor").val(); 
                        }
                    }
                }
            },
            nama: { required: true },
            alamat_pelanggan: { required: true },
            kota: { required: true },
            telp: { required: true },
            tgl_expired: { required: true }
        },
        messages: {
            nomor: { required :'Nomor ID required', remote:'Nomor ID sudah Ada' },
            nama: { required :'Nama Pelanggan required' },
            alamat_pelanggan: { required :'Alamat required' },
            kota: { required :'Kota required' },
            telp: { required :'No. Telp required' },
            tgl_expired: { required :'Tgl. Expired required' }
        },
        invalidHandler: function (event, validator) {
            success.hide();
            error.show();
            Metronic.scrollTo(error, -200);
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
        }
    });

    $("#btn_pelanggan").click(function() {
        if($('#formPelanggan').valid()) {
            simpanPelanggan();
        }
    });
});

function simpanPelanggan() {
    dataString = $("#formPelanggan").serialize();
    $.ajax({
        url: '<?=site_url('admin/retur_jual/savedatapelanggan');?>',
        type: "POST",
        data: dataString,
        success: function(data) {
            swal({
                title:"Sukses",
                text: "Simpan Data Pelanggan Sukses",
                timer: 2000,
                showConfirmButton: false,
                type: "success"
            });
            $('#formModalPelanggan').modal('hide');
            resetformPelanggan();
            dataPelanggan();
        },
        error: function() {
            swal({
                title:"Error",
                text: "Simpan Data Pelanggan Gagal",
                timer: 2000,
                showConfirmButton: false,
                type: "error"
            });
            $('#formModalPelanggan').modal('hide');
            resetformPelanggan();
        }
    });
    return false;
}

$(document).ready(function() {
    var form        = $('#formBayar');
    var error       = $('.alert-danger', form);
    var success     = $('.alert-success', form);

    $("#formBayar").validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            lstTipe: { required: true }
        },
        messages: {
            lstTipe: { required :'Tipe Bayar required' }
        },
        invalidHandler: function (event, validator) {
            success.hide();
            error.show();
            Metronic.scrollTo(error, -200);
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
        }
    });

    $("#btn_simpan").click(function() {
        if($('#formBayar').valid()) {
            simpanTransaksi();
        }
    });
});


var printer = new Recta('2785262214', '1811');
function simpanTransaksi() {
    dataString = $(".form").serialize();
    $.ajax({
        url: '<?=site_url('admin/retur_jual/savedata');?>',
        type: "POST",
        data: dataString,
        dataType: 'JSON',
        success: function(data) {
            if (data.id != '') {
                swal({
                    title:"Sukses",
                    text: "Simpan Transaksi Sukses",
                    timer: 2000,
                    showConfirmButton: false,
                    type: "success"
                });
                
                // Cari Data by ID Retur Penjualan Baru untuk Cetak Nota
                var retur_jual_id = data.id;
                $.ajax({
                    url: '<?=site_url('admin/retur_jual/get_data/');?>'+retur_jual_id,
                    type: "POST",
                    dataType: 'JSON',
                    success: function(datap) {
                        var locale        = 'en';
                        var options       = {minimumFractionDigits: 0, maximumFractionDigits: 0};
                        var formatter     = new Intl.NumberFormat(locale, options);
                        var NoOrder       = datap.retur_jual_no;
                        var Tanggal       = datap.retur_jual_tanggal;
                        var Jam           = datap.retur_jual_jam;
                        var NamaPelanggan = datap.pelanggan_nama;
                        var Kasir         = datap.user_username;
                        var Meja          = datap.meja_nama;
                        Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja);
                        $.ajax({
                            url: '<?=site_url('admin/retur_jual/get_list_item/');?>'+retur_jual_id,
                            type: "POST",
                            dataType: 'JSON',
                            success: function(dataitem) {
                                if (dataitem != null) {
                                    var x = dataitem.length;
                                    for(var i = 0; i < x; i++) {
                                        var NamaBarang = dataitem[i].retur_jual_detail_nama;
                                        var Harga      = formatter.format(dataitem[i].retur_jual_detail_harga);
                                        var Qty        = formatter.format(dataitem[i].retur_jual_detail_qty);
                                        var Subtotal   = formatter.format(dataitem[i].retur_jual_detail_subtotal);
                                        ListItem(NamaBarang, Harga, Qty, Subtotal);
                                    }

                                    var TipeBayar  = datap.tipe_nama;
                                    var SubTotal   = formatter.format(datap.retur_jual_subtotal);
                                    var Total      = formatter.format(datap.retur_jual_total);
                                    Footer(TipeBayar, SubTotal, Total);
                                    FooterEnd();
                                }
                            }
                        });
                    }
                });
            } else {
                console.log('ID Kosong');
            }

            $('#formModalBayar').modal('hide');
            reload_table();
            resetFormRetur();
        },
        error: function() {
            swal({
                title:"Error",
                text: "Simpan Transaksi Gagal",
                timer: 2000,
                showConfirmButton: false,
                type: "error"
            });
            $('#formModalBayar').modal('hide');
            reload_table();
            resetFormRetur();
        }
    });
    return false;
}

function Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja) {
    var LimitChar = 20;
    var NamaToko  = '<?=$Toko->contact_name;?>';
    var Alamat    = '<?=$Toko->contact_address;?>';
    var Telp      = '<?=$Toko->contact_phone;?>';

    if(NamaToko.length <= LimitChar) {
        txtToko = NamaToko;
    } else {
        txtToko = NamaToko.substring(0, LimitChar);
    }

    if(Alamat.length <= LimitChar) {
        txtAlamat = Alamat;
    } else {
        txtAlamat = Alamat.substring(0, LimitChar);
    }

    if(Telp.length <= LimitChar) {
        txtTelp = Telp;
    } else {
        txtTelp = Telp.substring(0, LimitChar);
    }

    if(NoOrder.length <= LimitChar) {
        txtNoOrder = NoOrder;
    } else {
        txtNoOrder = NoOrder.substring(0, LimitChar);
    }

    if(NamaPelanggan.length <= LimitChar) {
        txtNamaPelanggan = NamaPelanggan;
    } else {
        txtNamaPelanggan = NamaPelanggan.substring(0, LimitChar);
    }

    printer.open().then(function () {
      printer.align('left')
        .bold(true)
        .text('     BLACKSTONE STREETLOUNGE    ')
        .text('             RUKO UMK           ')
        .bold(false)
        .text('--------------------------------')
        .print()
    })

    printer.open().then(function () {
      printer.align('left')
        .text('No. Retur : '+txtNoOrder)
        .text('Tanggal   : '+Tanggal+" "+Jam)
        .text('Pelanggan : '+txtNamaPelanggan)
        .text('Kasir     : '+Kasir)
        .text('Meja      : '+Meja)
        .text('--------------------------------')
        .print()
    })
}

function ListItem(NamaBarang, Harga, Qty, Subtotal) {
    var limitNamaBarang = 11;
    var limitHarga      = 7;
    var limitQty        = 3;
    var limitSubtotal   = 9;
    var txtBarang       = '';
    var txtHarga        = 0;
    var txtQty          = 0;
    var txtSubtotal     = 0;

    if(NamaBarang.length <= limitNamaBarang) {
        txtBarang = NamaBarang.padEnd(limitNamaBarang, ' ')
    } else {
        txtBarang = NamaBarang.substring(0, limitNamaBarang);
    }

    if (Harga.length <= limitHarga) {
        txtHarga = Harga.padStart(limitHarga, ' ')
    } else {
        txtHarga = Harga.substring(0, limitHarga);
    }

    if (Qty.length <= limitQty) {
        txtQty = Qty.padStart(limitQty, ' ')
    } else {
        txtQty = Qty.substring(0, limitQty);
    }

    if (Subtotal.length <= limitSubtotal) {
        txtSubtotal = Subtotal.padStart(limitSubtotal, ' ')
    } else {
        txtSubtotal = Subtotal.substring(0, limitSubtotal);
    }

    printer.open().then(function () {
      printer.align('left')
        .text(txtBarang+" "+txtHarga+" "+txtQty+""+txtSubtotal)
        .print()
    })
}

function Footer(TipeBayar, SubTotal, Total) {
    var limitNominal    = 9;
    var txtSubTotal     = 0;
    var txtDiskon       = 0;
    var txtDiskonPOIN   = 0;
    var txtPPN          = 0;
    var txtTotal        = 0;

    if (SubTotal.length <= limitNominal) {
        txtSubTotal = SubTotal.padStart(limitNominal, ' ')
    } else {
        txtSubTotal = SubTotal.substring(0, limitNominal);
    }

    if (Total.length <= limitNominal) {
        txtTotal = Total.padStart(limitNominal, ' ')
    } else {
        txtTotal = Total.substring(0, limitNominal);
    }

    printer.open().then(function () {
        printer.align('left')
        .text(TipeBayar)
        .text("           Sub Total : "+txtSubTotal)
        .print()
    })

    printer.open().then(function () {
        printer.align('left')
        .text("               TOTAL : "+txtTotal)
        .text("--------------------------------")
        .print()
    })
}

function FooterEnd() {
    printer.open().then(function () {
        printer.align('left')
        .feed(3)
        .cut()
        .print()
    })
}
</script>

<div class="modal fade bs-modal-lg" id="formDataBarang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Daftar Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover" id="tableDataBarang">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="5%">No</th>
                            <th width="10%">Kode Barang</th>
                            <th width="40%">Nama Barang</th>
                            <th width="15%">Kategori</th>
                            <th width="5%">Stok</th>
                            <th width="10%">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-lg" id="formCariPelanggan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-users"></i> Daftar Pelanggan</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover" id="tableDataPelanggan">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="5%">No</th>
                            <th width="10%">Nomor</th>
                            <th width="25%">Nama Pelanggan</th>
                            <th width="30%">Alamat</th>
                            <th width="15%">Kota</th>
                            <th width="10%">No. Telp</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="formModalPelanggan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="formPelanggan" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Form Tambah Pelanggan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nomor ID</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Nomor ID" name="nomor" id="nomor" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Pelanggan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Nama Pelanggan" name="nama" id="nama" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Alamat" name="alamat_pelanggan" id="alamat_pelanggan" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kota</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Kota" name="kota" id="kota" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">No. Telp</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input No. Telp" name="telp" id="telp" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Disc (%)</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control digit" placeholder="0.00" name="disc_plg" id="disc_plg" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tgl. Expired</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control date-picker" placeholder="DD-MM-YYYY" name="tgl_expired" id="tgl_expired" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="btn_pelanggan"><i class="fa fa-floppy-o"></i> Simpan</a>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="formModalBayar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="formBayar" name="formBayar" class="form-horizontal form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-shopping-cart"></i> Pembayaran Transaksi</h4>
                    <input type="hidden" name="totalretur_jual" id="totalretur_jual">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label">Tanggal</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="bayar_tanggal" id="bayar_tanggal" autocomplete="off" value="<?=date('d-m-Y H:i');?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label">Sub Total</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="bayar_subtotal" id="bayar_subtotal" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tipe Bayar</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="lstTipe" id="lstTipe">
                                        <option value="">- Pilih Tipe Bayar -</option>
                                        <?php foreach($listTipe as $r) { ?>
                                        <option value="<?=$r->tipe_id;?>"><?=$r->tipe_nama;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label"><b>TOTAL</b></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="bayar_total" id="bayar_total" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="btn_simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</a>
                </div>
            </form>
        </div>
    </div>
</div>