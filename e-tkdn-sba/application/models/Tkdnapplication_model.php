<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tkdnapplication_model extends CI_Model {

    protected $table = 'tkdn_applications';

    public function __construct()
    {
        parent::__construct();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function count_by_status($status)
    {
        return $this->db->where('status', $status)
                        ->count_all_results($this->table);
    }

    public function get_recent($limit = 5)
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get($this->table)
                        ->result();
    }

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                        ->get($this->table)
                        ->row();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
                        ->delete($this->table);
    }
}
