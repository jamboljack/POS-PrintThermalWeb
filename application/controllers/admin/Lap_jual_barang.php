<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_jual_barang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_jual_barang_m');
    }

    public function index()
    {
        $this->template->display('admin/reportjual/reportjualbarang_v');
    }

    public function data_barang_list()
    {
        $List = $this->lap_jual_barang_m->get_barang_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row       = array();
            $barang_id = $r->barang_id;
            $row[]     = '<a href="javascript:void(0)" title="Pilih" onclick="pilihdata(' . "'" . $barang_id . "'" . ')"><i class="icon-check"></i></a>';
            $row[]     = $no;
            $row[]     = $r->barang_kode;
            $row[]     = $r->barang_nama;
            $row[]     = $r->kategori_nama;
            $row[]     = number_format($r->barang_stok, 0, '', ',');
            $row[]     = number_format($r->barang_harga, 0, '', ',');
            $data[]    = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_jual_barang_m->count_barang_all(),
            "recordsFiltered" => $this->lap_jual_barang_m->count_barang_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_list()
    {
        $List = $this->lap_jual_barang_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = date('d-m-Y', strtotime($r->penjualan_tanggal));
            $row[]  = $r->penjualan_detail_kode;
            $row[]  = $r->penjualan_detail_nama;
            $row[]  = number_format($r->penjualan_detail_qty, 0, '', ',');
            $row[]  = number_format($r->penjualan_detail_harga, 0, '', ',');
            $row[]  = number_format($r->penjualan_detail_disc, 2, '.', ',');
            $row[]  = number_format($r->penjualan_detail_subtotal, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_jual_barang_m->count_all(),
            "recordsFiltered" => $this->lap_jual_barang_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_barang($id)
    {
        $data = $this->db->get_where('v_barang', array('barang_id' => $id))->row();
        echo json_encode($data);
    }

    public function printbarang($dari = 'all', $sampai = 'all', $barang = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($barang != 'all') {
            $data['listData'] = $this->db->order_by('barang_nama', 'asc')->get_where('v_barang', array('barang_id' => $barang))->result();
        } else {
            $data['listData'] = $this->db->order_by('barang_nama', 'asc')->get('v_barang')->result();
        }

        $this->load->view('admin/reportjual/printbarang_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_jual_barang.php */
