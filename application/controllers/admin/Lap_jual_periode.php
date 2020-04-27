<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_jual_periode extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_jual_periode_m');
    }

    public function index()
    {
        $data['listPelanggan'] = $this->db->order_by('pelanggan_nama', 'asc')->get('vivo_pelanggan')->result();
        $this->template->display('admin/reportjual/reportjualperiode_v', $data);
    }

    public function data_list()
    {
        $List = $this->lap_jual_periode_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->penjualan_no;
            $row[]  = date('d-m-Y', strtotime($r->penjualan_tanggal));
            $row[]  = $r->pelanggan_nomor;
            $row[]  = $r->pelanggan_nama;
            $row[]  = number_format($r->penjualan_diskon, 0, '', ',');
            $row[]  = number_format($r->penjualan_tukar_poin_rp, 0, '', ',');
            $row[]  = number_format($r->penjualan_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_jual_periode_m->count_all(),
            "recordsFiltered" => $this->lap_jual_periode_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function printperiode($dari = 'all', $sampai = 'all', $pelanggan = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($dari != 'all' && $sampai != 'all' && $pelanggan == 'all') {
            $tgl_dari         = date('Y-m-d', strtotime($dari));
            $tgl_sampai       = date('Y-m-d', strtotime($sampai));
            $data['listData'] = $this->db->order_by('penjualan_tanggal', 'asc')->get_where('v_penjualan', array('penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai))->result();
        } elseif ($dari == 'all' && $sampai == 'all' && $pelanggan != 'all') {
            $data['listData'] = $this->db->order_by('penjualan_tanggal', 'asc')->get_where('v_penjualan', array('pelanggan_id' => $pelanggan))->result();
        } elseif ($dari != 'all' && $sampai != 'all' && $pelanggan != 'all') {
            $tgl_dari         = date('Y-m-d', strtotime($dari));
            $tgl_sampai       = date('Y-m-d', strtotime($sampai));
            $data['listData'] = $this->db->order_by('penjualan_tanggal', 'asc')->get_where('v_penjualan', array('penjualan_tanggal >=' => $tgl_dari, 'penjualan_tanggal <=' => $tgl_sampai, 'pelanggan_id' => $pelanggan))->result();
        } else {
            $data['listData'] = $this->db->order_by('penjualan_tanggal', 'asc')->get('v_penjualan')->result();
        }

        $this->load->view('admin/reportjual/printperiode_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_jual_periode.php */
