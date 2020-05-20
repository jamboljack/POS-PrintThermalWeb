<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Stok Keluar</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Menu Logistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?=site_url('admin/keluar');?>">Stok Keluar</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah Stok Keluar</a>
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
                                    <i class="fa fa-plus-circle"></i> Form Data Stok Keluar
                                </div>
                            </div>

                            <div class="portlet-body form">
                                <form role="form" class="form-horizontal form" method="post" id="formInput" name="formInput">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Tanggal</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control date-picker" placeholder="DD-MM-YYYY" name="tanggal" id="tanggal" autocomplete="off" value="<?=date('d-m-Y');?>" autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Keterangan</label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control" placeholder="Enter Keterangan" name="keterangan" id="keterangan" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Petugas</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="petugas" id="petugas" value="<?=$this->session->userdata('nama');?>" autocomplete="off" readonly>
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
                                    <i class="fa fa-shopping-cart"></i> Total Qty
                                </div>
                            </div>
                            <div class="portlet-body">
                                <form role="form" class="form-horizontal form" method="post" id="formTotal" name="formTotal">
                                    <input type="hidden" name="totalkeluar" id="totalkeluar">
                                    <div class="form-body">
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-12 value" id="totalqty"></div>
                                        </div>
                                    </div>
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
                            <i class="fa fa-list"></i> Daftar Barang 
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form method="post" id="formBarang" role="form" name="formBarang" class="form">
                        <input type="hidden" name="barang_id" id="barang_id">
                        <input type="hidden" name="keluar_temp_id" id="keluar_temp_id">

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Cari Nama Barang" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <a data-toggle="modal" data-target="#formDataBarang" title="Cari Data Barang">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" autocomplete="off" placeholder="-" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <input type="text" class="form-control" name="kategori" id="kategori" autocomplete="off" placeholder="-" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" class="form-control number" name="qty" id="qty" autocomplete="off" placeholder="0" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" align="center">
                                <button class="btn btn-primary" id="btn_item" name="btn_item" disabled><i class="fa fa-floppy-o"></i> Simpan Item</button>
                                <a onclick="resetForm()" class="btn btn-danger" id="btn_reset" name="btn_reset" disabled><i class="fa fa-refresh"></i> Reset</a>
                                <button type="button" class="btn btn-primary" id="btn_simpan" name="btn_simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                                <a href="<?=site_url('admin/keluar');?>" type="button" class="btn btn-warning"><i class="fa fa-times"></i> Batal</a>
                            </div>
                        </form>
                    </div>

                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th width="15%">Kategori</th>
                                    <th width="10%">Jumlah</th>
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

<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#formDataBarang').on('shown.bs.modal', function () {
       var table = $('#tableDataBarang').DataTable();
       table.columns.adjust();
    });
});

var statusinput;
statusinput = 'Tambah';

$(document).ready(function() {
    $('.number').maskMoney({thousands:',', precision:0});
    hitungTotal();
    dataBarang();
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
            "url": "<?=site_url('admin/keluar/data_temp_list')?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1, 2, 3, 4, 5 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 5 ],
                "className": "text-center",
            }
        ],
    });    
});

function dataBarang() {
    var tableBarang;
    tableBarang = $('#tableDataBarang').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/keluar/data_barang_list'); ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 5 ],
                "className": "text-center",
            }
        ],
    });
}

function pilihdata(id) {
    $.ajax({
        url : "<?=site_url('admin/keluar/get_data_barang/'); ?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale          = 'en';
            var options         = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter       = new Intl.NumberFormat(locale, options);
            $('#barang_id').val(data.barang_id);
            $('#kode_barang').val(data.barang_kode);
            $('#nama_barang').val(data.barang_nama);
            $('#kategori').val(data.kategori_nama);
            $('#qty').val(1); 
            document.formBarang.qty.disabled=false;
            document.formBarang.btn_item.disabled=false;
            $("#btn_reset").attr("disabled", false);
            $('#formDataBarang').modal('hide');
            $('#qty').focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function resetForm() {
    statusinput = 'Tambah';
    $('#barang_id').val('');
    $('#kode_barang').val('');
    $('#nama_barang').val('');
    $('#kategori').val('');
    $('#qty').val('');
    document.formBarang.qty.disabled=true;
    $("#btn_item").attr("disabled", true);
    $("#btn_reset").attr("disabled", true);
    dataBarang();
    $('#kode_barang').focus();

    var MValid = $("#formBarang");
    MValid.validate().resetForm();
}

// Simpan Transaksi
$("#btn_simpan").click(function() {
    dataString = $(".form").serialize();
    $.ajax({
        url: '<?=site_url('admin/keluar/savedata');?>',
        type: "POST",
        data: dataString,
        success: function(data) {
            swal({
                title:"Sukses",
                text: "Simpan Transaksi Berhasil",
                timer: 2000,
                showConfirmButton: false,
                type: "success"
            });
            reload_table();
            resetFormKeluar();
        },
        error: function() {
            swal({
                title:"Error",
                text: "Simpan Transaksi Gagal",
                timer: 2000,
                showConfirmButton: false,
                type: "error"
            });
        }
    });
});

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
            tanggal: { required: true },
            keterangan: { required: true },
            kode_barang: { required: true },
            qty: { required: true }
        },
        messages: {
            tanggal: { required :'Tanggal required' },
            keterangan: { required :'Keterangan required' },
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
                    url: '<?=site_url('admin/keluar/saveitem');?>',
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
                    url: '<?=site_url('admin/keluar/updateitem');?>',
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
        url : "<?=site_url('admin/keluar/get_data_total_temp');?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var Qty      = 0;
            var TotalQty = 0;
            if (data == null) {
                Qty      = 0;
                TotalQty = 0;
            } else if (data.total == null) {
                Qty      = 0;
                TotalQty = 0;
            } else {
                var locale      = 'en';
                var options     = {minimumFractionDigits: 0, maximumFractionDigits: 0};
                var formatter   = new Intl.NumberFormat(locale, options);
                TotalQty        = data.total;
                Qty             = formatter.format(TotalQty);
            }

            $('#totalkeluar').val(TotalQty);
            $('#totalqty').text(Qty);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get Total');
        }
    });
}

function editData(id) {
    statusinput = 'Edit';
    $.ajax({
        url : "<?=site_url('admin/keluar/get_data_item/');?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale      = 'en';
            var options     = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter   = new Intl.NumberFormat(locale, options);
            var options1    = {minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter1  = new Intl.NumberFormat(locale, options1);
            $('#keluar_temp_id').val(data.keluar_temp_id);
            $('#barang_id').val(data.barang_id);
            $('#kode_barang').val(data.barang_kode);
            $('#nama_barang').val(data.barang_nama);
            $('#kategori').val(data.kategori_nama);
            $('#qty').val(formatter.format(data.keluar_temp_qty));
            document.formBarang.qty.disabled=false;
            document.formBarang.btn_item.disabled=false;
            $("#btn_reset").attr("disabled", false);
            $('#qty').focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function hapusData(keluar_temp_id) {
    var id = keluar_temp_id;
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
            url : "<?=site_url('admin/keluar/deleteitem')?>/"+id,
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

function resetFormKeluar() {
    statusinput = 'Tambah';
    $('#keterangan').val('');
    $('#barang_id').val('');
    $('#kode_barang').val('');
    $('#nama_barang').val('');
    $('#kategori').val('');
    $('#qty').val('');
    document.formBarang.qty.disabled=true;
    document.formBarang.btn_item.disabled=false;
    $("#btn_reset").attr("disabled", true);
    dataBarang();
    hitungTotal();

    var MValid = $("form");
    MValid.validate().resetForm();
    MValid.find(".has-success, .has-warning, .fa-warning, .fa-check").removeClass("has-success has-warning fa-warning fa-check");
    MValid.find("i.fa[data-original-title]").removeAttr('data-original-title');
    document.getElementById("tanggal").focus();
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
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>