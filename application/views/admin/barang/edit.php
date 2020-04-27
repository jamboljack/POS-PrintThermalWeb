<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('backend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

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
                    <a href="#">Data Master</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                 <li>
                    <a href="<?=site_url('admin/barang');?>">Barang</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Edit Barang : <?=$detail->barang_kode;?></a>
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
                            <i class="fa fa-edit"></i> Form Edit Barang
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="formInput" name="formInput" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?=$detail->barang_id;?>">
                        <input type="hidden" name="ppn_rp" id="ppn_rp" value="<?=$detail->barang_ppn_rp;?>">
                        
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Nama Barang</label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control" placeholder="Enter Nama Barang" name="nama" id="nama" autocomplete="off" value="<?=$detail->barang_nama;?>" autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Kategori</label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" name="lstKategori">
                                                        <option value="">- Pilih Kategori -</option>
                                                        <?php foreach ($listKategori as $r) { ?>
                                                        <option value="<?=$r->kategori_id;?>" <?=($detail->kategori_id==$r->kategori_id?'selected':'');?>><?=$r->kategori_nama;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tipe</label>
                                                <div class="col-md-9">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <select class="form-control" name="lstTipe">
                                                            <option value="">- Pilih Tipe Barang -</option>
                                                            <option value="S" <?=($detail->barang_tipe=='S'?'selected':'');?>>STOCK</option>
                                                            <option value="N" <?=($detail->barang_tipe=='N'?'selected':'');?>>NON STOCK</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Harga</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control number" placeholder="0" name="harga" id="harga" value="<?=number_format($detail->barang_harga,0,'',',');?>" autocomplete="off" onkeydown="hitungTotal()" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">PPN (%)</label>
                                            <div class="col-md-3">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control digit" placeholder="0" name="ppn" id="ppn" value="<?=number_format($detail->barang_ppn,2,'.',',');?>" autocomplete="off" onkeydown="hitungTotal()" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label">Total (Rp)</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control number" placeholder="0" name="total" id="total" autocomplete="off" value="<?=number_format($detail->barang_total,0,'',',');?>"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Upload Foto</label>
                                            <div class="col-md-9">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="<?=base_url('img/no-image.png');?>" alt=""/>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 300;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new">
                                                        Pilih Foto </span>
                                                        <span class="fileinput-exists">
                                                        Ubah </span>
                                                        <input type="file" name="foto" accept=".png,.jpg,.jpeg">
                                                        </span>
                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                        Hapus </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix margin-top-10">
                                                    <span class="label label-danger">INFO !</span>Resolution : 300 x 300 Pixel
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Foto Barang</label>
                                            <div class="col-md-9">
                                                <?php if (!empty($detail->barang_foto)) { ?>
                                                <img src="<?=base_url('img/barang_folder/thumbs/'.$detail->barang_foto);?>" width="50%">
                                                <?php } else { ?>
                                                <img src="<?=base_url('img/no-image.jpg');?>" width="50%">
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" align="center">
                                <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
                                <a href="<?=site_url('admin/barang');?>" class="btn btn-warning"><i class="fa fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="<?=base_url();?>backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.number').maskMoney({thousands:',', precision:0});
    $('.digit').maskMoney({thousands:',', precision:2});
});

function hitungTotal() {
    var locale              = 'en';
    var options             = {minimumFractionDigits: 0, maximumFractionDigits: 0};
    var formatter           = new Intl.NumberFormat(locale, options);
    var myForm              = document.formInput;
    var Harga               = myForm.harga.value;
    Harga                   = Harga.replace(/[,]/g, '');
    Harga                   = parseInt(Harga);
    var PPN                 = myForm.ppn.value;
    PPN                     = PPN.replace(/[,]/g, '');
    PPN                     = parseFloat(PPN);

    var PPN_Rp;

    if (PPN === 0 || isNaN(PPN)) {
        var Total           = Harga;
        PPN_Rp              = 0;
    } else {
        PPN_Rp              = ((PPN*Harga)/100);
        var Total           = (Harga+PPN_Rp);
    }

    myForm.ppn_rp.value = PPN_Rp;
    
    if (isNaN(Total)) {
        myForm.total.value     = 0;    
    } else {
        myForm.total.value     = formatter.format(Total);
    }
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
            nama: { required: true },
            lstKategori: { required: true },
            harga: { required: true }
        },
        messages: {
            nama: { required:'Nama Barang harus diisi' },
            lstKategori: { required:'Kategori harus dipilih' },
            harga: { required:'Harga harus diisi' }
        },
        invalidHandler: function (event, validator) {
            success.hide();
            error.show();
            Metronic.scrollTo(error, -200);
        },
        errorPlacement: function (error, element) {
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");  
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },
        highlight: function (element) {
            $(element)
            .closest('.form-group').removeClass("has-success").addClass('has-error');
        },
        unhighlight: function (element) {
        },
        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            icon.removeClass("fa-warning").addClass("fa-check");
        },
        submitHandler: function(form) {
            var formData = new FormData($('#formInput')[0]);
            $.ajax({
                dataType: 'json',
                data: formData,
                async: true,
                url: "<?=site_url('admin/barang/updatedata');?>",
                type: "POST",
                success: function(data) {
                    if (data.status === 'success') {
                        setTimeout(function() {
                            swal({
                                title:"Sukses",
                                text: "Update Data Berhasil",
                                timer: 2000,
                                showConfirmButton: false,
                                type: "success"
                            }, function() {
                                window.location="<?=site_url('admin/barang');?>";
                            })
                        });
                    } else {
                        setTimeout(function() {
                            swal({
                                title:"Gagal",
                                text: "File Tidak sesuai Format (JPG/PNG/JPEG)",
                                timer: 2000,
                                showConfirmButton: false,
                                type: "error"
                            })
                        });
                    }
                },
                error: function() {
                    setTimeout(function() {
                        swal({
                            title:"Error",
                            text: "Update Data Error",
                            timer: 2000,
                            showConfirmButton: false,
                            type: "error"
                        })
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});
</script>