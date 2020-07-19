<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite_Model extends CI_Model
{
    protected $favorite_table = 'v_favorite';


    /**
     * create favorite
     * @param: {array} favorite Data
     */
    public function create_Favorite(array $data) {
        $q = $this->db->insert('fav_produk', $data);
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
            $this->db->delete('fav_produk', $data);
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
        if($produkId != ''){
            $this->db->where('produkid', $produkId);
        }
        if($userId != ''){
            $this->db->where('userid',$userId);
        }
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
