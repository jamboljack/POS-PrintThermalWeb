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
                    <a href="#">Detail Retur Penjualan Barang</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">No. Transaksi : <?=$detail->retur_jual_no;?></a>
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
                                    <div class="form-body">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Tanggal/Hari</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?=date('d-m-Y', strtotime($detail->retur_jual_tanggal));?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="hari" id="hari" value="<?=getDay(date('d-m-Y', strtotime($detail->retur_jual_tanggal)));?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Nama Pelanggan</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nama_pelanggan" value="<?=$detail->pelanggan_nama;?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Alamat</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="alamat" value="<?=$detail->pelanggan_alamat;?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">No. Meja</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="meja" value="<?=$detail->meja_nama;?>" readonly>
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
                                    <i class="fa fa-plus-circle"></i> Total Transaksi : <?=$detail->user_name;?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form role="form" class="form-horizontal form" method="post" id="formTotal" name="formTotal">
                                    <div class="form-body">
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-12 value">Rp. <?=number_format($detail->retur_jual_total,0,'',',');?></div>
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
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th>Nama Barang</th>
                                    <th width="5%">Jumlah</th>
                                    <th width="10%">Harga</th>
                                    <th width="5%">Disc (%)</th>
                                    <th width="10%">Sub Total</th>
                                    <th width="20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <a class="btn btn-sm blue hidden-print" href="<?=site_url('admin/retur_jual/printfaktur/'.$detail->retur_jual_id);?>" target="_blank"><i class="fa fa-print"></i> Print Faktur</a>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <div class="row static-info align-reverse">
                        <div class="col-md-7 name"><b>TOTAL :</b></div>
                        <div class="col-md-4 name"><?=number_format($detail->retur_jual_total,0,'',',');?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript">
var table;
$(document).ready(function() {
    var retur_jual_id = '<?=$detail->retur_jual_id;?>';
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
            "url": "<?=site_url('admin/retur_jual/data_order_list/')?>"+retur_jual_id,
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1, 2, 3, 4, 5, 6, 7 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 3 ],
                "className": "text-center",
            },
            {
                "targets": [ 4, 5, 6 ],
                "className": "text-right",
            }
        ],
    });    
});
</script>