<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tipe extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/tipe_m');
    }

    public function index()
    {
        $this->template->display('admin/master/tipe_v');
    }

    public function data_list()
    {
        $List = $this->tipe_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row     = array();
            $tipe_id = $r->tipe_id;
            $row[]   = '<a title="Edit Data" href="javascript:void(0)" onclick="edit_data(' . "'" . $tipe_id . "'" . ')"><i class="icon-pencil"></i></a>
                            <a onclick="hapusData(' . $tipe_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->tipe_nama;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->tipe_m->count_all(),
            "recordsFiltered" => $this->tipe_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function savedata()
    {
        $this->tipe_m->insert_data();
    }

    public function get_data($id)
    {
        $data = $this->tipe_m->select_by_id($id)->row();
        echo json_encode($data);
    }

    public function updatedata()
    {
        $this->tipe_m->update_data();
    }

    public function deletedata($id)
    {
        $this->tipe_m->delete_data($id);
    }
}
/* Location: ./application/controller/admin/Tipe.php */
