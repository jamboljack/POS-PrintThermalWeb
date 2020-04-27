<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testprint extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("EscPos");
    }

    public function index()
    {
        try {
            $dataToko  = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
            $dataOrder = $this->db->get_where('vivo_order', array('order_id' => 13))->row();
            $listItem  = $this->db->get_where('vivo_order_detail', array('order_id' => 13))->result();
            // $connector  = new FilePrintConnector("/dev/usb/lp0");
            // $connector  = new WindowsPrintConnector("Receipt Printer");
            $connector  = new Escpos\PrintConnectors\WindowsPrintConnector("Receipt");
            $printer    = new Escpos\Printer($connector);
            $NamaToko   = trim($dataToko->contact_name);
            $AlamatToko = trim($dataToko->contact_address);
            $TelpToko   = trim($dataToko->contact_phone);
            $NoOrder    = trim($dataOrder->order_no);
            $Tanggal    = date('d-m-Y', strtotime($dataOrder->order_tanggal));
            $Kasir      = trim($dataOrder->user_username);
            $DataHeader = $this->addHeader($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $Kasir);
            $printer->text($DataHeader);
            foreach ($listItem as $r) {
                $NamaMenu = trim($r->order_detail_nama);
                $Harga    = number_format($r->order_detail_harga, 0, '', ',');
                $Qty      = number_format($r->order_detail_qty, 0, '', ',');
                $Subtotal = number_format($r->order_detail_subtotal, 0, '', ',');
                $DataItem = $this->addItem($NamaMenu, $Harga, $Qty, $Subtotal);
                $printer->text($DataItem);
            }
            $SubTotal   = number_format($dataOrder->order_subtotal, 0, '', ',');
            $Diskon     = number_format($dataOrder->order_diskon, 0, '', ',');
            $Pajak      = number_format($dataOrder->order_ppn_rp, 0, '', ',');
            $Total      = number_format($dataOrder->order_total, 0, '', ',');
            $NPWPD      = trim($dataToko->contact_npwpd);
            $DataFooter = $this->addFooter($SubTotal, $Diskon, $Pajak, $Total, $NPWPD);
            $printer->text($DataFooter);
            $printer->cut();
            /* Close printer */
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function addHeader($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $Kasir)
    {
        $returnValue = "";
        $limitHeader = 20;
        $txtToko     = "";
        $txtAlamat   = "";
        $txtTelp     = "";

        if (strlen($NamaToko) <= $limitHeader) {
            $txtToko = str_pad($NamaToko, $limitHeader);
        } else {
            $txtToko = substr($NamaToko, 0, $limitHeader);
        }

        if (strlen($AlamatToko) <= $limitHeader) {
            $txtAlamat = str_pad($AlamatToko, $limitHeader);
        } else {
            $txtAlamat = substr($AlamatToko, 0, $limitHeader);
        }

        if (strlen($TelpToko) <= $limitHeader) {
            $txtTelp = str_pad($TelpToko, $limitHeader);
        } else {
            $txtTelp = substr($TelpToko, 0, $limitHeader);
        }
        $returnValue .= "" . chr(10);
        $returnValue .= "Toko      : " . $txtToko . chr(10);
        $returnValue .= "Alamat    : " . $txtAlamat . chr(10);
        $returnValue .= "No  Telp  : " . $txtTelp . chr(10);
        $returnValue .= "No  Order : " . $NoOrder . chr(10);
        $returnValue .= "Tanggal   : " . $Tanggal . chr(10);
        $returnValue .= "Kasir     : " . $Kasir . chr(10);
        $returnValue .= "================================" . chr(10);
        $returnValue .= "Menu          Harga Qty Subtotal" . chr(10);
        $returnValue .= "================================" . chr(10);
        return $returnValue;
    }

    public function addItem($NamaMenu, $Harga, $Qty, $Subtotal)
    {
        // LimitCharacter
        $limitNamaMenu = 11;
        $limitHarga    = 7;
        $limitQty      = 3;
        // $limitDisc     = 4;
        $limitSubtotal = 8;
        // Variabel
        $txtNamaMenu = "";
        $txtHarga    = 0;
        $txtQty      = 0;
        // $txtDisc     = 0.00;
        $txtSubtotal = 0;

        // Nama Menu
        if (strlen($NamaMenu) <= $limitNamaMenu) {
            $txtNamaMenu = str_pad($NamaMenu, $limitNamaMenu);
        } else {
            $txtNamaMenu = substr($NamaMenu, 0, $limitNamaMenu);
        }

        // Harga
        if (strlen($Harga) <= $limitHarga) {
            $txtHarga = str_pad($Harga, $limitHarga, " ", STR_PAD_LEFT);
        } else {
            $txtHarga = substr($Harga, 0, $limitHarga);
        }

        // Qty
        if (strlen($Qty) <= $limitQty) {
            $txtQty = str_pad($Qty, $limitQty, " ", STR_PAD_LEFT);
        } else {
            $txtQty = substr($Qty, 0, $limitQty);
        }

        // Disc
        // if (strlen($Disc) <= $limitDisc) {
        //     $txtDisc = str_pad($Disc, $limitDisc, " ", STR_PAD_LEFT);
        // } else {
        //     $txtDisc = substr($Disc, 0, $limitDisc);
        // }

        // Subtotal
        if (strlen($Subtotal) <= $limitSubtotal) {
            $txtSubtotal = str_pad($Subtotal, $limitSubtotal, " ", STR_PAD_LEFT);
        } else {
            $txtSubtotal = substr($Subtotal, 0, $limitSubtotal);
        }

        $returnValue = "" . $txtNamaMenu . " " . $txtHarga . " " . $txtQty . " " . $txtSubtotal . chr(10);
        return $returnValue;
    }

    public function addFooter($SubTotal, $Diskon, $Pajak, $Total, $NPWPD)
    {

        // LimitCharacter
        $limitNominal = 9;
        // Variabel
        $txtSubTotal = 0;
        $txtDiskon   = 0;
        $txtPajak    = 0;
        $txtTotal    = 0;

        // Sub Total
        if (strlen($SubTotal) <= $limitNominal) {
            $txtSubTotal = str_pad($SubTotal, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtSubTotal = substr($SubTotal, 0, $limitNominal);
        }

        // Diskon
        if (strlen($Diskon) <= $limitNominal) {
            $txtDiskon = str_pad($Diskon, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtDiskon = substr($Diskon, 0, $limitNominal);
        }

        // Pajak
        if (strlen($Pajak) <= $limitNominal) {
            $txtPajak = str_pad($Pajak, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtPajak = substr($Pajak, 0, $limitNominal);
        }

        // Total
        if (strlen($Total) <= $limitNominal) {
            $txtTotal = str_pad($Total, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtTotal = substr($Total, 0, $limitNominal);
        }

        $returnValue = "" . chr(10);
        $returnValue .= "           Sub Total : " . $txtSubTotal . chr(10);
        $returnValue .= "              Diskon : " . $txtDiskon . chr(10);
        $returnValue .= "        Pajak Daerah : " . $txtPajak . chr(10);
        $returnValue .= "               TOTAL : " . $txtTotal . chr(10);
        $returnValue .= "--------------------------------" . chr(10);
        $returnValue .= "NPWPD : " . $NPWPD . chr(10);
        $returnValue .= "Harga termasuk Pajak Daerah" . chr(10);
        $returnValue .= "Terima Kasih atas kunjungan Anda" . chr(10);
        return $returnValue;
    }
}
/* Location: ./application/controller/admin/Testprint.php */
