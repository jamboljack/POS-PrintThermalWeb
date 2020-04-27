<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_jual_pelanggan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_jual_pelanggan_m');
    }

    public function index()
    {
        $data['listPelanggan'] = $this->db->order_by('pelanggan_nama', 'asc')->get('vivo_pelanggan')->result();
        $this->template->display('admin/reportjual/reportjualpelanggan_v', $data);
    }

    public function data_list()
    {
        $List = $this->lap_jual_pelanggan_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = date('d-m-Y', strtotime($r->penjualan_tanggal));
            $row[]  = $r->pelanggan_nama;
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
            "recordsTotal"    => $this->lap_jual_pelanggan_m->count_all(),
            "recordsFiltered" => $this->lap_jual_pelanggan_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function printpelanggan($dari = 'all', $sampai = 'all', $pelanggan = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($pelanggan != 'all') {
            $data['listData'] = $this->db->order_by('pelanggan_nama', 'asc')->get_where('vivo_pelanggan', array('pelanggan_id' => $pelanggan))->result();
        } else {
            $data['listData'] = $this->db->order_by('pelanggan_nama', 'asc')->get('vivo_pelanggan')->result();
        }

        $this->load->view('admin/reportjual/printpelanggan_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_jual_pelanggan.php */
