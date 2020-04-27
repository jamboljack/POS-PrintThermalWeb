<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Info extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/info_m');
    }

    public function index()
    {
        $data['listKategori'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        $this->template->display('admin/barang/info_v', $data);
    }

    public function data_list()
    {
        $List = $this->info_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row   = array();
            $row[] = $no;
            if ($r->barang_foto == '') {
                $foto = '<img src="' . base_url('img/no-image.png') . '" width="150px" height="100px">';
            } else {
                $foto = '<img src="' . base_url('img/barang_folder/thumbs/' . $r->barang_foto . '" width="100px" height="100px">');
            }
            $row[]  = $foto;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = ($r->barang_tipe == 'S' ? '<span class="label label-success">STOCK</span>' : '<span class="label label-danger">NON STOCK</span>');
            $row[]  = number_format($r->barang_ppn, 2, '.', ',');
            $row[]  = number_format($r->barang_stok, 0, '', ',');
            $row[]  = number_format($r->barang_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->info_m->count_all(),
            "recordsFiltered" => $this->info_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }
}
/* Location: ./application/controller/admin/Info.php */
