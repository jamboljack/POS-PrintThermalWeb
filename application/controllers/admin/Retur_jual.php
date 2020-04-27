<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur_jual extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/retur_jual_m');
    }

    public function index()
    {
        $data['Toko']          = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['listPelanggan'] = $this->db->order_by('pelanggan_nama', 'asc')->get('vivo_pelanggan')->result();
        $data['listTipe']      = $this->db->order_by('tipe_nama', 'asc')->get('vivo_tipe')->result();
        $data['listMeja']      = $this->db->order_by('meja_nama', 'asc')->get('vivo_meja')->result();
        $this->template->display('admin/retur_jual/view', $data);
    }

    public function data_list()
    {
        $List = $this->retur_jual_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row           = array();
            $retur_jual_id = $r->retur_jual_id;
            $link          = site_url('admin/retur_jual/detail/' . $retur_jual_id);
            $row[]         = '<a href="' . $link . '" title="Detail Data"><i class="icon-pencil"></i></a>
                             <a onclick="printNota(' . $retur_jual_id . ')" title="Print Nota"><i class="icon-printer"></i></a>';
            $row[]  = $no;
            $row[]  = $r->retur_jual_no;
            $row[]  = date('d-m-Y', strtotime($r->retur_jual_tanggal)) . ' ' . date('H:i', strtotime($r->retur_jual_jam));
            $row[]  = $r->pelanggan_nama;
            $row[]  = $r->meja_nama;
            $row[]  = $r->user_name;
            $row[]  = number_format($r->retur_jual_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->retur_jual_m->count_all(),
            "recordsFiltered" => $this->retur_jual_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function adddata()
    {
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_retur_jual_temp');

        $data['Toko']     = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['listMeja'] = $this->db->order_by('meja_nama', 'asc')->get('vivo_meja')->result();
        $data['listTipe'] = $this->db->order_by('tipe_nama', 'asc')->get('vivo_tipe')->result();
        $data['dataMeta'] = $this->db->get_where('vivo_meta', array('meta_id' => 1))->row();
        $this->template->display('admin/retur_jual/add', $data);
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

    public function savedatapelanggan()
    {
        $this->retur_jual_m->insert_data_pelanggan();
    }

    public function get_data_pelanggan($id)
    {
        $data = $this->db->get_where('vivo_pelanggan', array('pelanggan_id' => $id))->row();
        echo json_encode($data);
    }

    public function get_data_barang($id)
    {
        $data = $this->db->get_where('v_barang', array('barang_id' => $id))->row();
        echo json_encode($data);
    }

    public function data_temp_list()
    {
        $List = $this->retur_jual_m->get_temp_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row                = array();
            $retur_jual_temp_id = $r->retur_jual_temp_id;
            $row[]              = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $retur_jual_temp_id . "'" . ')"><i class="icon-pencil"></i></a>
                                    <a onclick="hapusData(' . $retur_jual_temp_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->retur_jual_temp_kode;
            $row[]  = $r->retur_jual_temp_nama;
            $row[]  = number_format($r->retur_jual_temp_qty, 0, '', ',');
            $row[]  = number_format($r->retur_jual_temp_harga, 0, '', ',');
            $row[]  = number_format($r->retur_jual_temp_disc, 2, '.', ',');
            $row[]  = number_format($r->retur_jual_temp_subtotal, 0, '', ',');
            $row[]  = $r->retur_jual_temp_keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->retur_jual_m->count_temp_all(),
            "recordsFiltered" => $this->retur_jual_m->count_temp_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_barang_list()
    {
        $List = $this->retur_jual_m->get_barang_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row       = array();
            $barang_id = $r->barang_id;
            $row[]     = '<a href="javascript:void(0)" title="Pilih" onclick="pilihData(' . "'" . $barang_id . "'" . ')" class="btn btn-primary btn-xs"><i class="fa fa-check-circle"></i> Pilih</a>';
            $row[]     = $no;
            $row[]     = $r->barang_kode;
            $row[]     = $r->barang_nama;
            $row[]     = $r->kategori_nama;
            $row[]     = number_format($r->barang_stok, 0, '', ',');
            $row[]     = number_format($r->barang_total, 0, '', ',');
            $data[]    = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->retur_jual_m->count_barang_all(),
            "recordsFiltered" => $this->retur_jual_m->count_barang_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_pelanggan_list()
    {
        $List = $this->retur_jual_m->get_pelanggan_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row          = array();
            $pelanggan_id = $r->pelanggan_id;
            $row[]        = '<a href="javascript:void(0)" title="Pilih" onclick="pilihPelanggan(' . "'" . $pelanggan_id . "'" . ')" class="btn btn-primary btn-xs"><i class="fa fa-check-circle"></i> Pilih</a>';
            $row[]        = $no;
            $row[]        = $r->pelanggan_nomor;
            $row[]        = $r->pelanggan_nama;
            $row[]        = $r->pelanggan_alamat;
            $row[]        = $r->pelanggan_kota;
            $row[]        = $r->pelanggan_telp;
            $data[]       = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->retur_jual_m->count_pelanggan_all(),
            "recordsFiltered" => $this->retur_jual_m->count_pelanggan_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function detail($retur_jual_id)
    {
        $data['detail'] = $this->db->get_where('v_retur_jual', array('retur_jual_id' => $retur_jual_id))->row();
        $this->template->display('admin/retur_jual/edit', $data);
    }

    public function data_order_list($retur_jual_id)
    {
        $List = $this->retur_jual_m->get_order_datatables($retur_jual_id);
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->retur_jual_detail_kode;
            $row[]  = $r->retur_jual_detail_nama;
            $row[]  = number_format($r->retur_jual_detail_qty, 0, '', ',');
            $row[]  = number_format($r->retur_jual_detail_harga, 0, '', ',');
            $row[]  = number_format($r->retur_jual_detail_disc, 2, '.', ',');
            $row[]  = number_format($r->retur_jual_detail_subtotal, 0, '', ',');
            $row[]  = $r->retur_jual_detail_keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->retur_jual_m->count_order_all($retur_jual_id),
            "recordsFiltered" => $this->retur_jual_m->count_order_filtered($retur_jual_id),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function saveitem()
    {
        $this->retur_jual_m->insert_data_item();
    }

    public function get_data_item($id)
    {
        $data = $this->db->get_where('vivo_retur_jual_temp', array('retur_jual_temp_id' => $id))->row();
        echo json_encode($data);
    }

    public function get_list_item($id)
    {
        $data = $this->db->get_where('v_retur_jual_detail', array('retur_jual_id' => $id))->result();
        echo json_encode($data);
    }

    public function updateitem()
    {
        $this->retur_jual_m->update_data_item();
    }

    public function deleteitem($id)
    {
        $this->retur_jual_m->delete_data_item($id);
    }

    public function get_data_total_temp()
    {
        $username = $this->session->userdata('username');
        $data     = $this->db->select_sum('retur_jual_temp_subtotal', 'total')->get_where('vivo_retur_jual_temp', array('user_username' => $username))->row();
        echo json_encode($data);
    }

    public function get_data_total($retur_jual_id)
    {
        $data = $this->db->select_sum('order_detail_subtotal', 'total')->get_where('vivo_order_detail', array('retur_jual_id' => $retur_jual_id))->row();
        echo json_encode($data);
    }

    public function get_data_detail($order_detail_id)
    {
        $data = $this->db->get_where('v_order_detail', array('order_detail_id' => $order_detail_id))->row();
        echo json_encode($data);
    }

    public function get_data($retur_jual_id)
    {
        $data = $this->db->get_where('v_retur_jual', array('retur_jual_id' => $retur_jual_id))->row();
        echo json_encode($data);
    }

    public function savedata()
    {
        $username     = $this->session->userdata('username');
        $noFaktur     = $this->retur_jual_m->getNoFaktur($username);
        $pelanggan_id = $this->input->post('pelanggan_id', 'true');
        $meja_id      = $this->input->post('lstMeja', 'true');
        $netto        = (intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true'))) - intval(str_replace(",", "", $this->input->post('diskon', 'true'))));
        $data         = array(
            'meja_id'             => $this->input->post('lstMeja', 'true'),
            'pelanggan_id'        => $this->input->post('pelanggan_id', 'true'),
            'tipe_id'             => $this->input->post('lstTipe', 'true'),
            'retur_jual_no'       => $noFaktur,
            'retur_jual_tanggal'  => date('Y-m-d'),
            'retur_jual_jam'      => date('H:i:s'),
            'retur_jual_subtotal' => intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true'))),
            'retur_jual_netto'    => $netto,
            'retur_jual_total'    => intval(str_replace(",", "", $this->input->post('bayar_total', 'true'))),
            'user_username'       => $username,
            'retur_jual_update'   => date('Y-m-d H:i:s'),
        );

        $this->db->insert('vivo_retur_jual', $data);
        $retur_jual_id = $this->db->insert_id();
        // Simpan Detail Barang
        $listTemp = $this->db->get_where('vivo_retur_jual_temp', array('user_username' => $username, 'pelanggan_id' => $pelanggan_id, 'meja_id' => $meja_id))->result();
        foreach ($listTemp as $r) {
            $dataItem = array(
                'retur_jual_id'                => $retur_jual_id,
                'barang_id'                    => $r->barang_id,
                'retur_jual_detail_kode'       => $r->retur_jual_temp_kode,
                'retur_jual_detail_nama'       => $r->retur_jual_temp_nama,
                'retur_jual_detail_harga'      => $r->retur_jual_temp_harga,
                'retur_jual_detail_qty'        => $r->retur_jual_temp_qty,
                'retur_jual_detail_ppn'        => $r->retur_jual_temp_ppn,
                'retur_jual_detail_ppn_rp'     => $r->retur_jual_temp_ppn_rp,
                'retur_jual_detail_disc'       => $r->retur_jual_temp_disc,
                'retur_jual_detail_disc_rp'    => $r->retur_jual_temp_disc_rp,
                'retur_jual_detail_subtotal'   => $r->retur_jual_temp_subtotal,
                'retur_jual_detail_keterangan' => $r->retur_jual_temp_keterangan,
                'retur_jual_detail_update'     => date('Y-m-d H:i:s'),
            );

            $this->db->insert('vivo_retur_jual_detail', $dataItem);

            // Check Stok Barang
            $barang_id  = $r->barang_id;
            $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            if ($dataBarang->barang_tipe == 'S') {
                $StokLama = $dataBarang->barang_stok;
                $Stok     = ($StokLama + $r->retur_jual_temp_qty);
                // Update Stok Utama
                $dataStok = array(
                    'barang_stok'   => $Stok,
                    'barang_update' => date('Y-m-d H:i:s'),
                );

                $this->db->where('barang_id', $barang_id);
                $this->db->update('vivo_barang', $dataStok);
            }
        }

        // Update Point Pelanggan
        $total_bayar   = intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true')));
        $dataMeta      = $this->db->get_where('vivo_meta', array('meta_id' => 1))->row();
        $Min_Order     = $dataMeta->meta_min_order;
        $dataPelanggan = $this->db->get_where('vivo_pelanggan', array('pelanggan_id' => $pelanggan_id))->row();
        if (count($dataPelanggan) > 0) {
            $tukarpoin  = $this->input->post('tukar_poin', 'true');
            $poinLama   = $dataPelanggan->pelanggan_poin;
            $KurangPoin = ($tukarpoin == 0 ? 0 : $tukarpoin);
            if ($Min_Order != 0) {
                $poinBaru = round($total_bayar / $Min_Order);
                $dataPoin = array(
                    'pelanggan_poin' => (($poinLama + $poinBaru) - $KurangPoin),
                );

                $this->db->where('pelanggan_id', $pelanggan_id);
                $this->db->update('vivo_pelanggan', $dataPoin);
            } else {
                $dataKurang = array(
                    'pelanggan_poin' => ($poinLama - $KurangPoin),
                );

                $this->db->where('pelanggan_id', $pelanggan_id);
                $this->db->update('vivo_pelanggan', $dataKurang);
            }
        }

        // Hapus Temp by Username
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_retur_jual_temp');
        $response['id'] = $retur_jual_id;
        echo json_encode($response);
    }

    public function printfaktur($retur_jual_id)
    {
        $data['header']     = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['detail']     = $this->db->get_where('v_retur_jual', array('retur_jual_id' => $retur_jual_id))->row();
        $data['listDetail'] = $this->db->order_by('retur_jual_detail_kode', 'asc')->get_where('vivo_retur_jual_detail', array('retur_jual_id' => $retur_jual_id))->result();
        $this->load->view('admin/retur_jual/printfaktur_v', $data);
    }
}
/* Location: ./application/controller/admin/Retur_jual.php */
