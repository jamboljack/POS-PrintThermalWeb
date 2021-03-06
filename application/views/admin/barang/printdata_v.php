<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="<?=base_url('img/logo-icon.png');?>">
<title>Print Daftar Harga Jual</title>
<style type="text/css">
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    tr, td {
        padding: 3px;
    }

    th {
        height: 20px;
        background-color: #eff3f8;
    }
    body{
        font-family: "Franklin Gothic Medium";
        font-size:12px;
    }
    h1{
        font-size:16px;
        font-weight: bold;
    }
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 0cm;
        margin: 0.1cm auto;
        border: 0.3px #D3D3D3 none;
        border-radius: 2px;
        background: white;
    }

    @media print{
        #comments_controls,
        #print-link{
            display:none;
        }
    }
</style>
</head>
<body>
<a href="#Print">
<img src="<?=base_url('img/print.png');?>" height="24" width="24" title="Print" id="print-link" onClick="window.print();return false;" />
</a>
<div class="page">
    <table width="100%" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top"><?='<b>'.$header->contact_name.'</b><br>'.$header->contact_address.'<br>No. Telp : '.$header->contact_phone.'<br>Email : '.$header->contact_email;?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><hr style="height:2px; border-top:2px solid black; border-bottom:1px solid black;"></td>
        </tr>
        <tr>
            <td align="center" valign="top" style="font-size: 15px; font-weight: bold;"><u>DAFTAR HARGA</u></td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <th width="3%" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO</th>
            <th width="15%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">KODE BARANG</th>
            <th width="32%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NAMA BARANG</th>
            <th width="15%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TIPE</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">STOK</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">PPN (%)</th>
            <th width="15%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">HARGA</th>
        </tr>
        <?php 
        foreach($listData as $r) { 
            $kategori_id = $r->kategori_id;
            $listDetail = $this->db->order_by('barang_nama', 'asc')->get_where('v_barang', array('kategori_id' => $kategori_id))->result();
            if (count($listDetail) > 0) {
        ?>
        <tr>
            <th align="left" colspan="9" style="border-left: 0.5px solid black; border-right: 0.5px solid black;">KATEGORI : <?=$r->kategori_nama;?></th>
        </tr>
        <?php
            $no    = 1;
            foreach($listDetail as $d) {
        ?>
        <tr>
            <td align="center" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$no;?></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->barang_kode;?></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->barang_nama;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=($d->barang_tipe == 'S'?'STOK':'NON STOK');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->barang_stok,0,'',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->barang_ppn,2,'.',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->barang_total,0,'',',');?></td>
        </tr>
        <?php
            $no++; 
            }
        }
    }
        ?>
    </table>
</div>
</body>
</html>