<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_stok_masuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/lap_stok_masuk_m');
    }

    public function index()
    {
        $this->template->display('admin/reportstok/reportstokmasuk_v');
    }

    public function data_list()
    {
        $List = $this->lap_stok_masuk_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->masuk_nomor;
            $row[]  = date('d-m-Y', strtotime($r->masuk_tanggal));
            $row[]  = $r->masuk_keterangan;
            $row[]  = $r->user_name;
            $row[]  = $r->penerima;
            $row[]  = ($r->masuk_tgl_terima != '' ? date('d-m-Y', strtotime($r->masuk_tgl_terima)) : '-');
            $row[]  = ($r->masuk_status == 'B' ? '<span class="label label-primary">BARU</label>' : '<span class="label label-success">TERIMA</label>');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->lap_stok_masuk_m->count_all(),
            "recordsFiltered" => $this->lap_stok_masuk_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function printdata($dari = 'all', $sampai = 'all', $status = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($dari != 'all' && $sampai != 'all' && $status == 'all') {
            $tgl_dari         = date('Y-m-d', strtotime($dari));
            $tgl_sampai       = date('Y-m-d', strtotime($sampai));
            $data['listData'] = $this->db->order_by('masuk_tanggal', 'asc')->get_where('v_masuk', array('masuk_tanggal >=' => $tgl_dari, 'masuk_tanggal <=' => $tgl_sampai))->result();
        } elseif ($dari == 'all' && $sampai == 'all' && $status != 'all') {
            $data['listData'] = $this->db->order_by('masuk_tanggal', 'asc')->get_where('v_masuk', array('masuk_status' => $status))->result();
        } elseif ($dari != 'all' && $sampai != 'all' && $status != 'all') {
            $tgl_dari         = date('Y-m-d', strtotime($dari));
            $tgl_sampai       = date('Y-m-d', strtotime($sampai));
            $data['listData'] = $this->db->order_by('masuk_tanggal', 'asc')->get_where('v_masuk', array('masuk_tanggal >=' => $tgl_dari, 'masuk_tanggal <=' => $tgl_sampai, 'masuk_status' => $status))->result();
        } else {
            $data['listData'] = $this->db->order_by('masuk_tanggal', 'asc')->get('v_masuk')->result();
        }

        $this->load->view('admin/reportstok/printstokmasuk_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_stok_masuk.php */
