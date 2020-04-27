<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_jual_kategori extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
    }

    public function index()
    {
        $this->template->display('admin/reportjual/reportrekapkategori_v');
    }

    public function printdata()
    {
        $data['header']   = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['listData'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        $this->load->view('admin/reportjual/printrekapkategori_v', $data);
    }
}
/* Location: ./application/controller/admin/Lap_jual_kategori.php */
