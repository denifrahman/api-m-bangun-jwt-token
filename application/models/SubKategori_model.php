<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SubKategori_Model extends CI_Model
{
    protected $SubKategori_table = 'produkkategorisub';

    /**
     * Use Registration
     * @param: {array} SubKategori Data
     */
    public function insert_SubKategori(array $data) {
        $this->db->insert($this->SubKategori_table, $data);
        return $this->db->insert_id();
    }

    /**
     * SubKategori Login
     * ----------------------------------
     * @param: SubKategoriname or email address
     * @param: password
     */
    public function getAll_SubKategori()
    {
        $this->db->where('produkkategorisubaktif','1');
        $q = $this->db->get($this->SubKategori_table);
        return $q->result();
    }
    /**
     * SubKategori get data by id
     * ----------------------------------
     * @param: Subkategori get by id
     */
    public function getAllByIdKategori_SubKategori($id)
    {
        $this->db->where('produkkategoriid',$id);
        $this->db->where('produkkategorisubaktif','1');
        $q = $this->db->get($this->SubKategori_table);
        return $q->result();
    }
}
