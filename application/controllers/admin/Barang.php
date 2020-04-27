<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/barang_m');
        $this->resized_path = realpath(APPPATH . '../img/barang_folder');
        $this->thumbs_path  = realpath(APPPATH . '../img/barang_folder/thumbs');
    }

    public function index()
    {
        $data['listKategori'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        $this->template->display('admin/barang/view', $data);
    }

    public function data_list()
    {
        $List = $this->barang_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($List as $r) {
            $no++;
            $row       = array();
            $barang_id = $r->barang_id;
            $linkedit  = site_url('admin/barang/editdata/' . $barang_id);
            $row[]     = '<a href="' . $linkedit . '" title="Edit Data"><i class="icon-pencil"></i></a>
                            <a onclick="hapusData(' . $barang_id . ')" title="Hapus Data"><i class="icon-close"></i></a>';
            $row[] = $no;
            if ($r->barang_foto == '') {
                $foto = '<img src="' . base_url('img/no-image.png') . '" width="150px" height="100px">';
            } else {
                $foto = '<img src="' . base_url('img/barang_folder/thumbs/' . $r->barang_foto . '" width="100px" height="100px">');
            }
            $row[]  = $foto;
            $row[]  = $r->barang_kode;
            $row[]  = $r->barang_nama;
            $row[]  = $r->kategori_nama;
            $row[]  = ($r->barang_tipe == 'S' ? '<span class="label label-success">STOCK</span>' : '<span class="label label-danger">NON STOCK</span>');
            $row[]  = number_format($r->barang_ppn, 2, '.', ',');
            $row[]  = number_format($r->barang_stok, 0, '', ',');
            $row[]  = number_format($r->barang_total, 0, '', ',');
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->barang_m->count_all(),
            "recordsFiltered" => $this->barang_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function adddata()
    {
        $data['listKategori'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        $this->template->display('admin/barang/add', $data);
    }

    private function nama_exists($nama)
    {
        $this->db->where('barang_nama', $nama);
        $query = $this->db->get('vivo_barang');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function register_nama_exists()
    {
        if (array_key_exists('nama', $_POST)) {
            if ($this->nama_exists(stripHTMLtags($this->input->post('nama', 'true'))) == true) {
                echo json_encode(false);
            } else {
                echo json_encode(true);
            }
        }
    }

    public function savedata()
    {
        if (!empty($_FILES['foto']['name'])) {
            $jam                     = time();
            $nama                    = seo_title(stripHTMLtags($this->input->post('nama')));
            $config['file_name']     = 'Barang_' . $nama . '_' . $jam . '.jpg';
            $config['upload_path']   = './img/barang_folder/';
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['overwrite']     = true;
            $config['max_size']      = 0;
            $config['width']         = 300;
            $config['height']        = 300;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $configThumb                   = array();
            $configThumb['image_library']  = 'gd2';
            $configThumb['source_image']   = '';
            $configThumb['maintain_ratio'] = true;
            $configThumb['overwrite']      = true;
            $this->load->library('image_lib');
            if (!$this->upload->do_upload('foto')) {
                $response['status'] = 'error';
            } else {
                $upload      = $this->upload->do_upload('foto');
                $upload_data = $this->upload->data();
                $config      = array(
                    'file_name'      => $upload_data['file_name'],
                    'source_image'   => $upload_data['full_path'], //path to the uploaded image
                    'new_image'      => $this->resized_path, //path to
                    'maintain_ratio' => true,
                    'overwrite'      => true,
                    'width'          => 300,
                    'height'         => 300,
                );

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $config = array(
                    'source_image'   => $upload_data['full_path'],
                    'new_image'      => $this->thumbs_path,
                    'maintain_ratio' => true,
                    'overwrite'      => true,
                    'width'          => 150,
                    'height'         => 150,
                );

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $this->barang_m->insert_data();
                $response['status'] = 'success';
            }
        } else {
            $this->barang_m->insert_data();
            $response['status'] = 'success';
        }

        echo json_encode($response);
    }

    public function editdata($barang_id)
    {
        $data['listKategori'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        $data['detail']       = $this->db->get_where('vivo_barang', array('barang_id' => $barang_id))->row();
        $this->template->display('admin/barang/edit', $data);
    }

    public function updatedata()
    {
        if (!empty($_FILES['foto']['name'])) {
            $jam                     = time();
            $nama                    = seo_title(stripHTMLtags($this->input->post('nama')));
            $config['file_name']     = 'Barang_' . $nama . '_' . $jam . '.jpg';
            $config['upload_path']   = './img/barang_folder/';
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['overwrite']     = true;
            $config['max_size']      = 0;
            $config['width']         = 300;
            $config['height']        = 250;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $configThumb                   = array();
            $configThumb['image_library']  = 'gd2';
            $configThumb['source_image']   = '';
            $configThumb['maintain_ratio'] = true;
            $configThumb['overwrite']      = true;
            $this->load->library('image_lib');
            if (!$this->upload->do_upload('foto')) {
                $response['status'] = 'error';
            } else {
                $upload      = $this->upload->do_upload('foto');
                $upload_data = $this->upload->data();
                $config      = array(
                    'file_name'      => $upload_data['file_name'],
                    'source_image'   => $upload_data['full_path'], //path to the uploaded image
                    'new_image'      => $this->resized_path, //path to
                    'maintain_ratio' => true,
                    'overwrite'      => true,
                    'width'          => 300,
                    'height'         => 300,
                );

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $config = array(
                    'source_image'   => $upload_data['full_path'],
                    'new_image'      => $this->thumbs_path,
                    'maintain_ratio' => true,
                    'overwrite'      => true,
                    'width'          => 150,
                    'height'         => 125,
                );

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $this->barang_m->update_data();
                $response['status'] = 'success';
            }
        } else {
            $this->barang_m->update_data();
            $response['status'] = 'success';
        }

        echo json_encode($response);
    }

    public function deletedata($id)
    {
        $this->barang_m->delete_data($id);
    }

    public function printdata($kategori = 'all', $tipe = 'all')
    {
        $data['header'] = $this->db->get_where('vivo_contact', array('contact_id' => 1))->row();
        if ($kategori != 'all') {
            $data['listData'] = $this->db->order_by('kategori_nama', 'asc')->get_where('vivo_kategori', array('kategori_id' => $kategori))->result();
        } else {
            $data['listData'] = $this->db->order_by('kategori_nama', 'asc')->get('vivo_kategori')->result();
        }

        $this->load->view('admin/barang/printdata_v', $data);
    }
}
/* Location: ./application/controller/admin/Barang.php */
