<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PelatihanKerja_Model extends CI_Model
{
    protected $PelatihanKerja_table = 't_pelatihan_kerja';

    /**
     * Use Registration
     * @param: {array} PelatihanKerja Data
     */
    public function insert_PelatihanKerja(array $data) {
        $q = $this->db->insert($this->PelatihanKerja_table, $data);
        return $q;
    }

    /**
     * PelatihanKerja Login
     * ----------------------------------
     * @param: PelatihanKerjaname or email address
     * @param: password
     */
    public function getAll_PelatihanKerja()
    {
        $this->db->where('PelatihanKerjaaktif','1');
        $q = $this->db->get($this->PelatihanKerja_table);
        return $q->result();
    }
      /**
     * PelatihanKerja Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : PelatihanKerjaakses
     * @link: api/PelatihanKerja/getAllByFilterParam
     */
    public function getAllByFilterParam_PelatihanKerja($akses)
    {
        $this->db->where('PelatihanKerjaaktif','1');
        $this->db->where('PelatihanKerjaakses', $akses);
        $q = $this->db->get($this->PelatihanKerja_table);
        return $q->result();
    }
     /**
     * SubPelatihanKerja get data by id
     * ----------------------------------
     * @param: SubPelatihanKerja get by id
     */
    public function getById_PelatihanKerja($id)
    {
        $this->db->where('PelatihanKerjaid',$id);
        $this->db->where('PelatihanKerjaaktif','1');
        $q = $this->db->get($this->PelatihanKerja_table);
        return $q->result();
    }
}
