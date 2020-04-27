<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Laporan Penjualan per Pelanggan</h3>
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
                    <a href="#">Penjualan per Pelanggan</a>
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
                            <i class="fa fa-list"></i> Daftar Penjualan Barang
                        </div>
                        <div class="actions">
                            <a data-toggle="modal" data-target="#filterData" class="btn btn-warning btn-xs">
                                <i class="fa fa-search"></i> Filter Data
                            </a>
                            <a onclick="printPelanggan()" class="btn btn-danger btn-xs">
                                <i class="icon-printer"></i> Print
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Nama Pelanggan</th>
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

<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script type="text/javascript">
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
            "url": "<?=site_url('admin/lap_jual_pelanggan/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.lstPelanggan = $('#lstPelanggan').val();
                data.tgl_dari     = $('#tgl_dari').val();
                data.tgl_sampai   = $('#tgl_sampai').val();
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
                "targets": [ 5, 6, 7, 8 ],
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
        reload_table();
        $('#filterData').modal('hide');
    });
});

function printPelanggan() {
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
    var lstpelanggan = $('#lstPelanggan').val();
    if (lstpelanggan === '') {
        var pelanggan = 'all';
    } else {
        var pelanggan = lstpelanggan;
    }

    var url = "<?=site_url('admin/lap_jual_pelanggan/printpelanggan/');?>"+dari+"/"+sampai+"/"+pelanggan;
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
                            <input type="text" class="form-control date-picker" name="tgl_dari" id="tgl_dari" placeholder="Dari Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                            <span class="input-group-addon"><b>s/d</b></span>
                            <input type="text" class="form-control date-picker" name="tgl_sampai" id="tgl_sampai" placeholder="Sampai Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Pelanggan</label>
                    <div class="col-md-9">
                        <select class="form-control" name="lstPelanggan" id="lstPelanggan">
                            <option value="">- SEMUA DATA -</option>
                            <?php foreach ($listPelanggan as $r) { ?>
                            <option value="<?=$r->pelanggan_id;?>"><?=$r->pelanggan_nama;?></option>
                            <?php } ?>
                        </select>
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
