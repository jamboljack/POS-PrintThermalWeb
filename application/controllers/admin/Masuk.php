<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/masuk_m');
    }

    public function index()
    {
        $this->template->display('admin/masuk/view');
    }

    public function data_list()
    {
        $List = $this->masuk_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row      = array();
            $masuk_id = $r->masuk_id;
            $link     = site_url('admin/masuk/editdata/' . $masuk_id);
            $detail   = site_url('admin/masuk/detail/' . $masuk_id);
            if ($this->session->userdata('level') == 'Admin' && $r->masuk_status == 'B') {
                $button = '<a href="' . $link . '" title="Edit Data"><i class="icon-pencil"></i></a>
                            <a onclick="hapusData(' . $masuk_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            } elseif ($this->session->userdata('level') != 'Admin' && $r->masuk_status == 'B') {
                $button = '<a href="' . $detail . '" title="Detail Data"><i class="icon-pencil"></i></a>
                            <a onclick="confirmData(' . $masuk_id . ')" title="Konfirmasi Data"><i class="icon-check"></i></a>';
            } else {
                $button = '<a href="' . $detail . '" title="Detail Data"><i class="icon-pencil"></i></a>';
            }
            $row[]  = $button . ' <a onclick="printBukti(' . $masuk_id . ')" title="Print Bukti"><i class="icon-printer"></i></a>';
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
            "recordsTotal"    => $this->masuk_m->count_all(),
            "recordsFiltered" => $this->masuk_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function adddata()
    {
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_masuk_temp');

        $this->template->display('admin/masuk/add');
    }

    public function data_temp_list()
    {
        $List = $this->masuk_m->get_temp_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row           = array();
            $masuk_temp_id = $r->masuk_temp_id;
            $row[]         = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $masuk_temp_id . "'" . ')"><i class="icon-pencil"></i></a>
                              <a onclick="hapusData(' . $masuk_temp_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = number_format($r->masuk_temp_qty, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->masuk_m->count_temp_all(),
            "recordsFiltered" => $this->masuk_m->count_temp_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_total_temp()
    {
        $username = $this->session->userdata('username');
        $data     = $this->db->select_sum('masuk_temp_qty', 'total')->get_where('vivo_masuk_temp', array('user_username' => $username))->row();
        echo json_encode($data);
    }

    public function data_barang_list()
    {
        $List = $this->masuk_m->get_barang_datatables();
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
            "recordsTotal"    => $this->masuk_m->count_barang_all(),
            "recordsFiltered" => $this->masuk_m->count_barang_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    private function bukti_exists($no_bukti)
    {
        $this->db->where('masuk_bukti', $no_bukti);
        $query = $this->db->get('vivo_masuk');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function register_bukti_exists()
    {
        if (array_key_exists('no_bukti', $_POST)) {
            if ($this->bukti_exists($this->input->post('no_bukti', 'true')) == true) {
                echo json_encode(false);
            } else {
                echo json_encode(true);
            }
        }
    }

    public function get_data_barang($id)
    {
        $data = $this->db->get_where('v_barang', array('barang_id' => $id))->row();
        echo json_encode($data);
    }

    public function saveitem()
    {
        $this->masuk_m->insert_data_item();
    }

    public function get_data_item($id)
    {
        $data = $this->db->get_where('v_masuk_temp', array('masuk_temp_id' => $id))->row();
        echo json_encode($data);
    }

    public function updateitem()
    {
        $this->masuk_m->update_data_item();
    }

    public function deleteitem($id)
    {
        $this->masuk_m->delete_data_item($id);
    }

    public function savedata()
    {
        $this->masuk_m->insert_data_masuk();
    }

    public function editdata($masuk_id)
    {
        $data['detail'] = $this->db->get_where('v_masuk', array('masuk_id' => $masuk_id))->row();
        $this->template->display('admin/masuk/edit', $data);
    }

    public function data_detail_list($masuk_id)
    {
        $List = $this->masuk_m->get_detail_datatables($masuk_id);
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row             = array();
            $masuk_detail_id = $r->masuk_detail_id;
            $row[]           = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $masuk_detail_id . "'" . ')"><i class="icon-pencil"></i></a>
                            <a onclick="hapusData(' . $masuk_detail_id . ')" title="Hapus Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = number_format($r->masuk_detail_qty, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->masuk_m->count_detail_all($masuk_id),
            "recordsFiltered" => $this->masuk_m->count_detail_filtered($masuk_id),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_masuk_list($masuk_id)
    {
        $List = $this->masuk_m->get_masuk_datatables($masuk_id);
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = number_format($r->masuk_detail_qty, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->masuk_m->count_masuk_all($masuk_id),
            "recordsFiltered" => $this->masuk_m->count_masuk_filtered($masuk_id),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function get_data_total_detail($masuk_id)
    {
        $data = $this->db->select_sum('masuk_detail_qty', 'total')->get_where('vivo_masuk_detail', array('masuk_id' => $masuk_id))->row();
        echo json_encode($data);
    }

    public function saveitemdetail()
    {
        $this->masuk_m->insert_data_detail();
    }

    public function get_data_detail($id)
    {
        $data = $this->db->get_where('v_masuk_detail', array('masuk_detail_id' => $id))->row();
        echo json_encode($data);
    }

    public function updateitemdetail()
    {
        $this->masuk_m->update_data_detail();
    }

    public function deleteitemdetail($id)
    {
        $this->masuk_m->delete_data_detail($id);
    }

    public function updatedata()
    {
        $this->masuk_m->update_data_masuk();
    }

    public function deletedata($id)
    {
        $this->masuk_m->delete_data_masuk($id);
    }

    public function printbukti($id)
    {
        $data['header']     = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['detail']     = $this->db->get_where('v_masuk', array('masuk_id' => $id))->row();
        $data['listDetail'] = $this->db->order_by('barang_kode', 'asc')->get_where('v_masuk_detail', array('masuk_id' => $id))->result();
        $this->load->view('admin/masuk/printbukti_v', $data);
    }

    public function detail($masuk_id)
    {
        $data['detail'] = $this->db->get_where('v_masuk', array('masuk_id' => $masuk_id))->row();
        $this->template->display('admin/masuk/detail', $data);
    }

    public function konfirmasi($masuk_id)
    {
        $username = $this->session->userdata('username');
        $data     = array(
            'masuk_tgl_terima' => date('Y-m-d'),
            'user_penerima'    => $username,
            'masuk_status'     => 'T',
            'masuk_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->where('masuk_id', $masuk_id);
        $this->db->update('vivo_masuk', $data);

        $listDetail = $this->db->get_where('vivo_masuk_detail', array('masuk_id' => $masuk_id))->result();
        foreach ($listDetail as $r) {
            $barang_id  = $r->barang_id;
            $qty        = $r->masuk_detail_qty;
            $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            $StokLama   = $dataBarang->barang_stok;
            $Stok       = ($StokLama + $qty);
            $dataStok   = array(
                'barang_stok'   => $Stok,
                'barang_update' => date('Y-m-d H:i:s'),
            );

            $this->db->where('barang_id', $barang_id);
            $this->db->update('vivo_barang', $dataStok);
        }
    }
}
/* Location: ./application/controller/admin/Masuk.php */
