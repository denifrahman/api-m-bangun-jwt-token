<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Status_Model extends CI_Model
{
    protected $Status_table = 'm_status';

    /**
     * Use Registration
     * @param: {array} Status Data
     */
    public function insert_Status(array $data) {
        $this->db->insert($this->Status_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Status Login
     * ----------------------------------
     * @param: Statusname or email address
     * @param: password
     */
    public function getAll_Status()
    {
        $this->db->where('statusaktif','1');
        $q = $this->db->get($this->Status_table);
        return $q->result();
    }
      /**
     * Status Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkStatusakses
     * @link: api/Status/getAllByFilterParam
     */
    public function getAllByFilterParam_Status($akses)
    {
        $this->db->where('statusaktif','1');
        $q = $this->db->get($this->Status_table);
        return $q->result();
    }
     /**
     * SubStatus get data by id
     * ----------------------------------
     * @param: SubStatus get by id
     */
    public function getById_Status($id)
    {
        $this->db->where('produkStatusid',$id);
        $this->db->where('statusaktif','1');
        $q = $this->db->get($this->Status_table);
        return $q->result();
    }
}
