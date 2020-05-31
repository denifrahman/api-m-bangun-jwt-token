<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Model extends CI_Model
{
    protected $kategori_table = 'm_produkkategori';

    /**
     * Use Registration
     * @param: {array} kategori Data
     */
    public function insert_kategori(array $data) {
        $this->db->insert($this->kategori_table, $data);
        return $this->db->insert_id();
    }

    /**
     * kategori Login
     * ----------------------------------
     * @param: kategoriname or email address
     * @param: password
     */
    public function getAll_kategori()
    {
        $q = $this->db->get($this->kategori_table);
        return $q->result();
    }
     /**
     * SubKategori get data by id
     * ----------------------------------
     * @param: Subkategori get by id
     */
    public function getById_Kategori($id)
    {
        $this->db->where('produkkategoriid',$id);
        $q = $this->db->get($this->kategori_table);
        return $q->result();
    }
}
