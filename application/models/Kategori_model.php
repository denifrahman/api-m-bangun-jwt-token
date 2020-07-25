<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_Model extends CI_Model
{
    protected $kategori_table = 'm_produk_kategori';

   /**
     * kategori By Parameter
     * ----------------------------------
     * @param: kategoriname or email address
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
            $query = "SELECT * FROM m_kategori ";
        } else {
            $query = "SELECT * FROM m_kategori " . "Where " . implode(" AND ", $query_array);
        }
        return $this->db->query($query)->result();
    }
    /**
     * create kategori
     * @param array($data);
     * ----------------------------------
     */
    public function create($body)
    {
        $q =  $this->db->insert('m_kategori', $body);
        return $q;
    }
    /**
     * update Status kategori
     * @param array($data);
     * ----------------------------------
     */
    public function update($body)
    {
        $this->db->where('kategori_id', $body['kategori_id']);
        $q =  $this->db->update('m_kategori', $body);
        return $q;
    }
    /**
     * delete kategori
     * @param array($data);
     * ----------------------------------
     */
    public function delete($body)
    {
        $this->db->where('kategori_id', $body['kategori_id']);
        $q =  $this->db->update('m_kategori', $body);
        return $q;
    }
}
