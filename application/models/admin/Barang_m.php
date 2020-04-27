<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_m extends CI_Model
{
    public $table        = 'v_barang';
    public $column_order = array(null, null, null, 'barang_kode', 'barang_nama', 'kategori_nama', 'barang_tipe', 'barang_ppn',
        'barang_stok', 'barang_total');
    public $column_search = array('barang_kode', 'barang_nama', 'kategori_nama', 'barang_tipe', 'barang_ppn',
        'barang_stok', 'barang_total');
    public $order = array('barang_nama' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        if ($this->input->post('lstKategori', 'true')) {
            $this->db->where('kategori_id', $this->input->post('lstKategori', 'true'));
        }
        if ($this->input->post('lstTipe', 'true')) {
            $this->db->where('barang_tipe', $this->input->post('lstTipe', 'true'));
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

    public function getkodeurut()
    {
        $this->db->select('barang_kode as kode', false);
        $this->db->limit(1);
        $this->db->order_by('barang_kode', 'desc');
        $query = $this->db->get('vivo_barang');
        if ($query->num_rows() != 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodebarang = str_pad($kode, 5, "0", STR_PAD_LEFT);
        return $kodebarang;
    }

    public function insert_data()
    {
        $kode = $this->getkodeurut();
        if (!empty($_FILES['foto']['name'])) {
            $data = array(
                'barang_kode'   => $kode,
                'barang_nama'   => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'barang_seo'    => seo_title(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'kategori_id'   => trim($this->input->post('lstKategori', 'true')),
                'barang_tipe'   => trim($this->input->post('lstTipe', 'true')),
                'barang_harga'  => intval(str_replace(",", "", $this->input->post('harga', 'true'))),
                'barang_ppn'    => str_replace(",", "", $this->input->post('ppn', 'true')),
                'barang_ppn_rp' => $this->input->post('ppn_rp', 'true'),
                'barang_total'  => intval(str_replace(",", "", $this->input->post('total', 'true'))),
                'barang_foto'   => $this->upload->file_name,
                'barang_update' => date('Y-m-d H:i:s'),
            );
        } else {
            $data = array(
                'barang_kode'   => $kode,
                'barang_nama'   => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'barang_seo'    => seo_title(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'kategori_id'   => trim($this->input->post('lstKategori', 'true')),
                'barang_tipe'   => trim($this->input->post('lstTipe', 'true')),
                'barang_harga'  => intval(str_replace(",", "", $this->input->post('harga', 'true'))),
                'barang_ppn'    => str_replace(",", "", $this->input->post('ppn', 'true')),
                'barang_ppn_rp' => $this->input->post('ppn_rp', 'true'),
                'barang_total'  => intval(str_replace(",", "", $this->input->post('total', 'true'))),
                'barang_update' => date('Y-m-d H:i:s'),
            );
        }

        $this->db->insert('vivo_barang', $data);
    }

    public function update_data()
    {
        $barang_id = $this->input->post('id', 'true');
        if (!empty($_FILES['foto']['name'])) {
            $data = array(
                'barang_nama'   => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'barang_seo'    => seo_title(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'kategori_id'   => trim($this->input->post('lstKategori', 'true')),
                'barang_tipe'   => trim($this->input->post('lstTipe', 'true')),
                'barang_harga'  => intval(str_replace(",", "", $this->input->post('harga', 'true'))),
                'barang_ppn'    => str_replace(",", "", $this->input->post('ppn', 'true')),
                'barang_ppn_rp' => $this->input->post('ppn_rp', 'true'),
                'barang_total'  => intval(str_replace(",", "", $this->input->post('total', 'true'))),
                'barang_foto'   => $this->upload->file_name,
                'barang_update' => date('Y-m-d H:i:s'),
            );
        } else {
            $data = array(
                'barang_nama'   => strtoupper(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'barang_seo'    => seo_title(trim(stripHTMLtags($this->input->post('nama', 'true')))),
                'kategori_id'   => trim($this->input->post('lstKategori', 'true')),
                'barang_tipe'   => trim($this->input->post('lstTipe', 'true')),
                'barang_harga'  => intval(str_replace(",", "", $this->input->post('harga', 'true'))),
                'barang_ppn'    => str_replace(",", "", $this->input->post('ppn', 'true')),
                'barang_ppn_rp' => $this->input->post('ppn_rp', 'true'),
                'barang_total'  => intval(str_replace(",", "", $this->input->post('total', 'true'))),
                'barang_update' => date('Y-m-d H:i:s'),
            );
        }

        $this->db->where('barang_id', $barang_id);
        $this->db->update('vivo_barang', $data);
    }

    public function delete_data($id)
    {
        $this->db->where('barang_id', $id);
        $this->db->delete('vivo_barang');
    }
}
/* Location: ./application/models/admin/Barang_m.php */
