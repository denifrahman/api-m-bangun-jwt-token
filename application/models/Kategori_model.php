<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Model extends CI_Model
{
    protected $kategori_table = 'm_produk_kategori';

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
        $this->db->where('produkkategoriaktif','1');
        $q = $this->db->get($this->kategori_table);
        return $q->result();
    }
      /**
     * Kategori Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkkategoriakses
     * @link: api/Kategori/getAllByFilterParam
     */
    public function getAllByFilterParam_kategori($akses)
    {
        $this->db->where('produkkategoriaktif','1');
        $this->db->where('produkkategoriakses', $akses);
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
        $this->db->where('produkkategoriaktif','1');
        $q = $this->db->get($this->kategori_table);
        return $q->result();
    }
}
