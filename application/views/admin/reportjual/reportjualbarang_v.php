<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Laporan Penjualan per Barang</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Menu Report</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Laporan Penjualan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Penjualan per Barang</a>
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
                            <i class="fa fa-search"></i> Filter Data
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" id="form-filter" class="form-horizontal form">
                        <input type="hidden" name="barang_id" id="barang_id">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Periode</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control date-picker" name="tgl_dari" id="tgl_dari" placeholder="Dari Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                                                    <span class="input-group-addon"><b>s/d</b></span>
                                                    <input type="text" class="form-control date-picker" name="tgl_sampai" id="tgl_sampai" placeholder="Sampai Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Nama Barang</label>
                                            <div class="col-md-9">
                                                <div class="input-group" style="text-align:left">
                                                    <div class="input-icon right">
                                                    <i class="fa"></i>
                                                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" autocomplete="off" placeholder="Cari Nama Barang">
                                                    </div>
                                                    <span class="input-group-btn">
                                                        <a id="btn-barang" class="btn green" title="Cari Data Barang"><i class="fa fa-search"></i></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="form-actions" align="center">
                                <button type="button" class="btn btn-warning" id="btn-filter"><i class="fa fa-search"></i> Filter</button>
                                <button type="button" class="btn btn-default" id="btn-reset"><i class="fa fa-refresh"></i> Reset</button>
                                <a onclick="printBarang()" class="btn btn-danger"><i class="icon-printer"></i> Print</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue-madison">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Penjualan Barang
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%">Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th width="5%">Jumlah</th>
                                    <th width="10%">Harga</th>
                                    <th width="5%">Disc (%)</th>
                                    <th width="10%">Total</th>
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
$("#btn-barang").click(function() {
    $('#formDataBarang').modal('show');
});

function reload_table() {
    table.ajax.reload(null,false);
}

var table;
$(document).ready(function() {
    table = $('#tableData').DataTable({
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "lengthMenu": [
                [20, 50, 75, 100, -1],
                [20, 50, 75, 100, "All"]
        ],
        "pageLength": 20,
        "ajax": {
            "url": "<?=site_url('admin/lap_jual_barang/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.barang_id   = $('#barang_id').val();
                data.tgl_dari    = $('#tgl_dari').val();
                data.tgl_sampai  = $('#tgl_sampai').val();
            }
        },
        "columnDefs": [
            {
                "targets": [ 0 ],
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

    $('#btn-filter').click(function() {
        reload_table();
        $('#filterData').modal('hide');
    });

    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        $('#barang_id').val('');
        reload_table();
        $('#filterData').modal('hide');
    });
});

var tableBarang;
$(document).ready(function() {
    tableBarang = $('#tableDataBarang').DataTable({
        "responsive": true,
        "processing": false,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?=site_url('admin/lap_jual_barang/data_barang_list')?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1 ],
                "className": "text-center",
            },
            {
                "targets": [ 5, 6 ],
                "className": "text-right",
            }
        ],
    });
});

function pilihdata(id) {
    $.ajax({
        url : "<?=site_url('admin/lap_jual_barang/get_data_barang/'); ?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#barang_id').val(data.barang_id);
            $('#nama_barang').val(data.barang_nama);
            $('#formDataBarang').modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function printBarang() {
    var tgl_dari   = $('#tgl_dari').val();
    if (tgl_dari === '') {
        var dari = 'all';
    } else {
        var dari = tgl_dari;
    }
    var tgl_sampai = $('#tgl_sampai').val();
    if (tgl_sampai === '') {
        var sampai = 'all';
    } else {
        var sampai = tgl_sampai;
    }
    var Barang = $('#barang_id').val();
    if (Barang === '') {
        var barang = 'all';
    } else {
        var barang = Barang;
    }

    var url = "<?=site_url('admin/lap_jual_barang/printbarang/');?>"+dari+"/"+sampai+"/"+barang;
    window.open(url, "_blank");
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
