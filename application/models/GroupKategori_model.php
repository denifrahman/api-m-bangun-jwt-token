<?php defined('BASEPATH') or exit('No direct script access allowed');

class GroupKategori_Model extends CI_Model
{
    protected $GroupKategori_table = 't_group_kategori';

    
    public function getAllByParam_GroupKategori($group_kategori_id = '',$group_nama = '',$thumbnail = '')
    {
        if ($group_kategori_id != '') {
            $this->db->where('group_kategori_id', $group_kategori_id);
        }
        if ($group_nama != '') {
            $this->db->where('group_nama', $group_nama);
        }
        if ($thumbnail != '') {
            $this->db->where('thumbnail', $thumbnail);
        }
        

        $q = $this->db->get($this->GroupKategori_table);
        return $q->result();
    }
}
