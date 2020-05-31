<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kota_Model extends CI_Model
{
    protected $Kota_table = 'm_ikabkota';

    /**
     * Use Registration
     * @param: {array} Kota Data
     */
    public function insert_Kota(array $data) {
        $this->db->insert($this->Kota_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Kota Login
     * ----------------------------------
     * @param: Kotaname or email address
     * @param: password
     */
    public function getAllByIdProvinsi_Kota($idProvinsi)
    {
        $this->db->where('id_propinsi',$idProvinsi);
        $q = $this->db->get($this->Kota_table);
        return $q->result();
    }
     /**
     * SubKota get data by id
     * ----------------------------------
     * @param: SubKota get by id
     */
    public function getById_Kota($id)
    {
        $this->db->where('id_kabkota',$id);
        $q = $this->db->get($this->Kota_table);
        return $q->row();
    }
}
