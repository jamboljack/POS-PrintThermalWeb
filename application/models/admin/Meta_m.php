<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meta_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_detail($meta_id = 1)
    {
        $this->db->select('*');
        $this->db->from('vivo_meta');
        $this->db->where('meta_id', $meta_id);

        return $this->db->get();
    }

    public function update_data()
    {
        $data = array(
            'meta_name'       => stripHTMLtags($this->input->post('name', 'true')),
            'meta_desc'       => trim($this->input->post('desc', 'true')),
            'meta_keyword'    => stripHTMLtags($this->input->post('keyword', 'true')),
            'meta_author'     => stripHTMLtags($this->input->post('author', 'true')),
            'meta_developer'  => stripHTMLtags($this->input->post('developer', 'true')),
            'meta_robots'     => stripHTMLtags($this->input->post('lstRobot', 'true')),
            'meta_googlebots' => stripHTMLtags($this->input->post('lstGoogle', 'true')),
            'meta_ppn'        => str_replace(",", "", $this->input->post('ppn', 'true')),
            'meta_min_order'  => str_replace(",", "", $this->input->post('poin', 'true')),
            'meta_tukar_poin' => str_replace(",", "", $this->input->post('tukar_poin', 'true')),
            'meta_footer'     => stripHTMLtags($this->input->post('footer', 'true')),
            'meta_update'     => date('Y-m-d H:i:s'),
        );

        $this->db->where('meta_id', 1);
        $this->db->update('vivo_meta', $data);
    }
}
/* Location: ./application/models/admin/Meta_m.php */
