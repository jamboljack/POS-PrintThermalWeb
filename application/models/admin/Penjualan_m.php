<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_m extends CI_Model
{
    public $table        = 'v_penjualan';
    public $column_order = array(null, null, 'penjualan_no', 'penjualan_tanggal', 'pelanggan_nama', 'meja_nama', 'user_name',
        'penjualan_subtotal', 'penjualan_diskon', 'penjualan_total');
    public $column_search = array('penjualan_no', 'penjualan_tanggal', 'pelanggan_nama', 'meja_nama', 'user_name');
    public $order         = array('penjualan_no' => 'desc');

    public $table1         = 'v_barang';
    public $column_order1  = array(null, null, 'barang_kode', 'barang_nama', 'kategori_nama', 'barang_stok', 'barang_total');
    public $column_search1 = array('barang_kode', 'barang_nama', 'kategori_nama');
    public $order1         = array('barang_nama' => 'asc');

    public $table2         = 'vivo_penjualan_detail';
    public $column_order2  = array(null, null, null, null, null, null, null, null);
    public $column_search2 = array();
    public $order2         = array('penjualan_detail_kode' => 'asc');

    public $table3        = 'vivo_pelanggan';
    public $column_order3 = array(null, null, 'pelanggan_nomor', 'pelanggan_nama', 'pelanggan_alamat', 'pelanggan_kota',
        'pelanggan_telp');
    public $column_search3 = array('pelanggan_nomor', 'pelanggan_nama', 'pelanggan_alamat', 'pelanggan_kota', 'pelanggan_telp');
    public $order3         = array('pelanggan_nama' => 'asc');

    public $table4         = 'vivo_penjualan_temp';
    public $column_order4  = array(null, null, null, null, null, null, null, null, null);
    public $column_search4 = array();
    public $order4         = array('penjualan_temp_kode' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        if ($this->input->post('tgl_dari', 'true')) {
            $tgl_dari = date('Y-m-d', strtotime($this->input->post('tgl_dari', 'true')));
            $this->db->where('penjualan_tanggal >=', $tgl_dari);
        }
        if ($this->input->post('tgl_sampai', 'true')) {
            $tgl_sampai = date('Y-m-d', strtotime($this->input->post('tgl_sampai', 'true')));
            $this->db->where('penjualan_tanggal <=', $tgl_sampai);
        }
        if ($this->input->post('lstPelanggan', 'true')) {
            $this->db->where('pelanggan_id', $this->input->post('lstPelanggan', 'true'));
        }
        if ($this->input->post('lstMeja', 'true')) {
            $this->db->where('meja_id', $this->input->post('lstMeja', 'true'));
        }
        if ($this->input->post('lstTipe', 'true')) {
            $this->db->where('tipe_id', $this->input->post('lstTipe', 'true'));
        }
        if ($this->input->post('lstStatus', 'true')) {
            $this->db->where('penjualan_status', $this->input->post('lstStatus', 'true'));
        }

        $this->db->from($this->table);

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function delete_data($id)
    {
        $this->db->where('penjualan_id', $id);
        $this->db->delete('vivo_order');
    }

    private function _get_barang_datatables_query()
    {
        $this->db->from($this->table1);

        $i = 0;
        foreach ($this->column_search1 as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search1) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order = $this->order1;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_barang_datatables()
    {
        $this->_get_barang_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_barang_filtered()
    {
        $this->_get_barang_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_barang_all()
    {
        $this->db->from($this->table1);
        return $this->db->count_all_results();
    }

    // Pelanggan
    private function _get_pelanggan_datatables_query()
    {
        $this->db->from($this->table3);

        $i = 0;
        foreach ($this->column_search3 as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search3) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order3)) {
            $order = $this->order3;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_pelanggan_datatables()
    {
        $this->_get_pelanggan_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_pelanggan_filtered()
    {
        $this->_get_pelanggan_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_pelanggan_all()
    {
        $this->db->from($this->table3);
        return $this->db->count_all_results();
    }

    public function insert_data_pelanggan()
    {
        $data = array(
            'pelanggan_nomor'   => strtoupper(trim(stripHTMLtags($this->input->post('nomor', 'true')))),
            'pelanggan_nama'    => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
            'pelanggan_alamat'  => strtoupper(trim(stripHTMLtags($this->input->post('alamat_pelanggan', 'true')))),
            'pelanggan_kota'    => strtoupper(trim(stripHTMLtags($this->input->post('kota', 'true')))),
            'pelanggan_telp'    => strtoupper(trim(stripHTMLtags($this->input->post('telp', 'true')))),
            'pelanggan_disc'    => $this->input->post('disc_plg', 'true'),
            'pelanggan_expired' => date('Y-m-d', strtotime($this->input->post('tgl_expired', 'true'))),
            'pelanggan_update'  => date('Y-m-d H:i:s'),
        );

        $this->db->insert('vivo_pelanggan', $data);
    }

    private function _get_temp_datatables_query()
    {
        $username = $this->session->userdata('username');
        $this->db->from($this->table4);
        $this->db->where('user_username', $username);

        $i = 0;
        foreach ($this->column_search4 as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search4) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order4)) {
            $order = $this->order4;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_temp_datatables()
    {
        $this->_get_temp_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_temp_filtered()
    {
        $this->_get_temp_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_temp_all()
    {
        $username = $this->session->userdata('username');
        $this->db->from($this->table4);
        $this->db->where('user_username', $username);

        return $this->db->count_all_results();
    }

    private function _get_order_datatables_query($penjualan_id)
    {
        $this->db->from($this->table2);
        $this->db->where('penjualan_id', $penjualan_id);

        $i = 0;
        foreach ($this->column_search2 as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search2) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order2)) {
            $order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_order_datatables($penjualan_id)
    {
        $this->_get_order_datatables_query($penjualan_id);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_order_filtered($penjualan_id)
    {
        $this->_get_order_datatables_query($penjualan_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_order_all($penjualan_id)
    {
        $this->db->from($this->table2);
        $this->db->where('penjualan_id', $penjualan_id);

        return $this->db->count_all_results();
    }

    public function insert_data_item()
    {
        $username     = $this->session->userdata('username');
        $pelanggan_id = $this->input->post('pelanggan_id', 'true');
        $barang_id    = $this->input->post('barang_id', 'true');
        $checkData    = $this->db->get_where('vivo_penjualan_temp', array('barang_id' => $barang_id, 'pelanggan_id' => $pelanggan_id, 'user_username' => $username))->row();
        $dataBarang   = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
        // if (count($checkData) == 0) {
        $data = array(
            'pelanggan_id'              => $pelanggan_id,
            'meja_id'                   => $this->input->post('lstMeja', 'true'),
            'barang_id'                 => $barang_id,
            'penjualan_temp_kode'       => $dataBarang->barang_kode,
            'penjualan_temp_nama'       => $dataBarang->barang_nama,
            'penjualan_temp_harga'      => str_replace(",", "", $this->input->post('harga', 'true')),
            'penjualan_temp_ppn'        => $dataBarang->barang_ppn,
            'penjualan_temp_ppn_rp'     => $dataBarang->barang_ppn_rp,
            'penjualan_temp_qty'        => intval(str_replace(",", "", $this->input->post('qty', 'true'))),
            'penjualan_temp_disc'       => $this->input->post('disc', 'true'),
            'penjualan_temp_disc_rp'    => $this->input->post('disc_rupiah', 'true'),
            'penjualan_temp_subtotal'   => intval(str_replace(",", "", $this->input->post('total', 'true'))),
            'penjualan_temp_keterangan' => strtoupper($this->input->post('keterangan', 'true')),
            'user_username'             => $username,
            'penjualan_temp_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->insert('vivo_penjualan_temp', $data);
        // } else {
        //     $harga    = intval(str_replace(",", "", $this->input->post('harga', 'true')));
        //     $jumlah   = intval(str_replace(",", "", $this->input->post('qty', 'true')));
        //     $discbaru = $this->input->post('disc', 'true');
        //     $qty      = ($checkData->penjualan_temp_qty + $jumlah);
        //     $disc     = ($checkData->penjualan_temp_disc + $discbaru);
        //     $discrp   = ((($harga * $qty) * $disc) / 100);
        //     $total    = (($harga * $qty) - $discrp);
        //     $data     = array(
        //         'penjualan_temp_harga'    => intval(str_replace(",", "", $this->input->post('harga', 'true'))),
        //         'penjualan_temp_qty'      => $qty,
        //         'penjualan_temp_disc'     => $disc,
        //         'penjualan_temp_disc_rp'  => $discrp,
        //         'penjualan_temp_subtotal' => $total,
        //     );

        //     $this->db->where('pelanggan_id', $pelanggan_id);
        //     $this->db->where('barang_id', $barang_id);
        //     $this->db->update('vivo_penjualan_temp', $data);
        // }
    }

    public function update_data_item()
    {
        $username          = $this->session->userdata('username');
        $penjualan_temp_id = $this->input->post('penjualan_temp_id', 'true');
        $barang_id         = $this->input->post('barang_id', 'true');
        $dataBarang        = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
        $data              = array(
            'barang_id'                 => $barang_id,
            'penjualan_temp_kode'       => $dataBarang->barang_kode,
            'penjualan_temp_nama'       => $dataBarang->barang_nama,
            'penjualan_temp_harga'      => str_replace(",", "", $this->input->post('harga', 'true')),
            'penjualan_temp_ppn'        => $dataBarang->barang_ppn,
            'penjualan_temp_ppn_rp'     => $dataBarang->barang_ppn_rp,
            'penjualan_temp_qty'        => intval(str_replace(",", "", $this->input->post('qty', 'true'))),
            'penjualan_temp_disc'       => $this->input->post('disc', 'true'),
            'penjualan_temp_disc_rp'    => $this->input->post('disc_rupiah', 'true'),
            'penjualan_temp_subtotal'   => intval(str_replace(",", "", $this->input->post('total', 'true'))),
            'penjualan_temp_keterangan' => strtoupper($this->input->post('keterangan', 'true')),
            'user_username'             => $username,
            'penjualan_temp_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->where('penjualan_temp_id', $penjualan_temp_id);
        $this->db->update('vivo_penjualan_temp', $data);
    }

    public function delete_data_item($id)
    {
        $this->db->where('penjualan_temp_id', $id);
        $this->db->delete('vivo_penjualan_temp');
    }

    public function getNoFaktur($username)
    {
        $this->db->select('RIGHT(penjualan_no, 5) as kode', false);
        $this->db->where('penjualan_tanggal', date('Y-m-d'));
        $this->db->where('user_username', $username);
        $this->db->order_by('penjualan_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('vivo_penjualan');
        if ($query->num_rows() != 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }

        $nourut = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $NoJual = strtoupper(substr($username, 0, 3)) . '-' . date('Ymd') . '-' . $nourut;
        return $NoJual;
    }

    public function insert_data_penjualan()
    {
        $username     = $this->session->userdata('username');
        $noFaktur     = $this->getNoFaktur($username);
        $pelanggan_id = $this->input->post('pelanggan_id', 'true');
        $meja_id      = $this->input->post('lstMeja', 'true');
        $netto        = (intval(str_replace(",", "", $this->input->post('bayar_subtotal', 'true'))) - intval(str_replace(",", "", $this->input->post('diskon', 'true'))));
        $data         = array(
            'meja_id'                 => $this->input->post('lstMeja', 'true'),
            'pelanggan_id'            => $this->input->post('pelanggan_id', 'true'),
            'penjualan_no'            => $noFaktur,
            'penjualan_tanggal'       => date('Y-m-d'),
            'penjualan_nama'          => strtoupper(trim(stripHTMLtags($this->input->post('nama_pelanggan', 'true')))),
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

        // Cetak Nota Kecil
        for ($i = 1; $i <= 2; $i++) {
            $this->cetaknotabayar($penjualan_id);
        }

        // Cetak untuk CO
        $this->cetaknotacheck($penjualan_id);
    }

    public function cetaknotabayar($penjualan_id)
    {
        $dataToko      = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $dataPenjualan = $this->db->get_where('v_penjualan', array('penjualan_id' => $penjualan_id))->row();
        $listItem      = $this->db->get_where('vivo_penjualan_detail', array('penjualan_id' => $penjualan_id))->result();
        $tmpdir        = sys_get_temp_dir();
        $file          = tempnam($tmpdir, 'cetak');
        $handle        = fopen($file, 'w');
        $bold0         = Chr(27) . Chr(69);
        $bold1         = Chr(27) . Chr(70);
        $initialized   = chr(27) . chr(64);
        $leftMargin    = chr(27) . chr(108) . chr(1);
        $condensed     = Chr(27) . Chr(33) . Chr(4);
        $draft         = Chr(27) . Chr(120);
        $Data          = $initialized;
        $Data .= $leftMargin;
        $Data .= $draft;
        $NamaToko      = trim($dataToko->contact_name);
        $AlamatToko    = trim($dataToko->contact_address);
        $TelpToko      = trim($dataToko->contact_phone);
        $NoOrder       = trim($dataPenjualan->penjualan_no);
        $NamaPelanggan = trim($dataPenjualan->pelanggan_nama);
        $Tanggal       = date('d-m-Y', strtotime($dataPenjualan->penjualan_tanggal));
        $Kasir         = trim($dataPenjualan->user_username);
        $Data .= $this->addHeader($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $NamaPelanggan, $Kasir);
        foreach ($listItem as $r) {
            $NamaBarang = trim($r->penjualan_detail_nama);
            $Harga      = number_format($r->penjualan_detail_harga, 0, '', ',');
            $Qty        = number_format($r->penjualan_detail_qty, 0, '', ',');
            $Subtotal   = number_format($r->penjualan_detail_subtotal, 0, '', ',');
            $Data .= $this->addItem($NamaBarang, $Harga, $Qty, $Subtotal);
        }
        $SubTotal   = number_format($dataPenjualan->penjualan_subtotal, 0, '', ',');
        $Diskon     = number_format($dataPenjualan->penjualan_diskon, 0, '', ',');
        $DiskonPOIN = number_format($dataPenjualan->penjualan_tukar_poin_rp, 0, '', ',');
        $Total      = number_format($dataPenjualan->penjualan_total, 0, '', ',');
        $Data .= $this->addFooter($SubTotal, $Diskon, $DiskonPOIN, $Total);
        fwrite($handle, $Data);
        fclose($handle);
        $printer        = $this->db->get_where('vivo_printer', array('printer_tipe' => 'Nota'))->row();
        $lokasi_printer = $printer->printer_lokasi;
        copy($file, $lokasi_printer);
        unlink($file);

        // $time        = time();
        // $filename    = "Nota_" . $time;
        // $pdfFilePath = FCPATH . "/download/$filename.txt";
        // copy($file, $pdfFilePath);
    }

    public function cetaknotacheck($penjualan_id)
    {
        $dataToko      = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        $dataPenjualan = $this->db->get_where('v_penjualan', array('penjualan_id' => $penjualan_id))->row();
        $listItem      = $this->db->get_where('vivo_penjualan_detail', array('penjualan_id' => $penjualan_id))->result();
        $tmpdir        = sys_get_temp_dir();
        $file          = tempnam($tmpdir, 'cetak');
        $handle        = fopen($file, 'w');
        $bold0         = Chr(27) . Chr(69);
        $bold1         = Chr(27) . Chr(70);
        $initialized   = chr(27) . chr(64);
        $leftMargin    = chr(27) . chr(108) . chr(1);
        $condensed     = Chr(27) . Chr(33) . Chr(4);
        $draft         = Chr(27) . Chr(120);
        $Data          = $initialized;
        $Data .= $leftMargin;
        $Data .= $draft;
        $NamaToko      = trim($dataToko->contact_name);
        $AlamatToko    = trim($dataToko->contact_address);
        $TelpToko      = trim($dataToko->contact_phone);
        $NoOrder       = trim($dataPenjualan->penjualan_no);
        $NamaPelanggan = trim($dataPenjualan->pelanggan_nama);
        $Tanggal       = date('d-m-Y', strtotime($dataPenjualan->penjualan_tanggal));
        $Kasir         = trim($dataPenjualan->user_username);
        $Data .= $this->addHeaderCheck($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $NamaPelanggan, $Kasir);
        foreach ($listItem as $r) {
            $NamaBarang = trim($r->penjualan_detail_nama);
            $Qty        = number_format($r->penjualan_detail_qty, 0, '', ',');
            $Keterangan = trim($r->penjualan_detail_keterangan);
            $Data .= $this->addItemCheck($NamaBarang, $Qty, $Keterangan);
        }
        fwrite($handle, $Data);
        fclose($handle);
        $printer        = $this->db->get_where('vivo_printer', array('printer_tipe' => 'Nota'))->row();
        $lokasi_printer = $printer->printer_lokasi;
        copy($file, $lokasi_printer);
        unlink($file);
        // $time        = time();
        // $filename    = "Nota_Check_" . $time;
        // $pdfFilePath = FCPATH . "/download/$filename.txt";
        // copy($file, $pdfFilePath);
    }

    public function addHeader($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $NamaPelanggan, $Kasir)
    {
        $returnValue  = "";
        $limitHeader  = 20;
        $txtToko      = "";
        $txtAlamat    = "";
        $txtTelp      = "";
        $txtPelanggan = "";

        if (strlen($NamaToko) <= $limitHeader) {
            $txtToko = str_pad($NamaToko, $limitHeader);
        } else {
            $txtToko = substr($NamaToko, 0, $limitHeader);
        }

        if (strlen($AlamatToko) <= $limitHeader) {
            $txtAlamat = str_pad($AlamatToko, $limitHeader);
        } else {
            $txtAlamat = substr($AlamatToko, 0, $limitHeader);
        }

        if (strlen($TelpToko) <= $limitHeader) {
            $txtTelp = str_pad($TelpToko, $limitHeader);
        } else {
            $txtTelp = substr($TelpToko, 0, $limitHeader);
        }
        if (strlen($NamaPelanggan) <= $limitHeader) {
            $txtPelanggan = str_pad($NamaPelanggan, $limitHeader);
        } else {
            $txtPelanggan = substr($NamaPelanggan, 0, $limitHeader);
        }
        $returnValue .= "" . chr(10);
        $returnValue .= "Toko      : " . $txtToko . chr(10);
        $returnValue .= "Alamat    : " . $txtAlamat . chr(10);
        $returnValue .= "No  Telp  : " . $txtTelp . chr(10);
        $returnValue .= "No  Order : " . $NoOrder . chr(10);
        $returnValue .= "Tanggal   : " . $Tanggal . chr(10);
        $returnValue .= "Pelanggan : " . $txtPelanggan . chr(10);
        $returnValue .= "Kasir     : " . $Kasir . chr(10);
        $returnValue .= "================================" . chr(10);
        $returnValue .= "Nama Barang   Harga Qty Subtotal" . chr(10);
        $returnValue .= "================================" . chr(10);
        return $returnValue;
    }

    public function addHeaderCheck($NamaToko, $AlamatToko, $TelpToko, $NoOrder, $Tanggal, $NamaPelanggan, $Kasir)
    {
        $returnValue  = "";
        $limitHeader  = 20;
        $txtToko      = "";
        $txtAlamat    = "";
        $txtTelp      = "";
        $txtPelanggan = "";

        if (strlen($NamaToko) <= $limitHeader) {
            $txtToko = str_pad($NamaToko, $limitHeader);
        } else {
            $txtToko = substr($NamaToko, 0, $limitHeader);
        }

        if (strlen($AlamatToko) <= $limitHeader) {
            $txtAlamat = str_pad($AlamatToko, $limitHeader);
        } else {
            $txtAlamat = substr($AlamatToko, 0, $limitHeader);
        }

        if (strlen($TelpToko) <= $limitHeader) {
            $txtTelp = str_pad($TelpToko, $limitHeader);
        } else {
            $txtTelp = substr($TelpToko, 0, $limitHeader);
        }
        if (strlen($NamaPelanggan) <= $limitHeader) {
            $txtPelanggan = str_pad($NamaPelanggan, $limitHeader);
        } else {
            $txtPelanggan = substr($NamaPelanggan, 0, $limitHeader);
        }
        $returnValue .= "" . chr(10);
        $returnValue .= "Toko      : " . $txtToko . chr(10);
        $returnValue .= "Alamat    : " . $txtAlamat . chr(10);
        $returnValue .= "No  Telp  : " . $txtTelp . chr(10);
        $returnValue .= "No  Order : " . $NoOrder . chr(10);
        $returnValue .= "Tanggal   : " . $Tanggal . chr(10);
        $returnValue .= "Pelanggan : " . $txtPelanggan . chr(10);
        $returnValue .= "Kasir     : " . $Kasir . chr(10);
        $returnValue .= "================================" . chr(10);
        $returnValue .= "Nama Barang       Qty  Ket.     " . chr(10);
        $returnValue .= "================================" . chr(10);
        return $returnValue;
    }

    public function addItem($NamaBarang, $Harga, $Qty, $Subtotal)
    {
        // LimitCharacter
        $limitNamaBarang = 11;
        $limitHarga      = 7;
        $limitQty        = 3;
        // $limitDisc     = 4;
        $limitSubtotal = 9;
        // Variabel
        $txtNamaBarang = "";
        $txtHarga      = 0;
        $txtQty        = 0;
        // $txtDisc     = 0.00;
        $txtSubtotal = 0;

        // Nama Menu
        if (strlen($NamaBarang) <= $limitNamaBarang) {
            $txtNamaBarang = str_pad($NamaBarang, $limitNamaBarang);
        } else {
            $txtNamaBarang = substr($NamaBarang, 0, $limitNamaBarang);
        }

        // Harga
        if (strlen($Harga) <= $limitHarga) {
            $txtHarga = str_pad($Harga, $limitHarga, " ", STR_PAD_LEFT);
        } else {
            $txtHarga = substr($Harga, 0, $limitHarga);
        }

        // Qty
        if (strlen($Qty) <= $limitQty) {
            $txtQty = str_pad($Qty, $limitQty, " ", STR_PAD_LEFT);
        } else {
            $txtQty = substr($Qty, 0, $limitQty);
        }

        // Disc
        // if (strlen($Disc) <= $limitDisc) {
        //     $txtDisc = str_pad($Disc, $limitDisc, " ", STR_PAD_LEFT);
        // } else {
        //     $txtDisc = substr($Disc, 0, $limitDisc);
        // }

        // Subtotal
        if (strlen($Subtotal) <= $limitSubtotal) {
            $txtSubtotal = str_pad($Subtotal, $limitSubtotal, " ", STR_PAD_LEFT);
        } else {
            $txtSubtotal = substr($Subtotal, 0, $limitSubtotal);
        }

        $returnValue = "" . $txtNamaBarang . " " . $txtHarga . " " . $txtQty . "" . $txtSubtotal . chr(10);
        return $returnValue;
    }

    public function addItemCheck($NamaBarang, $Qty, $Keterangan)
    {
        // LimitCharacter
        $limitNamaBarang = 18;
        $limitQty        = 3;
        $limitKet        = 9;
        // Variabel
        $txtNamaBarang = "";
        $txtQty        = 0;
        $txtKet        = 0;

        // Nama Menu
        if (strlen($NamaBarang) <= $limitNamaBarang) {
            $txtNamaBarang = str_pad($NamaBarang, $limitNamaBarang);
        } else {
            $txtNamaBarang = substr($NamaBarang, 0, $limitNamaBarang);
        }

        // Qty
        if (strlen($Qty) <= $limitQty) {
            $txtQty = str_pad($Qty, $limitQty, " ", STR_PAD_LEFT);
        } else {
            $txtQty = substr($Qty, 0, $limitQty);
        }

        if (strlen($Keterangan) <= $limitKet) {
            $txtKet = str_pad($Keterangan, $limitKet);
        } else {
            $txtKet = substr($Keterangan, 0, $limitKet);
        }

        $returnValue = "" . $txtNamaBarang . " " . $txtQty . " " . $txtKet . chr(10);
        return $returnValue;
    }

    public function addFooter($SubTotal, $Diskon, $DiskonPOIN, $Total)
    {
        // LimitCharacter
        $limitNominal = 9;
        // Variabel
        $txtSubTotal   = 0;
        $txtDiskon     = 0;
        $txtDiskonPOIN = 0;
        $txtTotal      = 0;

        // Sub Total
        if (strlen($SubTotal) <= $limitNominal) {
            $txtSubTotal = str_pad($SubTotal, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtSubTotal = substr($SubTotal, 0, $limitNominal);
        }

        // Diskon
        if (strlen($Diskon) <= $limitNominal) {
            $txtDiskon = str_pad($Diskon, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtDiskon = substr($Diskon, 0, $limitNominal);
        }

        // Diskon POIN
        if (strlen($DiskonPOIN) <= $limitNominal) {
            $txtDiskonPOIN = str_pad($DiskonPOIN, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtDiskonPOIN = substr($DiskonPOIN, 0, $limitNominal);
        }

        // Total
        if (strlen($Total) <= $limitNominal) {
            $txtTotal = str_pad($Total, $limitNominal, " ", STR_PAD_LEFT);
        } else {
            $txtTotal = substr($Total, 0, $limitNominal);
        }

        $returnValue = "" . chr(10);
        $returnValue .= "           Sub Total : " . $txtSubTotal . chr(10);
        $returnValue .= "              Diskon : " . $txtDiskon . chr(10);
        $returnValue .= "         Diskon POIN : " . $txtDiskonPOIN . chr(10);
        $returnValue .= "               TOTAL : " . $txtTotal . chr(10);
        $returnValue .= "--------------------------------" . chr(10);
        $returnValue .= "Terima Kasih atas kunjungan Anda" . chr(10);
        $returnValue .= "" . chr(10);
        $returnValue .= "" . chr(10);
        return $returnValue;
    }
}
/* Location: ./application/models/admin/Penjualan_m.php */
