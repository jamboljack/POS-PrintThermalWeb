<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="<?=base_url('img/logo-icon.png');?>">
<title>Print Rekap Penjualan</title>
<style type="text/css">
    table {
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
            <td align="center" valign="top" style="font-size: 15px; font-weight: bold;"><u>REKAP PENJUALAN</u></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?=$periode;?></td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <th width="3%" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO</th>
            <th width="42%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO. FAKTUR</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TANGGAL</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">BRUTO</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">DISKON</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">DISKON POIN</th>
            <th width="15%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TOTAL</th>
        </tr>
        <?php 
        $no          = 1;
        $totalbruto  = 0;
        $totaldiskon = 0;
        $totalpoin   = 0;
        $total       = 0;
        foreach($listData as $r) {
        ?>
        <tr>
            <td align="center" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$no;?></td>
            <td colspan="6" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><b><?=$r->pelanggan_nama;?></b></td>
        </tr>
        <tr>
            <td align="center" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->penjualan_no;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=date('d-m-Y', strtotime($r->penjualan_tanggal));?></td>
            <td align="right" width="8" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($r->penjualan_subtotal,0,'',',');?></td>
            <td align="right" width="8" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($r->penjualan_diskon,0,'',',');?></td>
            <td align="right" width="8" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($r->penjualan_tukar_poin_rp,0,'',',');?></td>
            <td align="right" width="8" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($r->penjualan_total,0,'',',');?></td>
        </tr>
        <?php
            $totalbruto  = ($totalbruto+$r->penjualan_subtotal);
            $totaldiskon = ($totaldiskon+$r->penjualan_diskon);
            $totalpoin   = ($totalpoin+$r->penjualan_tukar_poin_rp);
            $total       = ($total+$r->penjualan_total);
            $no++; 
        }
        ?>
        <tr>
            <td colspan="3" align="center" style="border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><b>TOTAL</b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($totalbruto,0,'',',');?></b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($totaldiskon,0,'',',');?></b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($totalpoin,0,'',',');?></b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($total,0,'',',');?></b></td>
        </tr>
    </table>
    <br>
    <table width="50%" border="1" cellpadding="2" cellspacing="2">
        <tr>
            <th width="5%">NO</th>
            <th width="50%">TIPE BAYAR</th>
            <th width="45%">TOTAL</th>
        </tr>
        <?php 
        $tgl_dari    = date('Y-m-d', strtotime($this->uri->segment(4)));
        $tgl_sampai  = date('Y-m-d', strtotime($this->uri->segment(5)));
        $pelanggan   = $this->uri->segment(6);
        $no          = 1;
        $total       = 0;
        foreach($listTipe as $r) {
            $tipe_id  = $r->tipe_id;
            if ($pelanggan == 'all') {
                $dataTotal = $this->db->select_sum('penjualan_total', 'total')->get_where('v_penjualan', array('penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai, 'tipe_id' => $tipe_id))->row();
            } else {
                $dataTotal = $this->db->select_sum('penjualan_total', 'total')->get_where('v_penjualan', array('penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai, 'tipe_id' => $tipe_id, 'pelanggan_id' => $pelanggan))->row();
            }


        ?>
        <tr>
            <td align="center"><?=$no;?></td>
            <td><?=$r->tipe_nama;?></td>
            <td align="right"><?=number_format($dataTotal->total,0,'',',');?></td>
        </tr>
        <?php 
            $total = ($total+$dataTotal->total);
            $no++;
        } 
        ?>
        <tr>
            <td colspan="2" align="center">TOTAL</td>
            <td align="right"><?=number_format($total,0,'',',');?></td>
        </tr>
    </table>
</div>
</body>
</html>