<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" href="<?=base_url('img/logo-icon.png');?>">
<title>Print Bukti : <?=$detail->masuk_nomor;?></title>
<style type="text/css">
    table {
        width: 100%;
        border-collapse: collapse;
    }

    tr, td {
        padding: 2px;
    }

    th {
        height: 25px;
        background-color: #eff3f8;
    }
    body{
        font-family: "Franklin Gothic Medium";
        font-size:12px;
    }
    h1{
        font-size:20px
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
            <td width="50%" colspan="4" align="right" valign="top"><h1><u>BUKTI STOK MASUK</u></h1></td>
        </tr>
        <tr>
            <td width="50%" align="left" rowspan="3" valign="top"><?='<b>' . $header->contact_name . '</b><br>' . $header->contact_address . '<br>No. Telp : ' . $header->contact_phone . '<br>Email : ' . $header->contact_email;?></td>
            <td width="15%" valign="top">Tanggal</td>
            <td width="2%" valign="top">:</td>
            <td width="33%" valign="top"><?=date('d-m-Y', strtotime($detail->masuk_tanggal));?></td>
        </tr>
        <tr>
            <td valign="top">No. Transaksi</td>
            <td valign="top">:</td>
            <td valign="top"><?=trim($detail->masuk_nomor);?></td>
        </tr>
        <tr>
            <td valign="top">Keterangan</td>
            <td valign="top">:</td>
            <td valign="top"><?=trim($detail->masuk_keterangan);?></td>
        </tr>
    </table>
    <br>
    <table width="100%" align="center">
        <tr>
            <th width="5%" style="border-top: 0.5px solid black; border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NO</th>
            <th width="10%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">KODE</th>
            <th width="50%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">NAMA BARANG</th>
            <th width="20%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">KATEGORI</th>
            <th width="15%" style="border-top: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;">JUMLAH</th>
        </tr>
        <?php
			$no    = 1;
			$total = 0;
			foreach ($listDetail as $r) {
		?>
        <tr>
            <td align="center" style="border-left: 0.5px solid black; border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$no;?></td>
            <td align="center" style="border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->barang_kode;?></td>
            <td style="border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->barang_nama;?></td>
            <td style="border-bottom: 0.5px solid black; border-right: 0.5px solid black;"><?=$r->kategori_nama;?></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><?=number_format($r->masuk_detail_qty, 0, '', ',');?></td>
        </tr>
        <?php
			$total = $total + $r->masuk_detail_qty;
	    	$no++;
		}
		?>
        <tr>
            <td colspan="4" align="center" style="border-left: 0.5px solid black; border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b>TOTAL</b></td>
            <td align="right" style="border-right: 0.5px solid black; border-bottom: 0.5px solid black;"><b><?=number_format($total, 0, '', ',');?></b></td>
        </tr>
    </table>
    <br><br>
    <table width="100%" align="center">
        <tr>
            <td width="50%" align="center">Petugas<br><br><br><br><br></td>
            <td width="50%" align="center">Penerima<br><br><br><br><br></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?=$detail->user_name;?></td>
            <td align="center" valign="top"><?=$detail->penerima;?><br><?=($detail->masuk_tgl_terima != '' ? date('d-m-Y', strtotime($detail->masuk_tgl_terima)) : '-');?></td>
        </tr>
    </table>
</div>
</body>
</html>