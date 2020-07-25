<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi_Model extends CI_Model
{
    protected $Provinsi_table = 'm_ipropinsi';

  /**
     * provinsi By Parameter
     * ----------------------------------
     * @param: provinsiname or email address
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
            $query = "SELECT * FROM m_provinsi ";
        } else {
            $query = "SELECT * FROM m_provinsi " . "Where " . implode(" AND ", $query_array);
        }
        return $this->db->query($query)->result();
    }
    /**
     * create provinsi
     * @param array($data);
     * ----------------------------------
     */
    public function create($body)
    {
        $q =  $this->db->insert('m_provinsi', $body);
        return $q;
    }
    /** 
     * update Status provinsi
     * @param array($data);
     * ----------------------------------
     */
    public function update($body)
    {
        $this->db->where('provinsi_id', $body['provinsi_id']);
        $q =  $this->db->update('m_provinsi', $body);
        return $q;
    }
    /**
     * delete provinsi
     * @param array($data);
     * ----------------------------------
     */
    public function delete($body)
    {
        $this->db->where('provinsi_id', $body['provinsi_id']);
        $q =  $this->db->update('m_provinsi', $body);
        return $q;
    }
}
