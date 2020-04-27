<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Stok Masuk</h3>
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
                    <a href="<?=site_url('admin/masuk');?>">Stok Masuk</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Detail Stok Masuk</a>
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
                                    <i class="fa fa-edit"></i> Form Data Stok Masuk
                                </div>
                            </div>

                            <div class="portlet-body form">
                                <form role="form" class="form-horizontal form" method="post" id="formInput" name="formInput">
                                <input type="hidden" name="masuk_id" value="<?=$detail->masuk_id;?>">

                                    <div class="form-body">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Tanggal</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control date-picker" name="tanggal" value="<?=date('d-m-Y', strtotime($detail->masuk_tanggal));?>" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Keterangan</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?=$detail->masuk_keterangan;?>" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Petugas</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="petugas" id="petugas" value="<?=$detail->user_name;?>" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions" align="center">
                                        <?php if ($detail->masuk_status=='B') { ?>
                                        <a href="javascript:;" class="btn btn-success" onclick="KonfirmasiData(<?=$detail->masuk_id;?>)"><i class="fa fa-floppy-o"></i> Kofirmasi</a>
                                        <?php } ?>
                                        <a href="<?=site_url('admin/masuk');?>" type="button" class="btn btn-warning"><i class="fa fa-times"></i> Batal</a>
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
                                    <input type="hidden" name="totalmasuk" id="totalmasuk">
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
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                            <thead>
                                <tr>
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

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    hitungTotal();
});

function reload_table() {
    table.ajax.reload(null,false);
}

var table;
$(document).ready(function() {
    var masuk_id = '<?=$detail->masuk_id;?>';
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
            "url": "<?=site_url('admin/masuk/data_masuk_list/')?>"+masuk_id,
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 0, 1, 2, 3, 4 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 4 ],
                "className": "text-center",
            }
        ],
    });    
});
function hitungTotal() {
    var masuk_id = '<?=$detail->masuk_id;?>';
    $.ajax({
        url : "<?=site_url('admin/masuk/get_data_total_detail/');?>"+masuk_id,
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

            $('#totalmasuk').val(TotalQty);
            $('#totalqty').text(Qty);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get Total');
        }
    });
}

function KonfirmasiData(masuk_id) {
    var id = masuk_id;
    swal({
        title: 'Anda Yakin ?',
        text: 'Data ini akan di Konfirmasi !',
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
            url : "<?=site_url('admin/masuk/konfirmasi')?>/"+id,
            type: "POST",
            success: function(data) {
                swal({
                    title:"Sukses",
                    text: "Konfirmasi Data Sukses",
                    showConfirmButton: false,
                    type: "success",
                    timer: 2000
                }, function() {
                    window.location="<?=site_url('admin/masuk');?>";
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Konfirmasi Data Gagal');
            }
        });
    });
}
</script>