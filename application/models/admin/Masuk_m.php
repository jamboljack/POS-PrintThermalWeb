<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk_m extends CI_Model
{
    public $table        = 'v_masuk';
    public $column_order = array(null, null, 'masuk_nomor', 'masuk_tanggal', 'masuk_keterangan', 'user_name', 'penerima',
        'masuk_tgl_terima', 'masuk_status');
    public $column_search = array('masuk_nomor', 'masuk_tanggal', 'masuk_keterangan', 'user_name', 'penerima');
    public $order         = array('masuk_tanggal' => 'desc');

    public $table1         = 'v_masuk_temp';
    public $column_order1  = array(null, null, null, null, null, null);
    public $column_search1 = array();
    public $order1         = array('barang_nama' => 'asc');

    public $table2         = 'v_barang';
    public $column_order2  = array(null, null, 'barang_kode', 'barang_nama', 'kategori_nama', 'barang_stok');
    public $column_search2 = array('barang_kode', 'barang_nama', 'kategori_nama', 'barang_stok');
    public $order2         = array('barang_kode' => 'asc');

    public $table3         = 'v_masuk_detail';
    public $column_order3  = array(null, null, null, null, null, null);
    public $column_search3 = array();
    public $order3         = array('masuk_detail_id' => 'asc');

    public $table4         = 'v_masuk_detail';
    public $column_order4  = array(null, null, null, null, null);
    public $column_search4 = array();
    public $order4         = array('masuk_detail_id' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        if ($this->input->post('tgl_dari', 'true')) {
            $tgl_dari = date('Y-m-d', strtotime($this->input->post('tgl_dari', 'true')));
            $this->db->where('masuk_tanggal >=', $tgl_dari);
        }
        if ($this->input->post('tgl_sampai', 'true')) {
            $tgl_sampai = date('Y-m-d', strtotime($this->input->post('tgl_sampai', 'true')));
            $this->db->where('masuk_tanggal <=', $tgl_sampai);
        }
        if ($this->input->post('lstStatus', 'true')) {
            $this->db->where('masuk_status', $this->input->post('lstStatus', 'true'));
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

    // Temporary
    private function _get_temp_datatables_query()
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
        $this->db->from($this->table1);
        return $this->db->count_all_results();
    }

    // Barang
    private function _get_barang_datatables_query()
    {
        $this->db->from($this->table2);
        $this->db->where('barang_tipe', 'S');

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
        $this->db->from($this->table2);
        $this->db->where('barang_tipe', 'S');

        return $this->db->count_all_results();
    }

    public function insert_data_item()
    {
        $username  = $this->session->userdata('username');
        $no_bukti  = $this->input->post('no_bukti', 'true');
        $barang_id = $this->input->post('barang_id', 'true');
        $checkData = $this->db->get_where('vivo_masuk_temp', array('barang_id' => $barang_id, 'masuk_temp_bukti' => $no_bukti, 'user_username' => $username))->row();
        if (count($checkData) == 0) {
            $data = array(
                'masuk_temp_bukti'   => trim(stripHTMLtags($this->input->post('no_bukti', 'true'))),
                'masuk_temp_tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal', 'true'))),
                'barang_id'          => $this->input->post('barang_id', 'true'),
                'masuk_temp_qty'     => intval(str_replace(",", "", $this->input->post('qty', 'true'))),
                'user_username'      => $username,
                'masuk_temp_update'  => date('Y-m-d H:i:s'),
            );

            $this->db->insert('vivo_masuk_temp', $data);
        } else {
            $jumlah = intval(str_replace(",", "", $this->input->post('qty', 'true')));
            $qty    = ($checkData->masuk_temp_qty + $jumlah);
            $data   = array(
                'masuk_temp_qty' => $qty,
            );

            $this->db->where('masuk_temp_bukti', $no_bukti);
            $this->db->where('barang_id', $barang_id);
            $this->db->update('vivo_masuk_temp', $data);
        }
    }

    public function update_data_item()
    {
        $username      = $this->session->userdata('username');
        $masuk_temp_id = $this->input->post('masuk_temp_id', 'true');
        $data          = array(
            'barang_id'         => $this->input->post('barang_id', 'true'),
            'masuk_temp_qty'    => intval(str_replace(",", "", $this->input->post('qty', 'true'))),
            'user_username'     => $username,
            'masuk_temp_update' => date('Y-m-d H:i:s'),
        );

        $this->db->where('masuk_temp_id', $masuk_temp_id);
        $this->db->update('vivo_masuk_temp', $data);
    }

    public function delete_data_item($id)
    {
        $this->db->where('masuk_temp_id', $id);
        $this->db->delete('vivo_masuk_temp');
    }

    public function getNoMasuk()
    {
        $this->db->select('COUNT(masuk_id) as total', false);
        $this->db->where('YEAR(masuk_tanggal)', date('Y'));
        $query = $this->db->get('vivo_masuk');
        if ($query->num_rows() != 0) {
            $data = $query->row();
            $kode = intval($data->total) + 1;
        } else {
            $kode = 1;
        }

        $NoUrut = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $NoMSK  = $NoUrut . '/MASUK/' . date('Y');
        return $NoMSK;
    }

    public function insert_data_masuk()
    {
        $username = $this->session->userdata('username');
        $NoStok   = $this->getNoMasuk();
        $data     = array(
            'masuk_nomor'      => $NoStok,
            'masuk_tanggal'    => date('Y-m-d'),
            'masuk_keterangan' => strtoupper(stripHTMLtags($this->input->post('keterangan', 'true'))),
            'user_username'    => $username,
            'masuk_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->insert('vivo_masuk', $data);
        $masuk_id = $this->db->insert_id();

        // Simpan Detail Barang
        $tanggal  = date('Y-m-d', strtotime($this->input->post('tanggal', 'true')));
        $listTemp = $this->db->get_where('v_masuk_temp', array('user_username' => $username, 'masuk_temp_tanggal' => $tanggal))->result();
        foreach ($listTemp as $r) {
            $dataItem = array(
                'masuk_id'            => $masuk_id,
                'barang_id'           => $r->barang_id,
                'masuk_detail_qty'    => $r->masuk_temp_qty,
                'masuk_detail_update' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('vivo_masuk_detail', $dataItem);

            // Check Stok Barang
            // $barang_id  = $r->barang_id;
            // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            // $StokLama   = $dataBarang->barang_stok;
            // $Stok       = ($StokLama + $r->masuk_temp_qty);
            // // Update Stok Utama
            // $dataStok = array(
            //     'barang_stok'   => $Stok,
            //     'barang_update' => date('Y-m-d H:i:s'),
            // );

            // $this->db->where('barang_id', $barang_id);
            // $this->db->update('vivo_barang', $dataStok);
        }

        // Hapus Temp by Username dan Tanggal
        $username = $this->session->userdata('username');
        $this->db->where('user_username', $username);
        $this->db->delete('vivo_masuk_temp');
    }

    // Detail Edit
    private function _get_detail_datatables_query($masuk_id)
    {
        $this->db->from($this->table3);
        $this->db->where('masuk_id', $masuk_id);

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

    public function get_detail_datatables($masuk_id)
    {
        $this->_get_detail_datatables_query($masuk_id);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_detail_filtered($masuk_id)
    {
        $this->_get_detail_datatables_query($masuk_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_detail_all($masuk_id)
    {
        $this->db->from($this->table3);
        $this->db->where('masuk_id', $masuk_id);

        return $this->db->count_all_results();
    }

    // Detail KASIR
    private function _get_masuk_datatables_query($masuk_id)
    {
        $this->db->from($this->table4);
        $this->db->where('masuk_id', $masuk_id);

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

    public function get_masuk_datatables($masuk_id)
    {
        $this->_get_masuk_datatables_query($masuk_id);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_masuk_filtered($masuk_id)
    {
        $this->_get_masuk_datatables_query($masuk_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_masuk_all($masuk_id)
    {
        $this->db->from($this->table4);
        $this->db->where('masuk_id', $masuk_id);

        return $this->db->count_all_results();
    }

    public function insert_data_detail()
    {
        $masuk_id  = $this->input->post('masuk_id', 'true');
        $barang_id = $this->input->post('barang_id', 'true');
        $checkData = $this->db->get_where('vivo_masuk_detail', array('barang_id' => $barang_id, 'masuk_id' => $masuk_id))->row();
        if (count($checkData) == 0) {
            $qty  = intval(str_replace(",", "", $this->input->post('qty', 'true')));
            $data = array(
                'masuk_id'            => $this->input->post('masuk_id', 'true'),
                'barang_id'           => $this->input->post('barang_id', 'true'),
                'masuk_detail_qty'    => intval(str_replace(",", "", $this->input->post('qty', 'true'))),
                'masuk_detail_update' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('vivo_masuk_detail', $data);

            // Update Stok
            // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            // $StokLama   = $dataBarang->barang_stok;
            // $Stok       = ($StokLama + $qty);
            // $dataStok   = array(
            //     'barang_stok'   => $Stok,
            //     'barang_update' => date('Y-m-d H:i:s'),
            // );

            // $this->db->where('barang_id', $barang_id);
            // $this->db->update('vivo_barang', $dataStok);
        } else {
            $jumlah = intval(str_replace(",", "", $this->input->post('qty', 'true')));
            $qty    = ($checkData->masuk_detail_qty + $jumlah);
            $data   = array(
                'masuk_detail_qty' => $qty,
            );

            $this->db->where('masuk_id', $masuk_id);
            $this->db->where('barang_id', $barang_id);
            $this->db->update('vivo_masuk_detail', $data);

            // Update Stok
            // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            // $StokLama   = $dataBarang->barang_stok;
            // $Stok       = (($StokLama - $checkData->masuk_detail_qty) + $qty);
            // $dataStok   = array(
            //     'barang_stok'   => $Stok,
            //     'barang_update' => date('Y-m-d H:i:s'),
            // );

            // $this->db->where('barang_id', $barang_id);
            // $this->db->update('vivo_barang', $dataStok);
        }
    }

    public function update_data_detail()
    {
        $masuk_detail_id = $this->input->post('masuk_detail_id', 'true');
        $barang_id       = $this->input->post('barang_id', 'true');
        $qty             = intval(str_replace(",", "", $this->input->post('qty', 'true')));
        $qty_lama        = $this->input->post('qty_lama', 'true');
        $data            = array(
            'masuk_detail_qty'    => $qty,
            'masuk_detail_update' => date('Y-m-d H:i:s'),
        );

        $this->db->where('masuk_detail_id', $masuk_detail_id);
        $this->db->update('vivo_masuk_detail', $data);

        // Update Stok
        // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
        // $StokLama   = $dataBarang->barang_stok;
        // $Stok       = (($StokLama - $qty_lama) + $qty);
        // $dataStok   = array(
        //     'barang_stok'   => $Stok,
        //     'barang_update' => date('Y-m-d H:i:s'),
        // );

        // $this->db->where('barang_id', $barang_id);
        // $this->db->update('vivo_barang', $dataStok);
    }

    public function delete_data_detail($id)
    {
        // Hitung Stok dulu
        // $dataLama  = $this->db->get_where('vivo_masuk_detail', array('masuk_detail_id' => $id))->row();
        // $barang_id = $dataLama->barang_id;
        // $qty       = $dataLama->masuk_detail_qty;

        // // Update Stok
        // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
        // $StokLama   = $dataBarang->barang_stok;
        // $Stok       = ($StokLama - $qty);
        // $dataStok   = array(
        //     'barang_stok'   => $Stok,
        //     'barang_update' => date('Y-m-d H:i:s'),
        // );

        // $this->db->where('barang_id', $barang_id);
        // $this->db->update('vivo_barang', $dataStok);

        // Hapus Data
        $this->db->where('masuk_detail_id', $id);
        $this->db->delete('vivo_masuk_detail');
    }

    public function update_data_masuk()
    {
        $masuk_id = $this->input->post('masuk_id', 'true');
        $username = $this->session->userdata('username');
        $data     = array(
            'masuk_tanggal'    => date('Y-m-d'),
            'masuk_keterangan' => strtoupper(stripHTMLtags($this->input->post('keterangan', 'true'))),
            'user_username'    => $username,
            'masuk_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->where('masuk_id', $masuk_id);
        $this->db->update('vivo_masuk', $data);
    }

    public function delete_data_masuk($id)
    {
        $listDetail = $this->db->order_by('masuk_detail_id', 'asc')->get_where('vivo_masuk_detail', array('masuk_id' => $id))->result();
        foreach ($listDetail as $d) {
            // Hitung Stok dulu
            // $masuk_detail_id = $d->masuk_detail_id;
            // $dataLama        = $this->db->get_where('vivo_masuk_detail', array('masuk_detail_id' => $masuk_detail_id))->row();
            // $barang_id       = $dataLama->barang_id;
            // $qty             = $dataLama->masuk_detail_qty;

            // // Update Stok
            // $dataBarang = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
            // $StokLama   = $dataBarang->barang_stok;
            // $Stok       = ($StokLama - $qty);
            // $dataStok   = array(
            //     'barang_stok'   => $Stok,
            //     'barang_update' => date('Y-m-d H:i:s'),
            // );

            // $this->db->where('barang_id', $barang_id);
            // $this->db->update('vivo_barang', $dataStok);

            // Hapus Data Detail
            $this->db->where('masuk_detail_id', $masuk_detail_id);
            $this->db->delete('vivo_masuk_detail');
        }

        // Hapus Data
        $this->db->where('masuk_id', $id);
        $this->db->delete('vivo_masuk');
    }
}
/* Location: ./application/models/admin/Masuk_m.php */
