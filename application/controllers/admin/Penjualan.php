<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        // $this->load->library("EscPos");
        $this->load->library('template');
        $this->load->model('admin/penjualan_m');
    }

    public function index()
    {
        $data['dataMeta']      = $this->db->get_where('vivo_meta', array('meta_id' => 1))->row();
        $data['Toko']          = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['listPelanggan'] = $this->db->order_by('pelanggan_nama', 'asc')->get('vivo_pelanggan')->result();
        $data['listTipe']      = $this->db->order_by('tipe_nama', 'asc')->get('vivo_tipe')->result();
        $data['listMeja']      = $this->db->order_by('meja_nama', 'asc')->get('vivo_meja')->result();
        $this->template->display('admin/penjualan/view', $data);
    }

    public function data_list()
    {
        $List = $this->penjualan_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row          = array();
            $penjualan_id = $r->penjualan_id;
            $link         = site_url('admin/penjualan/detail/' . $penjualan_id);
            $row[]        = '<a href="' . $link . '" title="Detail Data"><i class="icon-pencil"></i></a>
                             <a onclick="printNota(' . $penjualan_id . ')" title="Print Nota"><i class="icon-screen-tablet"></i></a>
                             <a onclick="printFaktur(' . $penjualan_id . ')" title="Print Nota"><i class="icon-printer"></i></a>';
            $row[]  = $no;
            $row[]  = $r->penjualan_no;
            $row[]  = date('d-m-Y', strtotime($r->penjualan_tanggal)) . ' ' . date('H:i', strtotime($r->penjualan_jam));
            $row[]  = $r->pelanggan_nama;
            $row[]  = $r->meja_nama;
            $row[]  = $r->user_name;
            $row[]  = number_format($r->penjualan_subtotal, 0, '', ',');
            $row[]  = number_format($r->penjualan_diskon, 0, '', ',');
            $row[]  = number_format($r->penjualan_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->penjualan_m->count_all(),
            "recordsFiltered" => $this->penjualan_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function adddata()
    {
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_penjualan_temp');

        $data['Toko']            = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['listMeja']        = $this->db->order_by('meja_nama', 'asc')->get('vivo_meja')->result();
        $data['detailPelanggan'] = $this->db->get_where('vivo_pelanggan', array('pelanggan_status' => 'Y'))->row();
        $data['listTipe']        = $this->db->order_by('tipe_nama', 'asc')->get('vivo_tipe')->result();
        $data['dataMeta']        = $this->db->get_where('vivo_meta', array('meta_id' => 1))->row();
        $this->template->display('admin/penjualan/add', $data);
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
        $this->penjualan_m->insert_data_pelanggan();
    }

    public function get_data_pelanggan($id)
    {
        $data = $this->db->get_where('vivo_pelanggan', array('pelanggan_id' => $id))->row();
        echo json_encode($data);
    }

    public function get_data_barang_by_kode($kode_barang)
    {
        $data = $this->db->get_where('v_barang', array('barang_kode' => trim(strtoupper($kode_barang))))->row();
        echo json_encode($data);
    }

    public function get_data_barang($id)
    {
        $data = $this->db->get_where('v_barang', array('barang_id' => $id))->row();
        echo json_encode($data);
    }

    public function data_temp_list()
    {
        $List = $this->penjualan_m->get_temp_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row               = array();
            $penjualan_temp_id = $r->penjualan_temp_id;
            $row[]             = '<a title="Edit Data" href="javascript:void(0)" onclick="editData(' . "'" . $penjualan_temp_id . "'" . ')"><i class="icon-pencil"></i></a>
                                    <a onclick="hapusData(' . $penjualan_temp_id . ')" title="Delete Data"><i class="icon-close"></i></a>';
            $row[]  = $no;
            $row[]  = $r->penjualan_temp_kode;
            $row[]  = $r->penjualan_temp_nama;
            $row[]  = number_format($r->penjualan_temp_qty, 0, '', ',');
            $row[]  = number_format($r->penjualan_temp_harga, 0, '', ',');
            $row[]  = number_format($r->penjualan_temp_disc, 2, '.', ',');
            $row[]  = number_format($r->penjualan_temp_subtotal, 0, '', ',');
            $row[]  = $r->penjualan_temp_keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->penjualan_m->count_temp_all(),
            "recordsFiltered" => $this->penjualan_m->count_temp_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_barang_list()
    {
        $List = $this->penjualan_m->get_barang_datatables();
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
            "recordsTotal"    => $this->penjualan_m->count_barang_all(),
            "recordsFiltered" => $this->penjualan_m->count_barang_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function data_pelanggan_list()
    {
        $List = $this->penjualan_m->get_pelanggan_datatables();
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
            "recordsTotal"    => $this->penjualan_m->count_pelanggan_all(),
            "recordsFiltered" => $this->penjualan_m->count_pelanggan_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function detail($penjualan_id)
    {
        $data['detail'] = $this->db->get_where('v_penjualan', array('penjualan_id' => $penjualan_id))->row();
        $this->template->display('admin/penjualan/edit', $data);
    }

    public function data_order_list($penjualan_id)
    {
        $List = $this->penjualan_m->get_order_datatables($penjualan_id);
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $r->penjualan_detail_kode;
            $row[]  = $r->penjualan_detail_nama;
            $row[]  = number_format($r->penjualan_detail_qty, 0, '', ',');
            $row[]  = number_format($r->penjualan_detail_harga, 0, '', ',');
            $row[]  = number_format($r->penjualan_detail_disc, 2, '.', ',');
            $row[]  = number_format($r->penjualan_detail_subtotal, 0, '', ',');
            $row[]  = $r->penjualan_detail_keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->penjualan_m->count_order_all($penjualan_id),
            "recordsFiltered" => $this->penjualan_m->count_order_filtered($penjualan_id),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function saveitem()
    {
        $this->penjualan_m->insert_data_item();
    }

    public function get_data_item($id)
    {
        $data = $this->db->get_where('vivo_penjualan_temp', array('penjualan_temp_id' => $id))->row();
        echo json_encode($data);
    }

    public function get_list_item($id)
    {
        $data = $this->db->get_where('v_penjualan_detail', array('penjualan_id' => $id))->result();
        echo json_encode($data);
    }

    public function updateitem()
    {
        $this->penjualan_m->update_data_item();
    }

    public function deleteitem($id)
    {
        $this->penjualan_m->delete_data_item($id);
    }

    public function get_data_total_temp()
    {
        $username = $this->session->userdata('username');
        $data     = $this->db->select_sum('penjualan_temp_subtotal', 'total')->get_where('vivo_penjualan_temp', array('user_username' => $username))->row();
        echo json_encode($data);
    }

    public function get_data_total($penjualan_id)
    {
        $data = $this->db->select_sum('order_detail_subtotal', 'total')->get_where('vivo_order_detail', array('penjualan_id' => $penjualan_id))->row();
        echo json_encode($data);
    }

    public function get_data_detail($order_detail_id)
    {
        $data = $this->db->get_where('v_order_detail', array('order_detail_id' => $order_detail_id))->row();
        echo json_encode($data);
    }

    public function get_data($penjualan_id)
    {
        $data = $this->db->get_where('v_penjualan', array('penjualan_id' => $penjualan_id))->row();
        echo json_encode($data);
    }

    public function savedata()
    {
        $bayar = intval(str_replace(",", "", $this->input->post('bayar', 'true')));
        $total = intval(str_replace(",", "", $this->input->post('bayar_total', 'true')));
        if ($bayar < $total) {
            $response = ['status' => 'error', 'message' => 'Pembayaran Kurang'];
        } else {
            $username     = $this->session->userdata('username');
            $noFaktur     = $this->penjualan_m->getNoFaktur($username);
            $pelanggan_id = $this->input->post('pelanggan_id', 'true');
            $meja_id      = $this->input->post('lstMeja', 'true');
            $netto        = (intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true'))) - intval(str_replace(",", "", $this->input->post('diskon', 'true'))));
            $data         = array(
                'meja_id'                 => $this->input->post('lstMeja', 'true'),
                'pelanggan_id'            => $this->input->post('pelanggan_id', 'true'),
                'tipe_id'                 => $this->input->post('lstTipe', 'true'),
                'penjualan_no'            => $noFaktur,
                'penjualan_nama'          => strtoupper(trim(stripHTMLtags($this->input->post('nama_pelanggan', 'true')))),
                'penjualan_tanggal'       => date('Y-m-d'),
                'penjualan_jam'           => date('H:i:s'),
                'penjualan_ppn'           => intval(str_replace(",", "", $this->input->post('bayar_ppn', 'true'))),
                'penjualan_ppn_rp'        => intval(str_replace(",", "", $this->input->post('ppn_rupiah', 'true'))),
                'penjualan_diskon'        => intval(str_replace(",", "", $this->input->post('diskon', 'true'))),
                'penjualan_diskon_persen' => str_replace(",", "", $this->input->post('discpersen', 'true')),
                'penjualan_subtotal'      => intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true'))),
                'penjualan_netto'         => $netto,
                'penjualan_total'         => intval(str_replace(",", "", $this->input->post('bayar_total', 'true'))),
                'penjualan_bayar'         => intval(str_replace(",", "", $this->input->post('bayar', 'true'))),
                'penjualan_kembali'       => intval(str_replace(",", "", $this->input->post('kembali', 'true'))),
                'penjualan_tukar_poin'    => intval(str_replace(",", "", $this->input->post('tukar_poin', 'true'))),
                'penjualan_tukar_poin_rp' => intval(str_replace(",", "", $this->input->post('tukar_poin_rp', 'true'))),
                'user_username'           => $username,
                'penjualan_update'        => date('Y-m-d H:i:s'),
            );

            $this->db->insert('vivo_penjualan', $data);
            $penjualan_id = $this->db->insert_id();
            // Simpan Detail Barang
            $listTemp = $this->db->get_where('vivo_penjualan_temp', array('user_username' => $username, 'pelanggan_id' => $pelanggan_id, 'meja_id' => $meja_id))->result();
            foreach ($listTemp as $r) {
                $dataItem = array(
                    'penjualan_id'                => $penjualan_id,
                    'barang_id'                   => $r->barang_id,
                    'penjualan_detail_kode'       => $r->penjualan_temp_kode,
                    'penjualan_detail_nama'       => $r->penjualan_temp_nama,
                    'penjualan_detail_harga'      => $r->penjualan_temp_harga,
                    'penjualan_detail_qty'        => $r->penjualan_temp_qty,
                    'penjualan_detail_ppn'        => $r->penjualan_temp_ppn,
                    'penjualan_detail_ppn_rp'     => $r->penjualan_temp_ppn_rp,
                    'penjualan_detail_disc'       => $r->penjualan_temp_disc,
                    'penjualan_detail_disc_rp'    => $r->penjualan_temp_disc_rp,
                    'penjualan_detail_subtotal'   => $r->penjualan_temp_subtotal,
                    'penjualan_detail_keterangan' => $r->penjualan_temp_keterangan,
                    'penjualan_detail_update'     => date('Y-m-d H:i:s'),
                );

                $this->db->insert('vivo_penjualan_detail', $dataItem);

                // Check Stok Barang
                $barang_id  = $r->barang_id;
                $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
                if ($dataBarang->barang_tipe == 'S') {
                    $StokLama = $dataBarang->barang_stok;
                    $Stok     = ($StokLama - $r->penjualan_temp_qty);
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
            $this->db->delete('vivo_penjualan_temp');
            $response = ['status' => 'success', 'id' => $penjualan_id];
            // $response['id'] = $penjualan_id;
        }

        echo json_encode($response);
    }

    public function printfaktur($penjualan_id)
    {
        $data['header']     = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $data['detail']     = $this->db->get_where('v_penjualan', array('penjualan_id' => $penjualan_id))->row();
        $data['listDetail'] = $this->db->order_by('penjualan_detail_kode', 'asc')->get_where('vivo_penjualan_detail', array('penjualan_id' => $penjualan_id))->result();
        $this->load->view('admin/penjualan/printfaktur_v', $data);
    }
}
/* Location: ./application/controller/admin/Penjualan.php */
