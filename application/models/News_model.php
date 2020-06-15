<?php defined('BASEPATH') or exit('No direct script access allowed');

class News_Model extends CI_Model
{
    protected $News_table = 'news';

    /**
     * Use Registration
     * @param: {array} News Data
     */
    public function insert_News(array $data)
    {
        $this->db->insert($this->News_table, $data);
        return $this->db->insert_id();
    }

    /**
     * News Login
     * ----------------------------------
     * @param: Newsname or email address
     * @param: password
     */
    public function getAll_News()
    {
        $this->db->where('newsaktif', '1');
        $q = $this->db->get($this->News_table);
        return $q->result();
    }
    /**
     * SubNews get data by id
     * ----------------------------------
     * @param: SubNews get by id
     */
    public function getById_News($id = '')
    {
        if ($id != '') {
            $this->db->where('newsid', $id);
        }
        $this->db->where('newsaktif', '1');
        $q = $this->db->get($this->News_table);
        return $q->row();
    }
}
