<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Barang</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Menu Barang</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Barang</a>
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
                            <i class="fa fa-list"></i> Daftar Barang
                        </div>
                        <div class="actions">
                            <a data-toggle="modal" data-target="#filterData">
                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Filter Data</button>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Foto</th>
                                    <th width="10%">Kode</th>
                                    <th>Nama Barang</th>
                                    <th width="15%">Kategori</th>
                                    <th width="10%">Tipe</th>
                                    <th width="5%">PPN</th>
                                    <th width="5%">Stok</th>
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
            "url": "<?=site_url('admin/info/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.lstKategori = $('#lstKategori').val();
                data.lstTipe     = $('#lstTipe').val();
            }
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
                "targets": [ 6, 7, 8 ],
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
                        <label class="col-md-3 control-label">Kategori</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstKategori" id="lstKategori">
                                <option value="">- SEMUA DATA -</option>
                                <?php foreach ($listKategori as $r) { ?>
                                <option value="<?=$r->kategori_id;?>"><?=$r->kategori_nama;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tipe</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstTipe" id="lstTipe">
                                <option value="">- SEMUA DATA -</option>
                                <option value="S">STOCK</option>
                                <option value="N">NON STOCK</option>
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