<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Pelanggan</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Data Master</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pelanggan</a>
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
                <div class="portlet box blue-madison">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Pelanggan
                        </div>
                        <div class="actions">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#formModalAdd">
                                <i class="fa fa-plus-circle"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="5%">No</th>
                                    <th width="10%">Nomor</th>
                                    <th width="20%">Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th width="5%">Disc (%)</th>
                                    <th width="10%">Tgl. Expired</th>
                                    <th width="5%">Poin</th>
                                    <th width="5%">Default</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.digit').maskMoney({thousands:'', precision:2});
});

var table;
$(document).ready(function() {
    table = $('#tableData').DataTable({
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/pelanggan/data_list');?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 6, 8 ],
                "className": "text-center",
            },
            {
                "targets": [ 5, 7 ],
                "className": "text-right",
            }
        ],
    });
});

function resetformInput() {
    $("#nomor").val('');
    $("#nama").val('');
    $("#alamat").val('');
    $("#kota").val('');
    $("#telp").val('');
    $("#disc").val('');
    $("#tgl_expired").val('');
    $("#lstStatus").val('');

    var MValid = $("#formInput");
    MValid.validate().resetForm();
    MValid.find(".has-error").removeClass("has-error");
    MValid.removeAttr('aria-describedby');
    MValid.removeAttr('aria-invalid');
}

function reload_table() {
    table.ajax.reload(null,false);
}

$(document).ready(function() {
    var form        = $('#formInput');
    var error       = $('.alert-danger', form);
    var success     = $('.alert-success', form);

    $("#formInput").validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            nomor: { required: true,
                remote: {
                    url: "<?=site_url('admin/pelanggan/register_nomor_exists'); ?>",
                    type: "post",
                    data: {
                        nomor: function() { 
                            return $("#nomor").val(); 
                        }
                    }
                }
            },
            nama: { required: true },
            alamat: { required: true },
            kota: { required: true },
            telp: { required: true },
            tgl_expired: { required: true },
            lstStatus: { required: true }
        },
        messages: {
            nomor: { required :'Nomor ID required', remote:'Nomor ID sudah Ada' },
            nama: { required :'Nama Pelanggan required' },
            alamat: { required :'Alamat required' },
            kota: { required :'Kota required' },
            telp: { required :'No. Telp required' },
            tgl_expired: { required :'Tgl. Expired required' },
            lstStatus: { required :'Status required' }
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
        },
        submitHandler: function(form) {
            dataString = $("#formInput").serialize();
            $.ajax({
                url: '<?=site_url('admin/pelanggan/savedata');?>',
                type: "POST",
                data: dataString,
                success: function(data) {
                    swal({
                        title:"Sukses",
                        text: "Simpan Data Sukses",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    });
                    $('#formModalAdd').modal('hide');
                    resetformInput();
                    reload_table();
                },
                error: function() {
                    swal({
                        title:"Error",
                        text: "Simpan Data Gagal",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "error"
                    });
                    $('#formModalAdd').modal('hide');
                    resetformInput();
                }
            });
        }
    });
});

function edit_data(id) {
    $('#formEdit')[0].reset();
    $.ajax({
        url : "<?=site_url('admin/pelanggan/get_data/');?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var locale      = 'en';
            var options     = {minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter   = new Intl.NumberFormat(locale, options);
            $('#id').val(data.pelanggan_id);
            $('#pelanggan_nomor').val(data.pelanggan_nomor);
            $('#pelanggan_nama').val(data.pelanggan_nama);
            $('#pelanggan_alamat').val(data.pelanggan_alamat);
            $('#pelanggan_kota').val(data.pelanggan_kota);
            $('#pelanggan_telp').val(data.pelanggan_telp);
            $('#pelanggan_disc').val(formatter.format(data.pelanggan_disc));
            $('#pelanggan_expired').val(data.pelanggan_expired.split("-").reverse().join("-"));
            $('#pelanggan_status').val(data.pelanggan_status);
            $('#formModalEdit').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

$(document).ready(function() {
    var form        = $('#formEdit');
    var error       = $('.alert-danger', form);
    var success     = $('.alert-success', form);

    $("#formEdit").validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        rules: {
            nomor: { required: true },
            nama: { required: true },
            alamat: { required: true },
            kota: { required: true },
            telp: { required: true },
            tgl_expired: { required: true },
            lstStatus: { required: true }
        },
        messages: {
            nomor: { required :'Nomor ID required' },
            nama: { required :'Nama Pelanggan required' },
            alamat: { required :'Alamat required' },
            kota: { required :'Kota required' },
            telp: { required :'No. Telp required' },
            tgl_expired: { required :'Tgl. Expired required' },
            lstStatus: { required :'Status required' }
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
        },
        submitHandler: function(form) {
            dataString = $("#formEdit").serialize();
            $.ajax({
                url: '<?=site_url('admin/pelanggan/updatedata');?>',
                type: "POST",
                data: dataString,
                success: function(data) {
                    swal({
                        title:"Sukses",
                        text: "Update Data Sukses",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    });
                    $('#formModalEdit').modal('hide');
                    reload_table();
                },
                error: function() {
                    swal({
                        title:"Error",
                        text: "Update Data Gagal",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "error"
                    });
                    $('#formModalEdit').modal('hide');
                }
            });
        }
    });
});

function hapusData(pelanggan_id) {
    var id = pelanggan_id;
    swal({
        title: 'Anda Yakin ?',
        text: 'Data ini akan di Hapus !',
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
            url : "<?=site_url('admin/pelanggan/deletedata')?>/"+id,
            type: "POST",
            success: function(data) {
                swal({
                    title:"Sukses",
                    text: "Hapus Data Sukses",
                    showConfirmButton: false,
                    type: "success",
                    timer: 2000
                });
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Hapus Data Gagal');
            }
        });
    });
}
</script>

<div class="modal" id="formModalAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="formInput" class="form-horizontal">
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
                            <input type="text" class="form-control" placeholder="Input Alamat" name="alamat" id="alamat" autocomplete="off">
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
                        <div class="col-md-4">
                            <input type="text" class="form-control digit" placeholder="0.00" name="disc" id="disc" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tgl. Expired</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control date-picker" placeholder="DD-MM-YYYY" name="tgl_expired" id="tgl_expired" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Default ?</label>
                        <div class="col-md-4">
                            <select class="form-control" name="lstStatus" id="lstStatus">
                                <option value="">- Pilih Status -</option>
                                <option value="Y">Ya</option>
                                <option value="T">Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="formModalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="formEdit" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Pelanggan</h4>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nomor ID</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Nomor ID" name="nomor" id="pelanggan_nomor" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Pelanggan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Nama Pelanggan" name="nama" id="pelanggan_nama" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Alamat" name="alamat" id="pelanggan_alamat" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kota</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input Kota" name="kota" id="pelanggan_kota" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">No. Telp</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Input No. Telp" name="telp" id="pelanggan_telp" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Disc (%)</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control digit" placeholder="0.00" name="disc" id="pelanggan_disc" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tgl. Expired</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control date-picker" placeholder="DD-MM-YYYY" name="tgl_expired" id="pelanggan_expired" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Default ?</label>
                        <div class="col-md-4">
                            <select class="form-control" name="lstStatus" id="pelanggan_status">
                                <option value="">- Pilih Status -</option>
                                <option value="Y">Ya</option>
                                <option value="T">Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Update</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>