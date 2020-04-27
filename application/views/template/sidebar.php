<?php
$uri = $this->uri->segment(2);

if ($uri == 'home') {
    $dashboard          = 'active';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'meja') {
    $dashboard          = '';
    $master             = 'active open';
    $span_master_1      = '<span class="selected"></span>';
    $span_master_2      = 'open';
    $meja               = 'active';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'pelanggan') {
    $dashboard          = '';
    $master             = 'active open';
    $span_master_1      = '<span class="selected"></span>';
    $span_master_2      = 'open';
    $meja               = '';
    $pelanggan          = 'active';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'kategori') {
    $dashboard          = '';
    $master             = 'active open';
    $span_master_1      = '<span class="selected"></span>';
    $span_master_2      = 'open';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = 'active';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'tipe') {
    $dashboard          = '';
    $master             = 'active open';
    $span_master_1      = '<span class="selected"></span>';
    $span_master_2      = 'open';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = 'active';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'barang') {
    $dashboard          = '';
    $master             = 'active open';
    $span_master_1      = '<span class="selected"></span>';
    $span_master_2      = 'open';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = 'active';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'info') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = 'active';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'penjualan') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = 'active';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'retur_jual') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = 'active';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'masuk') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = 'active';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'keluar') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = 'active';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'printer') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = 'active';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'users') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = 'active';
} elseif ($uri == 'lap_stok_masuk') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = 'active open';
    $span_rpt_stok_1    = '<span class="selected"></span>';
    $span_rpt_stok_2    = 'open';
    $lap_stok_masuk     = 'active';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_stok_keluar') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = 'active open';
    $span_rpt_stok_1    = '<span class="selected"></span>';
    $span_rpt_stok_2    = 'open';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = 'active';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_jual_periode') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = 'active';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_jual_pelanggan') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = 'active';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_jual_barang') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = 'active';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_jual_rekap') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = 'active';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_jual_kategori') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = 'active';
    $lap_kasir          = '';
    $users              = '';
} elseif ($uri == 'lap_kasir') {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = 'active open';
    $span_rpt_jual_1    = '<span class="selected"></span>';
    $span_rpt_jual_2    = 'open';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = 'active';
    $users              = '';
} else {
    $dashboard          = '';
    $master             = '';
    $span_master_1      = '';
    $span_master_2      = '';
    $meja               = '';
    $pelanggan          = '';
    $kategori           = '';
    $tipe               = '';
    $barang             = '';
    $info               = '';
    $penjualan          = '';
    $retur_jual         = '';
    $masuk              = '';
    $keluar             = '';
    $printer            = '';
    $rpt_stok           = '';
    $span_rpt_stok_1    = '';
    $span_rpt_stok_2    = '';
    $lap_stok_masuk     = '';
    $lap_stok_keluar    = '';
    $rpt_jual           = '';
    $span_rpt_jual_1    = '';
    $span_rpt_jual_2    = '';
    $lap_jual_periode   = '';
    $lap_jual_pelanggan = '';
    $lap_jual_barang    = '';
    $lap_jual_rekap     = '';
    $lap_jual_kategori  = '';
    $lap_kasir          = '';
    $users              = '';
}
?>
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <br>
            <li class="tooltips <?=$dashboard;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Dashboard">
                <a href="<?=site_url('admin/home');?>">
                    <i class="fa fa-home"></i><span class="title"> Dashboard</span>
                </a>
            </li>
            <?php if ($this->session->userdata('level') == 'Admin') {?>
            <li class="heading">
                <h3 class="uppercase">MENU MASTER</h3>
            </li>
            <li class="<?=$master;?>">
                <a href="#">
                    <i class="fa fa-folder-o"></i>
                    <span class="title"> Data Master</span>
                    <?=$span_master_1;?>
                    <span class="arrow <?=$span_master_2;?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$meja;?>">
                        <a href="<?=site_url('admin/meja');?>"><i class="fa fa-arrow-circle-o-right"></i> Meja</a>
                    </li>
                    <li class="<?=$pelanggan;?>">
                        <a href="<?=site_url('admin/pelanggan');?>"><i class="fa fa-arrow-circle-o-right"></i> Pelanggan</a>
                    </li>
                    <li class="<?=$tipe;?>">
                        <a href="<?=site_url('admin/tipe');?>"><i class="fa fa-arrow-circle-o-right"></i> Tipe Bayar</a>
                    </li>
                    <li class="<?=$kategori;?>">
                        <a href="<?=site_url('admin/kategori');?>"><i class="fa fa-arrow-circle-o-right"></i> Kategori</a>
                    </li>
                    <li class="<?=$barang;?>">
                        <a href="<?=site_url('admin/barang');?>"><i class="fa fa-arrow-circle-o-right"></i> Barang</a>
                    </li>
                </ul>
            </li>
            <?php }?>
            <?php if ($this->session->userdata('level') != 'Admin') {?>
            <li class="heading">
                <h3 class="uppercase">MENU BARANG</h3>
            </li>
            <li class="tooltips <?=$info;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Penjualan">
                <a href="<?=site_url('admin/info');?>">
                    <i class="fa fa-info-circle"></i><span class="title"> Info Barang</span>
                </a>
            </li>
            <?php }?>
            <li class="heading">
                <h3 class="uppercase">MENU TRANSAKSI</h3>
            </li>
            <li class="tooltips <?=$penjualan;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Penjualan">
                <a href="<?=site_url('admin/penjualan');?>">
                    <i class="fa fa-shopping-cart"></i><span class="title"> Penjualan</span>
                </a>
            </li>
            <li class="tooltips <?=$retur_jual;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Penjualan">
                <a href="<?=site_url('admin/retur_jual');?>">
                    <i class="fa fa-reply"></i><span class="title"> Retur Penjualan</span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">MENU LOGISTIK</h3>
            </li>
            <li class="tooltips <?=$masuk;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Penjualan">
                <a href="<?=site_url('admin/masuk');?>">
                    <i class="fa fa-sign-in"></i><span class="title"> Stok Masuk</span>
                </a>
            </li>
            <li class="tooltips <?=$keluar;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Penjualan">
                <a href="<?=site_url('admin/keluar');?>">
                    <i class="fa fa-sign-out"></i><span class="title"> Stok Keluar</span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">MENU UTILITY</h3>
            </li>
            <li class="tooltips <?=$printer;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Printer">
                <a href="<?=site_url('admin/printer');?>">
                    <i class="icon-printer"></i><span class="title"> Setting Printer</span>
                </a>
            </li>
            <?php if ($this->session->userdata('level') == 'Admin') {?>
            <li class="heading">
                <h3 class="uppercase">MENU USERS</h3>
            </li>
            <li class="tooltips <?=$users;?>" data-container="body" data-placement="right" data-html="true" data-original-title="Users">
                <a href="<?=site_url('admin/users');?>">
                    <i class="fa fa-users"></i><span class="title"> Users</span>
                </a>
            </li>
            <?php }?>
            <li class="heading">
                <h3 class="uppercase">MENU REPORT</h3>
            </li>
            <li class="<?=$rpt_stok;?>">
                <a href="#">
                    <i class="icon-notebook"></i>
                    <span class="title"> Laporan Stok</span>
                    <?=$span_rpt_stok_1;?>
                    <span class="arrow <?=$span_rpt_stok_2;?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$lap_stok_masuk;?>">
                        <a href="<?=site_url('admin/lap_stok_masuk');?>"><i class="fa fa-arrow-circle-o-right"></i> Stok Masuk</a>
                    </li>
                    <li class="<?=$lap_stok_keluar;?>">
                        <a href="<?=site_url('admin/lap_stok_keluar');?>"><i class="fa fa-arrow-circle-o-right"></i> Stok Keluar</a>
                    </li>
                </ul>
            </li>
            <li class="<?=$rpt_jual;?>">
                <a href="#">
                    <i class="icon-notebook"></i>
                    <span class="title"> Laporan Penjualan</span>
                    <?=$span_rpt_jual_1;?>
                    <span class="arrow <?=$span_rpt_jual_2;?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$lap_jual_periode;?>">
                        <a href="<?=site_url('admin/lap_jual_periode');?>"><i class="fa fa-arrow-circle-o-right"></i> Penjualan per Periode</a>
                    </li>
                    <li class="<?=$lap_jual_pelanggan;?>">
                        <a href="<?=site_url('admin/lap_jual_pelanggan');?>"><i class="fa fa-arrow-circle-o-right"></i> Penjualan per Pelanggan</a>
                    </li>
                    <li class="<?=$lap_jual_barang;?>">
                        <a href="<?=site_url('admin/lap_jual_barang');?>"><i class="fa fa-arrow-circle-o-right"></i> Penjualan per Barang</a>
                    </li>
                    <li class="<?=$lap_jual_rekap;?>">
                        <a href="<?=site_url('admin/lap_jual_rekap');?>"><i class="fa fa-arrow-circle-o-right"></i> Rekap Penjualan</a>
                    </li>
                    <li class="<?=$lap_jual_kategori;?>">
                        <a href="<?=site_url('admin/lap_jual_kategori');?>"><i class="fa fa-arrow-circle-o-right"></i> Rekap Per Kategori</a>
                    </li>
                    <li class="<?=$lap_kasir;?>">
                        <a href="<?=site_url('admin/lap_kasir');?>"><i class="fa fa-arrow-circle-o-right"></i> Transaksi Kasir</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>