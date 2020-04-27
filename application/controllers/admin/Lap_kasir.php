<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_kasir extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_kasir_m');
    }

    public function index()
    {
        $data['listKasir'] = $this->db->order_by('user_name', 'asc')->get('vivo_users')->result();
        $this->template->display('admin/reportjual/reportkasir_v', $data);
    }

    public function data_list()
    {
        $List = $this->lap_kasir_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->user_username;
            $row[]  = $r->penjualan_no;
            $row[]  = date('d-m-Y', strtotime($r->penjualan_tanggal));
            $row[]  = $r->pelanggan_nama;
            $row[]  = number_format($r->penjualan_diskon, 0, '', ',');
            $row[]  = number_format($r->penjualan_tukar_poin_rp, 0, '.', ',');
            $row[]  = number_format($r->penjualan_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_kasir_m->count_all(),
            "recordsFiltered" => $this->lap_kasir_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function printkasir($dari = 'all', $sampai = 'all', $kasir = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($kasir != 'all') {
            $data['listData'] = $this->db->order_by('user_name', 'asc')->get_where('vivo_users', array('user_username' => $kasir))->result();
        } else {
            $data['listData'] = $this->db->order_by('user_name', 'asc')->get('vivo_users')->result();
        }

        $this->load->view('admin/reportjual/printkasir_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_kasir_m.php */
