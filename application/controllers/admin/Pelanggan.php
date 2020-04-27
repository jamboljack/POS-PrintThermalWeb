<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/pelanggan_m');
    }

    public function index()
    {
        $this->template->display('admin/master/pelanggan_v');
    }

    public function data_list()
    {
        $List = $this->pelanggan_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row          = array();
            $pelanggan_id = $r->pelanggan_id;
            $row[]        = '<a title="Edit Data" href="javascript:void(0)" onclick="edit_data(' . "'" . $pelanggan_id . "'" . ')"><i class="icon-pencil"></i></a>
                        <a onclick="hapusData(' . $pelanggan_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->pelanggan_nomor;
            $row[]  = $r->pelanggan_nama;
            $row[]  = $r->pelanggan_alamat . ' - ' . $r->pelanggan_kota;
            $row[]  = number_format($r->pelanggan_disc, 2, '.', ',');
            $row[]  = ($r->pelanggan_expired!=''?date('d-m-Y', strtotime($r->pelanggan_expired)):'-');
            $row[]  = number_format($r->pelanggan_poin, 0, '', ',');
            $row[]  = ($r->pelanggan_status=='Y'?'<span class="label label-success">YA</span>':'<span class="label label-danger">TIDAK</span>');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->pelanggan_m->count_all(),
            "recordsFiltered" => $this->pelanggan_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    private function nomor_exists($nomor)
    {
        $this->db->where('pelanggan_nomor', $nomor);
        $query = $this->db->get('vivo_pelanggan');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function register_nomor_exists()
    {
        if (array_key_exists('nomor', $_POST)) {
            if ($this->nomor_exists(stripHTMLtags($this->input->post('nomor', 'true'))) == true) {
                echo json_encode(false);
            } else {
                echo json_encode(true);
            }
        }
    }

    public function savedata()
    {
        $this->pelanggan_m->insert_data();
    }

    public function get_data($id)
    {
        $data = $this->pelanggan_m->select_by_id($id)->row();
        echo json_encode($data);
    }

    public function updatedata()
    {
        $this->pelanggan_m->update_data();
    }

    public function deletedata($id)
    {
        $this->pelanggan_m->delete_data($id);
    }
}
/* Location: ./application/controller/admin/Pelanggan.php */
