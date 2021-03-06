<link href="<?=base_url('backend/js/sweetalert2.css');?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('backend/js/sweetalert2.min.js');?>"></script>
<script src="<?=base_url('backend/js/jquery.maskMoney.min.js');?>"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Setting APP
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=site_url('admin/home');?>">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Setting APP</a>
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
                            <i class="fa fa-cogs"></i> Setting APP
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="formInput">
                        <input type="hidden" name="id" value="<?=$detail->meta_id;?>">

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nama APP</label>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="name" placeholder="Input Nama APP" value="<?=$detail->meta_name;?>" autocomplete="off"  autofocus />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Deskripsi</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="10" name="desc"><?=$detail->meta_desc;?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Keyword</label>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="keyword" placeholder="Input Keyword" value="<?=$detail->meta_keyword;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Author</label>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="author" placeholder="Input Author" value="<?=$detail->meta_author;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Developer</label>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="developer" placeholder="Input Developer" value="<?=$detail->meta_developer;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Robots</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="form-control" name="lstRobot" >
                                                <option value="">- Pilih -</option>
                                                <option value="index, follow" <?php if ($detail->meta_robots=='index, follow') { echo 'selected'; } ?>>index, follow</option>
                                                <option value="index, nofollow" <?php if ($detail->meta_robots=='index, nofollow') { echo 'selected'; } ?>>index, nofollow</option>
                                                <option value="noindex, follow" <?php if ($detail->meta_robots=='noindex, follow') { echo 'selected'; } ?>>noindex, follow</option>
                                                <option value="noindex, nofollow" <?php if ($detail->meta_robots=='noindex, nofollow') { echo 'selected'; } ?>>noindex, nofollow</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Googlebots</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="form-control" name="lstGoogle" >
                                                <option value="">- Pilih -</option>
                                                <option value="index, follow" <?php if ($detail->meta_googlebots=='index, follow') { echo 'selected'; } ?>>index, follow</option>
                                                <option value="index, nofollow" <?php if ($detail->meta_googlebots=='index, nofollow') { echo 'selected'; } ?>>index, nofollow</option>
                                                <option value="noindex, follow" <?php if ($detail->meta_googlebots=='noindex, follow') { echo 'selected'; } ?>>noindex, follow</option>
                                                <option value="noindex, nofollow" <?php if ($detail->meta_googlebots=='noindex, nofollow') { echo 'selected'; } ?>>noindex, nofollow</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">PPN (%)</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control digit" name="ppn" placeholder="0" value="<?=number_format($detail->meta_ppn,2,'.',',');?>" autocomplete="off"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Minimal Poin</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control number" name="poin" placeholder="0" value="<?=number_format($detail->meta_min_order,0,'',',');?>" autocomplete="off"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tukar Poin</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control number" name="tukar_poin" placeholder="0" value="<?=number_format($detail->meta_tukar_poin,0,'',',');?>" autocomplete="off"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Footer Nota</label>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="footer" placeholder="Input Footer Nota" value="<?=$detail->meta_footer;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">API Key Printer</label>
                                    <div class="col-md-2">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="key" placeholder="Input Key Printer" value="<?=$detail->meta_print_key;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Port Printer</label>
                                    <div class="col-md-2">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="port" placeholder="Input Port Printer" value="<?=$detail->meta_print_port;?>" autocomplete="off"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Set Printer</label>
                                    <div class="col-md-2">
                                        <select class="form-control" name="lstSetPrinter" >
                                            <option value="">- Pilih -</option>
                                            <option value="1" <?=($detail->meta_print_status==1?'selected':'');?>>Off</option>
                                            <option value="2" <?=($detail->meta_print_status==2?'selected':'');?>>On</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
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

<script type="text/javascript" src="<?=base_url('backend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.digit').maskMoney({thousands:',', precision:2});
    $('.number').maskMoney({thousands:',', precision:0});
});

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
            name: { required: true },
            desc: { required: true },
            keyword: { required: true },
            author: { required: true },
            developer: { required: true },
            lstRobot: { required: true },
            lstGoogle: { required: true },
            poin: { required: true },
            footer: { required: true },
            key: { required: true },
            port: { required: true }
        },
        messages: {
            name: { required :'Nama APP required' },
            desc: { required :'Description required' },
            keyword: { required :'Keyword required' },
            author: { required :'Author required' },
            developer: { required :'Developer required' },
            lstRobot: { required :'Robots required' },
            lstGoogle: { required :'Googlebots required' },
            poin: { required :'Minimal Poin required' },
            footer: { required :'Footer Nota required' },
            key: { required :'Key Printer required' },
            port: { required :'Port Printer required' }
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
            dataString = $('#formInput').serialize();
            $.ajax({
                url: "<?=site_url('admin/meta/updatedata');?>",
                type: "POST",
                data: dataString,
                dataType: 'JSON',
                success: function(data) {
                    swal({
                        title:"Sukses",
                        text: "Update Data Sukses",
                        showConfirmButton: false,
                        type: "success",
                        timer: 2000
                    });
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error Update Data');
                }
            });
        }
    });
});
</script>