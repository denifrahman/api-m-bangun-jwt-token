<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatan_Model extends CI_Model
{
    protected $Kecamatan_table = 'm_ikecamatan';

    /**
     * kecamatan By Parameter
     * ----------------------------------
     * @param: kecamatanname or email address
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
            $query = "SELECT * FROM m_kecamatan ";
        } else {
            $query = "SELECT * FROM m_kecamatan " . "Where " . implode(" AND ", $query_array);
        }
        return $this->db->query($query)->result();
    }
    /**
     * create kecamatan
     * @param array($data);
     * ----------------------------------
     */
    public function create($body)
    {
        $q =  $this->db->insert('m_kecamatan', $body);
        return $q;
    }
    /**
     * update Status kecamatan
     * @param array($data);
     * ----------------------------------
     */
    public function update($body)
    {
        $this->db->where('kecamatan_id', $body['kecamatan_id']);
        $q =  $this->db->update('m_kecamatan', $body);
        return $q;
    }
    /**
     * delete kecamatan
     * @param array($data);
     * ----------------------------------
     */
    public function delete($body)
    {
        $this->db->where('kecamatan_id', $body['kecamatan_id']);
        $q =  $this->db->update('m_kecamatan', $body);
        return $q;
    }
}
