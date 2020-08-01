<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Penjualan</h3>
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
                    <a href="#">Penjualan</a>
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
                            <i class="fa fa-list"></i> Daftar Penjualan
                        </div>
                        <div class="actions">
                            <a data-toggle="modal" data-target="#filterData">
                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Filter Data</button>
                            </a>
                            <a href="<?=site_url('admin/penjualan/adddata');?>">
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
                                <th width="10%">Kasir</th>
                                <th width="10%">Subtotal</th>
                                <th width="10%">Diskon</th>
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
            "url": "<?=site_url('admin/penjualan/data_list')?>",
            "type": "POST",
            "data": function(data) {
                data.tgl_dari     = $('#tgl_dari').val();
                data.tgl_sampai   = $('#tgl_sampai').val();
                data.lstPelanggan = $('#lstPelanggan').val();
                data.lstMeja      = $('#lstMeja').val();
                data.lstTipe      = $('#lstTipe').val();
                data.lstStatus    = $('#lstStatus').val();
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
                "targets": [ 7, 8, 9 ],
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

function hapusData(penjualan_id) {
    var id = penjualan_id;
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
            url : "<?=site_url('admin/penjualan/deletedata')?>/"+id,
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

function printFaktur(penjualan_id) {
    var url = "<?=site_url('admin/penjualan/printfaktur/');?>"+penjualan_id;
    window.open(url, "_blank");
}

var printer = new Recta('<?=$dataMeta->meta_print_key;?>', '<?=$dataMeta->meta_print_port;?>');
function printNota(penjualan_id) {
    $.ajax({
        url: '<?=site_url('admin/penjualan/get_data/');?>'+penjualan_id,
        type: "POST",
        dataType: 'JSON',
        success: function(datap1) {
            var locale        = 'en';
            var options       = {minimumFractionDigits: 0, maximumFractionDigits: 0};
            var formatter     = new Intl.NumberFormat(locale, options);
            var NoOrder       = datap1.penjualan_no;
            var Tanggal       = datap1.penjualan_tanggal;
            var Jam           = datap1.penjualan_jam;
            var NamaPelanggan = datap1.penjualan_nama;
            var Kasir         = datap1.user_username;
            var Meja          = datap1.meja_nama;
            Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja);
            $.ajax({
                url: '<?=site_url('admin/penjualan/get_list_item/');?>'+penjualan_id,
                type: "POST",
                dataType: 'JSON',
                success: function(dataitem1) {
                    if (dataitem1 != null) {
                        var x1 = dataitem1.length;
                        for(var i = 0; i < x1; i++) {
                            var NamaBarang = dataitem1[i].penjualan_detail_nama;
                            var Harga      = formatter.format(dataitem1[i].penjualan_detail_harga);
                            var Qty        = formatter.format(dataitem1[i].penjualan_detail_qty);
                            var Subtotal   = formatter.format(dataitem1[i].penjualan_detail_subtotal);
                            ListItem(NamaBarang, Harga, Qty, Subtotal);
                        }

                        var TipeBayar  = datap1.tipe_nama;
                        var SubTotal   = formatter.format(datap1.penjualan_subtotal);
                        var Diskon     = formatter.format(datap1.penjualan_diskon);
                        var DiskonPOIN = formatter.format(datap1.penjualan_tukar_poin_rp);
                        var PPN        = formatter.format(datap1.penjualan_ppn);
                        var Total      = formatter.format(datap1.penjualan_total);
                        Footer(TipeBayar, SubTotal, Diskon, DiskonPOIN, PPN, Total);
                        FooterEnd();


                        // Cetak ke 2
                        $.ajax({
                            url: '<?=site_url('admin/penjualan/get_data/');?>'+penjualan_id,
                            type: "POST",
                            dataType: 'JSON',
                            success: function(datap2) {
                                var locale        = 'en';
                                var options       = {minimumFractionDigits: 0, maximumFractionDigits: 0};
                                var formatter     = new Intl.NumberFormat(locale, options);
                                var NoOrder       = datap2.penjualan_no;
                                var Tanggal       = datap2.penjualan_tanggal;
                                var Jam           = datap2.penjualan_jam;
                                var NamaPelanggan = datap2.penjualan_nama;
                                var Kasir         = datap2.user_username;
                                var Meja          = datap2.meja_nama;
                                Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja);
                                $.ajax({
                                    url: '<?=site_url('admin/penjualan/get_list_item/');?>'+penjualan_id,
                                    type: "POST",
                                    dataType: 'JSON',
                                    success: function(dataitem2) {
                                        if (dataitem2 != null) {
                                            var x2 = dataitem2.length;
                                            for(var i = 0; i < x2; i++) {
                                                var NamaBarang = dataitem2[i].penjualan_detail_nama;
                                                var Harga      = formatter.format(dataitem2[i].penjualan_detail_harga);
                                                var Qty        = formatter.format(dataitem2[i].penjualan_detail_qty);
                                                var Subtotal   = formatter.format(dataitem2[i].penjualan_detail_subtotal);
                                                ListItem(NamaBarang, Harga, Qty, Subtotal);
                                            }

                                            var TipeBayar  = datap2.tipe_nama;
                                            var SubTotal   = formatter.format(datap2.penjualan_subtotal);
                                            var Diskon     = formatter.format(datap2.penjualan_diskon);
                                            var DiskonPOIN = formatter.format(datap2.penjualan_tukar_poin_rp);
                                            var PPN        = formatter.format(datap2.penjualan_ppn);
                                            var Total      = formatter.format(datap2.penjualan_total);
                                            Footer(TipeBayar, SubTotal, Diskon, DiskonPOIN, PPN, Total);
                                            FooterEnd();

                                            // Cetak ke 3
                                            $.ajax({
                                                url: '<?=site_url('admin/penjualan/get_data/');?>'+penjualan_id,
                                                type: "POST",
                                                dataType: 'JSON',
                                                success: function(datap3) {
                                                    var locale        = 'en';
                                                    var options       = {minimumFractionDigits: 0, maximumFractionDigits: 0};
                                                    var formatter     = new Intl.NumberFormat(locale, options);
                                                    var NoOrder       = datap3.penjualan_no;
                                                    var Tanggal       = datap3.penjualan_tanggal;
                                                    var Jam           = datap3.penjualan_jam;
                                                    var NamaPelanggan = datap3.penjualan_nama;
                                                    var Kasir         = datap3.user_username;
                                                    var Meja          = datap3.meja_nama;
                                                    Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja);
                                                    $.ajax({
                                                        url: '<?=site_url('admin/penjualan/get_list_item/');?>'+penjualan_id,
                                                        type: "POST",
                                                        dataType: 'JSON',
                                                        success: function(dataitem3) {
                                                            if (dataitem3 != null) {
                                                                var x3 = dataitem3.length;
                                                                for(var i = 0; i < x3; i++) {
                                                                    var NamaBarang = dataitem3[i].penjualan_detail_nama;
                                                                    var Qty        = formatter.format(dataitem3[i].penjualan_detail_qty);
                                                                    var Keterangan = dataitem3[i].penjualan_detail_keterangan;
                                                                    ListItemChecker(NamaBarang, Qty, Keterangan);
                                                                }
                                                                FooterChecker();
                                                            }
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }
    });
}

function Header(NoOrder, Tanggal, Jam, NamaPelanggan, Kasir, Meja) {
    var LimitChar = 20;
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

    printer.open().then(function () {
      printer.align('left')
        .bold(true)
        .text('     BLACKSTONE STREETLOUNGE    ')
        .text('             RUKO UMK           ')
        .bold(false)
        .text('--------------------------------')
        .print()
    })

    printer.open().then(function () {
      printer.align('left')
        .text('No. Order : '+txtNoOrder)
        .text('Tanggal   : '+Tanggal+" "+Jam)
        .text('Pelanggan : '+txtNamaPelanggan)
        .text('Kasir     : '+Kasir)
        .text('Meja      : '+Meja)
        .text('--------------------------------')
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
    var txtSubtotal     = 0;

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

    printer.open().then(function () {
      printer.align('left')
        .text(txtBarang+" "+txtHarga+" "+txtQty+""+txtSubtotal)
        .print()
    })
}

function Footer(TipeBayar, SubTotal, Diskon, DiskonPOIN, PPN, Total) {
    var limitNominal    = 9;
    var txtSubTotal     = 0;
    var txtDiskon       = 0;
    var txtDiskonPOIN   = 0;
    var txtPPN          = 0;
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

    if (PPN.length <= limitNominal) {
        txtPPN = PPN.padStart(limitNominal, ' ')
    } else {
        txtPPN = PPN.substring(0, limitNominal);
    }

    if (Total.length <= limitNominal) {
        txtTotal = Total.padStart(limitNominal, ' ')
    } else {
        txtTotal = Total.substring(0, limitNominal);
    }

    printer.open().then(function () {
        printer.align('left')
        .text(TipeBayar)
        .text("           Sub Total : "+txtSubTotal)
        .print()
    })

    if (txtDiskon != 0) {
        printer.open().then(function () {
            printer.align('left')
            .text("              Diskon : "+txtDiskon)
            .print()
        })
    }

    if (txtDiskonPOIN != 0) {
        printer.open().then(function () {
            printer.align('left')
            .text("         Diskon POIN : "+txtDiskonPOIN)
            .print()
        })
    }

    if (txtPPN != 0) {
        printer.open().then(function () {
        printer.align('left')
            .text("             PPN (%) : "+txtPPN)
            .print()
        })
    }

    printer.open().then(function () {
        printer.align('left')
        .text("               TOTAL : "+txtTotal)
        .text("--------------------------------")
        .print()
    })
}

function FooterEnd() {
    printer.open().then(function () {
        printer.align('left')
        .text('<?=$dataMeta->meta_footer;?>')
        .feed(3)
        .cut()
        .print()
    })
}

function ListItemChecker(NamaBarang, Qty, Keterangan) {
    var limitNamaBarang = 11;
    var limitQty        = 3;
    var limitKeterangan = 16;
    var txtBarang       = '';
    var txtQty          = 0;
    var txtKeterangan   = '';

    if(NamaBarang.length <= limitNamaBarang) {
        txtBarang = NamaBarang.padEnd(limitNamaBarang, ' ')
    } else {
        txtBarang = NamaBarang.substring(0, limitNamaBarang);
    }

    if (Qty.length <= limitQty) {
        txtQty = Qty.padStart(limitQty, ' ')
    } else {
        txtQty = Qty.substring(0, limitQty);
    }

    if(Keterangan.length <= limitKeterangan) {
        txtKeterangan = Keterangan.padEnd(limitKeterangan, ' ')
    } else {
        txtKeterangan = Keterangan.substring(0, limitKeterangan);
    }

    printer.open().then(function () {
      printer.align('left')
        .text(txtBarang+" "+txtQty+" "+txtKeterangan)
        .print()
    })
}

function FooterChecker() {
    printer.open().then(function () {
        printer.align('left')
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
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status Bayar</label>
                        <div class="col-md-9">
                            <select class="form-control" name="lstStatus" id="lstStatus">
                                <option value="">- SEMUA -</option>
                                <option value="1">Belum Bayar</option>
                                <option value="2">Sudah Bayar</option>
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