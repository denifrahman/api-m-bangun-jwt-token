<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite_Model extends CI_Model
{
    protected $favorite_table = 'fav_produk';


    /**
     * create favorite
     * @param: {array} favorite Data
     */
    public function create_Favorite(array $data) {
        $q = $this->db->insert($this->favorite_table, $data);
        return $q;
    }

    /**
     * Delete an Favorite
     * @param: {array} Favorite Data
     */
    public function delete_Favorite(array $data)
    {
        /**
         * Check Favorite exist with Favorite_id and user_id
         */
        $query = $this->db->get_where($this->favorite_table, $data);
        if ($this->db->affected_rows() > 0) {

            // Delete Favorite
            $this->db->delete($this->favorite_table, $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * Favorite getAll
     * ----------------------------------
     */
    public function getAll_Favorite()
    {
        $this->db->where('produkFavoriteaktif','1');
        $q = $this->db->get($this->favorite_table);
        return $q->result();
    }
      /**
     * Favorite Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkFavoriteakses
     * @link: api/Favorite/getAllByFilterParam
     */
    public function getAllByFilterParam_Favorite($produkId = '', $userId = '')
    {
        $this->db->where('userid',$userId);
        $this->db->where('produkid', $produkId);
        $q = $this->db->get($this->favorite_table);
        return $q->result();
    }
     /**
     * SubFavorite get data by id
     * ----------------------------------
     * @param: SubFavorite get by id
     */
    public function getById_Favorite($id)
    {
        $this->db->where('produkFavoriteid',$id);
        $this->db->where('produkFavoriteaktif','1');
        $q = $this->db->get($this->favorite_table);
        return $q->result();
    }
}
