<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi_Model extends CI_Model
{
    protected $Provinsi_table = 'm_ipropinsi';

    /**
     * Use Registration
     * @param: {array} Provinsi Data
     */
    public function insert_Provinsi(array $data) {
        $this->db->insert($this->Provinsi_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Provinsi Login
     * ----------------------------------
     * @param: Provinsiname or email address
     * @param: password
     */
    public function getAll_Provinsi()
    {
        $q = $this->db->get($this->Provinsi_table);
        return $q->result();
    }
     /**
     * SubProvinsi get data by id
     * ----------------------------------
     * @param: SubProvinsi get by id
     */
    public function getById_Provinsi($id)
    {
        $this->db->where('id_propinsi',$id);
        $q = $this->db->get($this->Provinsi_table);
        return $q->row();
    }
}
