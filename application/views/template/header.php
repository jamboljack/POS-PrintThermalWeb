<?php
$username = $this->session->userdata('username');
$dataUser = $this->menu_m->select_user($username)->row();

$uri = $this->uri->segment(2);
if ($uri == 'meta') {
    $setting = 'active';
    $meta    = 'active';
    $kontak  = '';
} else if ($uri == 'kontak') {
    $setting = 'active';
    $meta    = '';
    $kontak  = 'active';
} else {
    $setting = '';
    $meta    = '';
    $kontak  = '';
}
?>
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="<?=site_url('admin/home');?>">
                <img src="<?=base_url('img/logo-header.png');?>" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <?php if ($this->session->userdata('level') == 'Admin') {?>
        <div class="hor-menu hor-menu-light hidden-sm hidden-xs">
            <ul class="nav navbar-nav">
                <li class="classic-menu-dropdown <?=$setting;?>">
                    <a data-toggle="dropdown" href="javascript:;">
                        <i class="icon-settings"></i>
                        Setting <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class="<?=$meta;?>">
                            <a href="<?=site_url('admin/meta');?>">
                            <i class="fa fa-arrow-circle-o-right"></i> Setting App</a>
                        </li>
                        <li class="<?=$kontak;?>">
                            <a href="<?=site_url('admin/kontak');?>">
                            <i class="fa fa-arrow-circle-o-right"></i> Kontak Kami</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php }?>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <?php if ($dataUser->user_avatar != '') {?>
                        <img src="<?=base_url();?>img/icon/<?=$dataUser->user_avatar;?>" class="img-circle"/>
                        <?php } else {?>
                        <img src="<?=base_url();?>img/no-image.jpg" class="img-circle"/>
                        <?php }?>
                        <span class="username username-hide-on-mobile"><?=ucwords(strtolower($dataUser->user_name));?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?=site_url('profil');?>">
                            <i class="icon-user"></i> Profil </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?=site_url('login/logout');?>">
                                <i class="icon-key"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>