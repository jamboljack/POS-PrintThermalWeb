<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

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
                    <a href="#">Stok Keluar</a>
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
                            <i class="fa fa-list"></i> Daftar Stok Keluar
                        </div>
                        <div class="actions">
                            <a data-toggle="modal" data-target="#filterData">
                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Filter Data</button>
                            </a>
                            <a href="<?=site_url('admin/keluar/adddata');?>">
                                <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="7%"></th>
                                    <th width="5%">No</th>
                                    <th width="15%">No. Transaksi</th>
                                    <th width="10%">Tanggal</th>
                                    <th>Keterangan</th>
                                    <th width="30%">Petugas</th>
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
<script type="text/javascript">
function reload_table() {
    table.ajax.reload(null,false);
}

var table;
$(document).ready(function() {
    table = $('#tableData').DataTable({
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/keluar/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.tgl_dari      = $('#tgl_dari').val();
                data.tgl_sampai    = $('#tgl_sampai').val();
            }
        },
        "columnDefs": [
            {
                "targets": [ 0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 3 ],
                "className": "text-center",
            }
        ],
    });

    $('#btn-filter').click(function() {
        reload_table();
        $('#filterData').modal('hide');
    });

    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        reload_table();
        $('#filterData').modal('hide');
    });
});

function hapusData(keluar_id) {
    var id = keluar_id;
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
            url : "<?=site_url('admin/keluar/deletedata')?>/"+id,
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

function printBukti(keluar_id) {
    var url = "<?=site_url('admin/keluar/printbukti/');?>"+keluar_id;
    window.open(url, "_blank");
}
</script>

<div class="modal" id="filterData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="form-filter" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-search"></i> Filter Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Periode</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control date-picker" name="tgl_dari" id="tgl_dari" placeholder="Tgl. Dari" data-date-format="dd-mm-yyyy" autocomplete="off">
                                <span class="input-group-addon"><b>s/d</b></span>
                                <input type="text" class="form-control date-picker" name="tgl_sampai" id="tgl_sampai" placeholder="Tgl. Sampai" data-date-format="dd-mm-yyyy" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btn-filter"><i class="fa fa-search"></i> Filter</button>
                    <button type="button" class="btn btn-default" id="btn-reset"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>