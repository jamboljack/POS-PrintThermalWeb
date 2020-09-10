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
    <table width="100%">
        <tr>
            <th width="3%" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO</th>
            <th width="20%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO. FAKTUR</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TANGGAL</th>
            <th width="30%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">PELANGGAN</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">JUMLAH</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">HARGA</th>
            <th width="7%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">DISC (%)</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">TOTAL</th>
        </tr>
        <?php 
        foreach($listData as $r) { 
            $barang_id = $r->barang_id;
            $dari       = $this->uri->segment(4);
            $sampai     = $this->uri->segment(5);
            if ($dari != 'all' && $sampai != 'all') {
                $tgl_dari         = date('Y-m-d', strtotime($dari));
                $tgl_sampai       = date('Y-m-d', strtotime($sampai));
                $listDetail = $this->db->order_by('penjualan_tanggal', 'asc')->get_where('v_penjualan_detail', array('penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai, 'barang_id' => $barang_id))->result();
            } else {
                $listDetail = $this->db->order_by('penjualan_tanggal', 'asc')->get_where('v_penjualan_detail', array('barang_id' => $barang_id))->result();
            }

            if (count($listDetail) > 0) {
        ?>
        <tr>
            <th align="left" colspan="8" style="border-left: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->barang_kode.' - '.$r->barang_nama;?></th>
        </tr>
        <?php
            $no    = 1;
            $total = 0;
            foreach($listDetail as $d) {
        ?>
        <tr>
            <td align="center" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$no;?></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->penjualan_no;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=date('d-m-Y', strtotime($d->penjualan_tanggal));?></td>
            <td style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$d->pelanggan_nama;?></td>
            <td align="center" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_qty,0,'.',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_harga,0,'',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_disc,2,'.',',');?></td>
            <td align="right" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=number_format($d->penjualan_detail_subtotal,0,'',',');?></td>
        </tr>
        <?php
            $total = ($total+$d->penjualan_detail_subtotal);
            $no++; 
            }
        ?>
        <tr>
            <td colspan="7" align="right" style="border-left: 0.5px solid black; border-bottom: 0.5px solid black;"><b>TOTAL :</b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($total,0,'',',');?></b></td>
        </tr>
        <?php
            }
        } 
        ?>
    </table>
</div>
</body>
</html>