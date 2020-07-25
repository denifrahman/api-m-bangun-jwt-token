<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kota_Model extends CI_Model
{
    protected $Kota_table = 'm_ikabkota';

  /**
     * kota By Parameter
     * ----------------------------------
     * @param: kotaname or email address
     * @param: password
     */
    public function getAllByParam($param)
    {
        $query_array = array();

        foreach ($param as $key => $value) {
            if ($value != '') {
                $query_array[] = $key . ' = ' . $value;
            }
        }
        if (count($query_array) < 1) {
            $query = "SELECT * FROM m_kota ";
        } else {
            $query = "SELECT * FROM m_kota " . "Where " . implode(" AND ", $query_array);
        }
        return $this->db->query($query)->result();
    }
    /**
     * create kota
     * @param array($data);
     * ----------------------------------
     */
    public function create($body)
    {
        $q =  $this->db->insert('m_kota', $body);
        return $q;
    }
    /**
     * update Status kota
     * @param array($data);
     * ----------------------------------
     */
    public function update($body)
    {
        $this->db->where('kota_id', $body['kota_id']);
        $q =  $this->db->update('m_kota', $body);
        return $q;
    }
    /**
     * delete kota
     * @param array($data);
     * ----------------------------------
     */
    public function delete($body)
    {
        $this->db->where('kota_id', $body['kota_id']);
        $q =  $this->db->update('m_kota', $body);
        return $q;
    }
}
