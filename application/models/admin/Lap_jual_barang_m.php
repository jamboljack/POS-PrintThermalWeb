<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Lap_jual_barang_m extends CI_Model
{
    public $table        = 'v_penjualan_detail';
    public $column_order = array(null, 'penjualan_tanggal', 'penjualan_detail_kode',
        'penjualan_detail_nama', 'penjualan_detail_qty', 'penjualan_detail_harga',
        'penjualan_detail_disc', 'penjualan_detail_subtotal');
    public $column_search = array('penjualan_tanggal', 'penjualan_detail_kode', 'penjualan_detail_nama',
        'penjualan_detail_qty', 'penjualan_detail_harga', 'penjualan_detail_disc',
        'penjualan_detail_subtotal');
    public $order = array('penjualan_tanggal' => 'asc');

    public $table2         = 'v_barang';
    public $column_order2  = array(null, null, 'barang_kode', 'barang_nama', 'kategori_nama', 'barang_stok', 'barang_harga');
    public $column_search2 = array('barang_kode', 'barang_nama', 'kategori_nama');
    public $order2         = array('barang_kode' => 'asc');

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
        if ($this->input->post('barang_id', 'true')) {
            $this->db->where('barang_id', $this->input->post('barang_id', 'true'));
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

    private function _get_barang_datatables_query()
    {
        $this->db->from($this->table2);

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

        return $this->db->count_all_results();
    }
}
/* Location: ./application/model/admin/Lap_jual_barang_m.php */
