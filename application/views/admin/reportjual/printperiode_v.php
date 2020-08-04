<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="<?=base_url('img/logo-icon.png');?>">
<title>Print Penjualan per Periode</title>
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
<?php 
if ($this->uri->segment(4) != 'all' && $this->uri->segment(5) != 'all') {
    $periode = 'PERIODE : '.$this->uri->segment(4).' s/d '.$this->uri->segment(5);
} else {
    $periode = '';
}

?>
<div class="page">
    <table width="100%" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top"><?='<b>'.$header->contact_name.'</b><br>'.$header->contact_address.'<br>No. Telp : '.$header->contact_phone.'<br>Email : '.$header->contact_email;?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><hr style="height:2px; border-top:2px solid black; border-bottom:1px solid black;"></td>
        </tr>
        <tr>
            <td align="center" valign="top" style="font-size: 15px; font-weight: bold;"><u>PENJUALAN PER PERIODE</u></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?=$periode;?></td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <th width="3%" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">KODE</th>
            <th width="40%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NAMA BARANG</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">JUMLAH</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">HARGA</th>
            <th width="7%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">DISC (%)</th>
            <th width="20%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TOTAL</th>
        </tr>
        <?php 
        foreach($listData as $r) { 
            $penjualan_id = $r->penjualan_id;
        ?>
        <tr>
            <th align="left" colspan="4" style="border-top: 0.5px solid black; border-left: 0.5px solid black;">Tanggal : <?=date('d-m-Y', strtotime($r->penjualan_tanggal));?> | No. Faktur : <?=$r->penjualan_no;?></th>
            <th align="left" colspan="3" style="border-top: 0.5px solid black; border-right: 0.5px solid black;">Pelanggan : <?=$r->pelanggan_nama;?></th>
        </tr>
        <?php 
            $listDetail = $this->db->get_where('v_penjualan_detail', array('penjualan_id' => $penjualan_id))->result();
            $no = 1;
            foreach($listDetail as $d) {
        ?>
        <tr>
            <td align="center" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$no;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->penjualan_detail_kode;?></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->penjualan_detail_nama;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_qty,0,'',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_harga,0,'',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_disc,2,'.',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_subtotal,0,'',',');?></td>
        </tr>
        <?php
            $no++; 
            }
        ?>
        <tr>
            <td colspan="6" align="right"><b>SUB TOTAL :</b></td>
            <td align="right" style="border-bottom: 0.5px dotted black;"><b><?=number_format($r->penjualan_subtotal,0,'',',');?></b></td>
        </tr>
        <tr>
            <td colspan="6" align="right"><b>Diskon :</b></td>
            <td align="right" style="border-bottom: 0.5px dotted black;"><b><?=number_format($r->penjualan_diskon,0,'',',');?></b></td>
        </tr>
        <tr>
            <td colspan="6" align="right"><b>Diskon POIN :</b></td>
            <td align="right" style="border-bottom: 0.5px dotted black;"><b><?=number_format($r->penjualan_tukar_poin_rp,0,'',',');?></b></td>
        </tr>
        <tr>
            <td colspan="6" align="right"><b>TOTAL :</b></td>
            <td align="right" style="border-bottom: 0.5px dotted black;"><b><?=number_format($r->penjualan_total,0,'',',');?></b></td>
        </tr>
        <tr>
            <td colspan="7"><br></td>
        </tr>
        <?php
        } 
        ?>
    </table>
</div>
</body>
</html>