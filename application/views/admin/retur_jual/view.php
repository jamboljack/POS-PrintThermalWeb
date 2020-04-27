<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Retur Penjualan</h3>
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
                    <a href="#">Retur Penjualan</a>
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
                            <i class="fa fa-list"></i> Daftar Retur Penjualan
                        </div>
                        <div class="actions">
                            <a data-toggle="modal" data-target="#filterData">
                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Filter Data</button>
                            </a>
                            <a href="<?=site_url('admin/retur_jual/adddata');?>">
                                <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover" id="tableData">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="5%">No</th>
                                <th width="13%">No. Transaksi</th>
                                <th width="10%">Tanggal</th>
                                <th>Pelanggan</th>
                                <th width="5%">Meja</th>
                                <th width="15%">Kasir</th>
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
            "url": "<?=site_url('admin/retur_jual/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.tgl_dari     = $('#tgl_dari').val();
                data.tgl_sampai   = $('#tgl_sampai').val();
                data.lstPelanggan = $('#lstPelanggan').val();
                data.lstMeja      = $('#lstMeja').val();
                data.lstTipe      = $('#lstTipe').val();
            }
        },
        "columnDefs": [
            {
                "targets": [ 0, 1 ],
                "orderable": false,
            },
            {
                "targets": [ 0, 1, 3, 5 ],
                "className": "text-center",
            },
            {
                "targets": [ 7 ],
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

function hapusData(retur_jual_id) {
    var id = retur_jual_id;
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
            url : "<?=site_url('admin/retur_jual/deletedata')?>/"+id,
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

function printNota(retur_jual_id) {
    // $.ajax({
    //     url: '<?=site_url('admin/retur_jual/get_data/');?>'+retur_jual_id,
    //     type: "POST",
    //     dataType: 'JSON',
    //     success: function(datap) {
    //         var locale        = 'en';
    //         var options       = {minimumFractionDigits: 0, maximumFractionDigits: 0};
    //         var formatter     = new Intl.NumberFormat(locale, options);
    //         var NoOrder       = datap.retur_jual_no;
    //         var Tanggal       = datap.retur_jual_tanggal;
    //         var NamaPelanggan = datap.pelanggan_nama;
    //         var Kasir         = datap.user_username;
    //         Header(NoOrder, Tanggal, NamaPelanggan, Kasir);
    //         // Detail Item
    //         $.ajax({
    //             url: '<?=site_url('admin/retur_jual/get_list_item/');?>'+retur_jual_id,
    //             type: "POST",
    //             dataType: 'JSON',
    //             success: function(dataitem) {
    //                 if (dataitem != null) {
    //                     var x = dataitem.length;
    //                     for(var i = 0; i < x; i++) {
    //                         var NamaBarang = dataitem[i].retur_jual_detail_nama;
    //                         var Harga      = formatter.format(dataitem[i].retur_jual_detail_harga);
    //                         var Qty        = formatter.format(dataitem[i].retur_jual_detail_qty);
    //                         var SubTotal   = formatter.format(dataitem[i].retur_jual_detail_subtotal);
    //                         ListItem(NamaBarang, Harga, Qty, SubTotal);
    //                     }

    //                     var SubTotal   = formatter.format(datap.retur_jual_subtotal);
    //                     var Diskon     = formatter.format(datap.retur_jual_diskon);
    //                     var DiskonPOIN = formatter.format(datap.retur_jual_tukar_poin_rp);
    //                     var Total      = formatter.format(datap.retur_jual_total);
    //                     Footer(SubTotal, Diskon, DiskonPOIN, Total);
    //                 }
    //             }
    //         });
    //     }
    // });

    var url = "<?=site_url('admin/retur_jual/printfaktur/');?>"+retur_jual_id;
    window.open(url, "_blank");
}

function Header(NoOrder, Tanggal, NamaPelanggan, Kasir) {
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

    var printer = new Recta('2785262214', '1811')
    printer.open().then(function () {
      printer.align('left')
        .bold(true)
        .text('Toko      : '+txtToko)
        .bold(false)
        .text('Alamat    : '+txtAlamat)
        .text('No  Telp  : '+txtTelp)
        .text('No  Order : '+txtNoOrder)
        .text('Tanggal   : '+Tanggal)
        .text('Pelanggan : '+txtNamaPelanggan)
        .text('Kasir     : '+Kasir)
        .text('================================')
        .text('Nama Barang   Harga Qty Subtotal')
        .text('================================')
        // .feed(5)
        // .cut()
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
    var txtSubTotal     = 0;

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

    var printer = new Recta('2785262214', '1811')
    printer.open().then(function () {
      printer.align('left')
        .text(txtBarang+" "+txtHarga+" "+txtQty+""+txtSubtotal)
        .print()
    })
}

function Footer(SubTotal, Diskon, DiskonPOIN, Total) {
    var limitNominal    = 9;
    var txtSubTotal     = 0;
    var txtDiskon       = 0;
    var txtDiskonPOIN   = 0;
    var txtTotal        = 0;

    if (SubTotal.length <= limitNominal) {
        txtSubTotal = SubTotal.padStart(limitNominal, ' ')
    } else {
        txtSubTotal = SubTotal.substring(0, limitNominal);
    }

    if (Diskon.length <= limitNominal) {
        txtDiskon = Diskon.padStart(limitNominal, ' ')
    } else {
        txtDiskon = Diskon.substring(0, limitNominal);
    }

    if (DiskonPOIN.length <= limitNominal) {
        txtDiskonPOIN = DiskonPOIN.padStart(limitNominal, ' ')
    } else {
        txtDiskonPOIN = DiskonPOIN.substring(0, limitNominal);
    }

    if (Total.length <= limitNominal) {
        txtTotal = Total.padStart(limitNominal, ' ')
    } else {
        txtTotal = Total.substring(0, limitNominal);
    }

    var printer = new Recta('2785262214', '1811')
    printer.open().then(function () {
      printer.align('left')
        .text("           Sub Total : "+txtSubtotal)
        .text("              Diskon : "+txtDiskon)
        .text("         Diskon POIN : "+txtDiskonPOIN)
        .text("               TOTAL : "+txtTotal)
        .text("--------------------------------")
        .text("Terima Kasih atas kunjungan Anda")
        .feed(5)
        .cut()
        .print()
    })
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
                                <input type="text" class="form-control date-picker" name="tgl_dari" id="tgl_dari" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                                <span class="input-group-addon"><b>s/d</b></span>
                                <input type="text" class="form-control date-picker" name="tgl_sampai" id="tgl_sampai" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?=date('d-m-Y');?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Pelanggan</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstPelanggan" id="lstPelanggan">
                                <option value="">- SEMUA -</option>
                                <?php foreach($listPelanggan as $r) { ?>
                                <option value="<?=$r->pelanggan_id;?>"><?=$r->pelanggan_nama;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">No. Meja</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstMeja" id="lstMeja">
                                <option value="">- SEMUA -</option>
                                <?php foreach($listMeja as $r) { ?>
                                <option value="<?=$r->meja_id;?>"><?=$r->meja_nama;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tipe Bayar</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstTipe" id="lstTipe">
                                <option value="">- SEMUA -</option>
                                <?php foreach($listTipe as $r) { ?>
                                <option value="<?=$r->tipe_id;?>"><?=$r->tipe_nama;?></option>
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