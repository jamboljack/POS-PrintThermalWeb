<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Lap_kasir_m extends CI_Model
{
    public $table        = 'v_penjualan';
    public $column_order = array(null, 'user_username', 'penjualan_no', 'penjualan_tanggal', 'pelanggan_nama',
        'penjualan_diskon', 'penjualan_tukar_poin_rp', 'penjualan_total');
    public $column_search = array('user_username', 'penjualan_no', 'penjualan_tanggal', 'pelanggan_nama',
        'penjualan_diskon', 'penjualan_tukar_poin_rp', 'penjualan_total');
    public $order = array('penjualan_id' => 'asc');

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
        if ($this->input->post('lstKasir', 'true')) {
            $this->db->where('user_username', $this->input->post('lstKasir', 'true'));
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
}
/* Location: ./application/model/admin/Lap_kasir_m.php */
