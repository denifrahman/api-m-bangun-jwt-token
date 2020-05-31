<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan_Model extends CI_Model
{
    protected $Kecamatan_table = 'm_ikecamatan';

    /**
     * Use Registration
     * @param: {array} Kecamatan Data
     */
    public function insert_Kecamatan(array $data) {
        $this->db->insert($this->Kecamatan_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Kecamatan Login
     * ----------------------------------
     * @param: Kecamatanname or email address
     * @param: password
     */
    public function getAllByIdKota_kecamatan($idKota)
    {
        $this->db->where('id_kabkota',$idKota);
        $q = $this->db->get($this->Kecamatan_table);
        return $q->result();
    }
     /**
     * SubKecamatan get data by id
     * ----------------------------------
     * @param: SubKecamatan get by id
     */
    public function getById_Kecamatan($id)
    {
        $this->db->where('id_kecamatan',$id);
        $q = $this->db->get($this->Kecamatan_table);
        return $q->row();
    }
}
