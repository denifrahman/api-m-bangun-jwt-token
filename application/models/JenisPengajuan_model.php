<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JenisPengajuan_Model extends CI_Model
{
    protected $JenisPengajuan_table = 'm_jenispengajuan';

    /**
     * Use Registration
     * @param: {array} JenisPengajuan Data
     */
    public function insert_JenisPengajuan(array $data) {
        $this->db->insert($this->JenisPengajuan_table, $data);
        return $this->db->insert_id();
    }

    /**
     * JenisPengajuan Login
     * ----------------------------------
     * @param: JenisPengajuanname or email address
     * @param: password
     */
    public function getAll_JenisPengajuan()
    {
        $this->db->where('jenispengajuanaktif','1');
        $q = $this->db->get($this->JenisPengajuan_table);
        return $q->result();
    }
      /**
     * JenisPengajuan Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : JenisPengajuanakses
     * @link: api/JenisPengajuan/getAllByFilterParam
     */
    public function getAllByFilterParam_JenisPengajuan($akses)
    {
        $this->db->where('JenisPengajuanaktif','1');
        $this->db->where('JenisPengajuanakses', $akses);
        $q = $this->db->get($this->JenisPengajuan_table);
        return $q->result();
    }
     /**
     * SubJenisPengajuan get data by id
     * ----------------------------------
     * @param: SubJenisPengajuan get by id
     */
    public function getById_JenisPengajuan($id)
    {
        $this->db->where('JenisPengajuanid',$id);
        $this->db->where('JenisPengajuanaktif','1');
        $q = $this->db->get($this->JenisPengajuan_table);
        return $q->result();
    }
}
