<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan_m extends CI_Model
{
    public $table        = 'vivo_pelanggan';
    public $column_order = array(null, null, 'pelanggan_nomor', 'pelanggan_nama', 'pelanggan_alamat', 'pelanggan_disc', 'pelanggan_expired',
        'pelanggan_poin', 'pelanggan_status');
    public $column_search = array('pelanggan_nomor', 'pelanggan_nama', 'pelanggan_alamat', 'pelanggan_disc', 'pelanggan_telp',
        'pelanggan_status');
    public $order = array('pelanggan_nama' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
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

    public function insert_data()
    {
        $data = array(
            'pelanggan_nomor'   => strtoupper(trim(stripHTMLtags($this->input->post('nomor', 'true')))),
            'pelanggan_nama'    => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
            'pelanggan_alamat'  => strtoupper(trim(stripHTMLtags($this->input->post('alamat', 'true')))),
            'pelanggan_kota'    => strtoupper(trim(stripHTMLtags($this->input->post('kota', 'true')))),
            'pelanggan_telp'    => strtoupper(trim(stripHTMLtags($this->input->post('telp', 'true')))),
            'pelanggan_disc'    => $this->input->post('disc', 'true'),
            'pelanggan_expired' => date('Y-m-d', strtotime($this->input->post('tgl_expired', 'true'))),
            'pelanggan_status'  => $this->input->post('lstStatus', 'true'),
            'pelanggan_update'  => date('Y-m-d H:i:s'),
        );

        $this->db->insert('vivo_pelanggan', $data);
    }

    public function select_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('vivo_pelanggan');
        $this->db->where('pelanggan_id', $id);

        return $this->db->get();
    }

    public function update_data()
    {
        $pelanggan_id = $this->input->post('id', 'true');
        $data         = array(
            'pelanggan_nomor'   => strtoupper(trim(stripHTMLtags($this->input->post('nomor', 'true')))),
            'pelanggan_nama'    => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
            'pelanggan_alamat'  => strtoupper(trim(stripHTMLtags($this->input->post('alamat', 'true')))),
            'pelanggan_kota'    => strtoupper(trim(stripHTMLtags($this->input->post('kota', 'true')))),
            'pelanggan_telp'    => strtoupper(trim(stripHTMLtags($this->input->post('telp', 'true')))),
            'pelanggan_disc'    => $this->input->post('disc', 'true'),
            'pelanggan_expired' => date('Y-m-d', strtotime($this->input->post('tgl_expired', 'true'))),
            'pelanggan_status'  => $this->input->post('lstStatus', 'true'),
            'pelanggan_update'  => date('Y-m-d H:i:s'),
        );

        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->update('vivo_pelanggan', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('pelanggan_id', $id);
        $this->db->delete('vivo_pelanggan');
    }
}
/* Location: ./application/models/admin/Pelanggan_m.php */
