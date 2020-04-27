<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menu_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_user($username)
    {
        $this->db->select('*');
        $this->db->from('vivo_users');
        $this->db->where('user_username', $username);

        return $this->db->get();
    }

    public function select_meta()
    {
        $this->db->select('*');
        $this->db->from('vivo_meta');
        $this->db->where('meta_id', 1);

        return $this->db->get();
    }

    public function select_contact()
    {
        $this->db->select('*');
        $this->db->from('vivo_contact');
        $this->db->where('contact_id', 1);

        return $this->db->get();
    }

    public function select_kategori()
    {
        $this->db->select('*');
        $this->db->from('vivo_kategori');
        $this->db->order_by('kategori_nama', 'asc');

        return $this->db->get();
    }

    public function select_social()
    {
        $this->db->select('*');
        $this->db->from('vivo_social');
        $this->db->order_by('social_name', 'asc');

        return $this->db->get();
    }
}
/* Location: ./application/model/Menu_m.php */
