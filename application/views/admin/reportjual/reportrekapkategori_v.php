<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Laporan Rekap per Kategori</h3>
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
                    <a href="#">Rekap per Kategori</a>
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
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Periode</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" class="form-control date-picker" name="tgl_dari" id="tgl_dari" placeholder="Dari Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                                            <span class="input-group-addon"><b>s/d</b></span>
                                            <input type="text" class="form-control date-picker" name="tgl_sampai" id="tgl_sampai" placeholder="Sampai Tanggal" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a onclick="printData()" class="btn btn-danger"><i class="icon-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript">
function printData() {
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
    
    var url = "<?=site_url('admin/lap_jual_kategori/printdata/');?>"+dari+"/"+sampai;
    window.open(url, "_blank");
}
</script>