<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produk_Model extends CI_Model
{
    protected $produk_table = 'v_produk';
   

    /**
     * Produk By Parameter
     * ----------------------------------
     * @param: Produkname or email address
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
            $query = "SELECT * FROM t_produk ";
        }else{
            $query = "SELECT * FROM t_produk " . "Where " . implode(" AND ", $query_array);
        }
        return $this->db->query($query)->result();
    }
    /**
     * create Produk
     * @param array($data);
     * ----------------------------------
     */
    public function create($body)
    {
        $q =  $this->db->insert('t_produk', $body);
        return $q;
    }
    /**
     * update Status Produk
     * @param array($data);
     * ----------------------------------
     */
    public function update($body)
    {
        $this->db->where('produk_id', $body['produk_id']);
        $q =  $this->db->update('t_produk', $body);
        return $q;
    }
    /**
     * delete Produk
     * @param array($data);
     * ----------------------------------
     */
    public function delete($body)
    {
        $this->db->where('produk_id', $body['produk_id']);
        $q =  $this->db->update('t_produk', $body);
        return $q;
    }
}
