<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="<?=base_url('img/logo-icon.png');?>">
<title>Print Penjualan per Barang</title>
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

$dari       = $this->uri->segment(4);
$sampai     = $this->uri->segment(5);
$barang_id  = $this->uri->segment(6);
$tgl_dari   = date('Y-m-d', strtotime($dari));
$tgl_sampai = date('Y-m-d', strtotime($sampai));
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
            <td align="center" valign="top" style="font-size: 15px; font-weight: bold;"><u>PENJUALAN PER BARANG</u></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?=$periode;?></td>
        </tr>
    </table>
    <br>
    <table cellpadding="2" cellspacing="2" border="1">
        <tr>
            <th width="3%">NO</th>
            <th width="10%">KODE</th>
            <th width="40%">NAMA BARANG</th>
            <th width="10%">QTY</th>
            <th width="10%">HARGA</th>
            <th width="10%">SUB TOTAL</th>
            <th width="7%">DISC (%)</th>
            <th width="10%">TOTAL</th>
        </tr>
        <?php 
        $totalfootqty = 0;
        $totalfootsub = 0;
        $totalfootdis = 0;
        $totalfoot    = 0;
        foreach($listData as $r) { 
            $kategori_id = $r->kategori_id;
            $listDetail  = $this->db->group_by('barang_id')->get_where('v_penjualan_detail', array('kategori_id' => $kategori_id, 'penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai))->result();
            if (count($listDetail) > 0) {
        ?>
        <tr>
            <th colspan="8" style="border-left: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->kategori_nama;?></th>
        </tr>
        <?php
            $no       = 1;
            $totalqty = 0;
            $totalsub = 0;
            $totaldis = 0;
            $total    = 0;
            foreach($listDetail as $d) {
                $barang_id = $d->barang_id;
                $dataSUM   = $this->db->select_sum('penjualan_detail_qty', 'qty')->select_sum('penjualan_detail_disc_rp', 'diskon')->select_sum('penjualan_detail_subtotal', 'total')->get_where('v_penjualan_detail', array('barang_id' => $barang_id, 'penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai))->row();
                $subtotal = ($dataSUM->qty*$d->penjualan_detail_harga);
        ?>
        <tr>
            <td align="center"><?=$no;?></td>
            <td><?=$d->penjualan_detail_kode;?></td>
            <td><?=$d->penjualan_detail_nama;?></td>
            <td align="center"><?=number_format($dataSUM->qty,0,'',',');?></td>
            <td align="right"><?=number_format($d->penjualan_detail_harga,0,'',',');?></td>
            <td align="right"><?=number_format($subtotal,0,'',',');?></td>
            <td align="right"><?=number_format($dataSUM->diskon,0,'',',');?></td>
            <td align="right"><?=number_format($dataSUM->total,0,'',',');?></td>
        </tr>
        <?php   
                $totalqty = ($totalqty+$dataSUM->qty);
                $totalsub = ($totalsub+$subtotal);
                $totaldis = ($totaldis+$dataSUM->diskon);
                $total    = ($total+$dataSUM->total);
                $no++;
            }
        ?>
        <tr>
            <td colspan="3" align="center"><b>SUB TOTAL : <?=$r->kategori_nama;?></b></td>
            <td align="center"><b><?=number_format($totalqty,0,'',',');?></b></td>
            <td></td>
            <td align="right"><b><?=number_format($totalsub,0,'',',');?></b></td>
            <td align="right"><b><?=number_format($totaldis,0,'',',');?></b></td>
            <td align="right"><b><?=number_format($total,0,'',',');?></b></td>
        </tr>        
        <?php
                $totalfootqty = ($totalfootqty+$totalqty);
                $totalfootsub = ($totalfootsub+$totalsub);
                $totalfootdis = ($totalfootdis+$totaldis);
                $totalfoot    = ($totalfoot+$total);
            }
        } 
        ?>
        <tr>
            <td colspan="3" align="center"><b>TOTAL</b></td>
            <td align="center"><b><?=number_format($totalfootqty,0,'',',');?></b></td>
            <td></td>
            <td align="right"><b><?=number_format($totalfootsub,0,'',',');?></b></td>
            <td align="right"><b><?=number_format($totalfootdis,0,'',',');?></b></td>
            <td align="right"><b><?=number_format($totalfoot,0,'',',');?></b></td>
        </tr> 
    </table>
</div>
</body>
</html>