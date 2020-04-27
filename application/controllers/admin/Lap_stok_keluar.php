<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_stok_keluar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_stok_keluar_m');
    }

    public function index()
    {
        $this->template->display('admin/reportstok/reportstokkeluar_v');
    }

    public function data_list()
    {
        $List = $this->lap_stok_keluar_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->keluar_nomor;
            $row[]  = date('d-m-Y', strtotime($r->keluar_tanggal));
            $row[]  = $r->keluar_keterangan;
            $row[]  = $r->user_name;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_stok_keluar_m->count_all(),
            "recordsFiltered" => $this->lap_stok_keluar_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function printdata($dari = 'all', $sampai = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($dari != 'all' && $sampai != 'all') {
            $tgl_dari         = date('Y-m-d', strtotime($dari));
            $tgl_sampai       = date('Y-m-d', strtotime($sampai));
            $data['listData'] = $this->db->order_by('keluar_tanggal', 'asc')->get_where('v_keluar', array('keluar_tanggal >=' => $tgl_dari, 'keluar_tanggal <=' => $tgl_sampai))->result();
        } else {
            $data['listData'] = $this->db->order_by('keluar_tanggal', 'asc')->get('v_keluar')->result();
        }

        $this->load->view('admin/reportstok/printstokkeluar_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_stok_keluar.php */
