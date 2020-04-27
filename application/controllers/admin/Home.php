<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/home_m');
    }

    public function index()
    {
        $data['TotalBarang']      = $this->db->get('vivo_barang')->result();
        $data['TotalPenjualan'] = $this->db->get('vivo_penjualan')->result();
        $data['TotalIncome']    = $this->db->select_sum('penjualan_total', 'total')->get('vivo_penjualan')->row();
        $this->template->display('admin/home_v', $data);
    }
}
/* Location: ./application/controller/admin/Home.php */
