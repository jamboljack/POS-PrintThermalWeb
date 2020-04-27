<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/keluar_m');
    }

    public function index()
    {
        $this->template->display('admin/keluar/view');
    }

    public function data_list()
    {
        $List = $this->keluar_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row      = array();
            $keluar_id = $r->keluar_id;
            $link     = site_url('admin/keluar/editdata/' . $keluar_id);
            $row[]    = '<a href="' . $link . '" title="Edit Data"><i class="icon-pencil"></i></a>
                         <a onclick="hapusData(' . $keluar_id . ')" title="Delete Data"><i class="icon-close"></i></a> 
                         <a onclick="printBukti(' . $keluar_id . ')" title="Print Bukti"><i class="icon-printer"></i></a>';
            $row[]  = $no;
            $row[]  = $r->keluar_nomor;
            $row[]  = date('d-m-Y', strtotime($r->keluar_tanggal));
            $row[]  = $r->keluar_keterangan;
            $row[]  = $r->user_name;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->keluar_m->count_all(),
            "recordsFiltered" => $this->keluar_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function adddata()
    {
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_keluar_temp');

        $this->template->display('admin/keluar/add');
    }

    public function data_temp_list()
    {
        $List = $this->keluar_m->get_temp_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row           = array();
            $keluar_temp_id = $r->keluar_temp_id;
            $row[]         = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $keluar_temp_id . "'" . ')"><i class="icon-pencil"></i></a>
                              <a onclick="hapusData(' . $keluar_temp_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = number_format($r->keluar_temp_qty, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->keluar_m->count_temp_all(),
            "recordsFiltered" => $this->keluar_m->count_temp_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_total_temp()
    {
        $username = $this->session->userdata('username');
        $data     = $this->db->select_sum('keluar_temp_qty', 'total')->get_where('vivo_keluar_temp', array('user_username' => $username))->row();
        echo json_encode($data);
    }

    public function data_barang_list()
    {
        $List = $this->keluar_m->get_barang_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row       = array();
            $barang_id = $r->barang_id;
            $row[]     = '<a href="javascript:void(0)" title="Pilih" onclick="pilihdata(' . "'" . $barang_id . "'" . ')" class="btn btn-primary btn-xs"><i class="fa fa-check-circle"></i> Pilih</a>';
            $row[]     = $no;
            $row[]     = $r->barang_kode;
            $row[]     = $r->barang_nama;
            $row[]     = $r->kategori_nama;
            $row[]     = number_format($r->barang_stok, 0, '', ',');
            $data[]    = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->keluar_m->count_barang_all(),
            "recordsFiltered" => $this->keluar_m->count_barang_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_barang($id)
    {
        $data = $this->db->get_where('v_barang', array('barang_id' => $id))->row();
        echo json_encode($data);
    }

    public function saveitem()
    {
        $this->keluar_m->insert_data_item();
    }

    public function get_data_item($id)
    {
        $data = $this->db->get_where('v_keluar_temp', array('keluar_temp_id' => $id))->row();
        echo json_encode($data);
    }

    public function updateitem()
    {
        $this->keluar_m->update_data_item();
    }

    public function deleteitem($id)
    {
        $this->keluar_m->delete_data_item($id);
    }

    public function savedata()
    {
        $this->keluar_m->insert_data_keluar();
    }

    public function editdata($keluar_id)
    {
        $data['detail'] = $this->db->get_where('v_keluar', array('keluar_id' => $keluar_id))->row();
        $this->template->display('admin/keluar/edit', $data);
    }

    public function data_detail_list($keluar_id)
    {
        $List = $this->keluar_m->get_detail_datatables($keluar_id);
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row             = array();
            $keluar_detail_id = $r->keluar_detail_id;
            $row[]           = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $keluar_detail_id . "'" . ')"><i class="icon-pencil"></i></a>
                            <a onclick="hapusData(' . $keluar_detail_id . ')" title="Hapus Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = number_format($r->keluar_detail_qty, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->keluar_m->count_detail_all($keluar_id),
            "recordsFiltered" => $this->keluar_m->count_detail_filtered($keluar_id),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_total_detail($keluar_id)
    {
        $data = $this->db->select_sum('keluar_detail_qty', 'total')->get_where('vivo_keluar_detail', array('keluar_id' => $keluar_id))->row();
        echo json_encode($data);
    }

    public function saveitemdetail()
    {
        $this->keluar_m->insert_data_detail();
    }

    public function get_data_detail($id)
    {
        $data = $this->db->get_where('v_keluar_detail', array('keluar_detail_id' => $id))->row();
        echo json_encode($data);
    }

    public function updateitemdetail()
    {
        $this->keluar_m->update_data_detail();
    }

    public function deleteitemdetail($id)
    {
        $this->keluar_m->delete_data_detail($id);
    }

    public function updatedata()
    {
        $this->keluar_m->update_data_keluar();
    }

    public function deletedata($id)
    {
        $this->keluar_m->delete_data_keluar($id);
    }

    public function printbukti($id)
    {
        $data['header']     = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['detail']     = $this->db->get_where('v_keluar', array('keluar_id' => $id))->row();
        $data['listDetail'] = $this->db->order_by('barang_kode', 'asc')->get_where('v_keluar_detail', array('keluar_id' => $id))->result();
        $this->load->view('admin/keluar/printbukti_v', $data);
    }
}
/* Location: ./application/controller/admin/Keluar.php */
