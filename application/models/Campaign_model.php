<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_Model extends CI_Model
{
    protected $campaign_table = 'v_t_anggota';

    /**
     * Use Registration
     * @param: {array} Campaign Data
     */
    public function insert_Campaign(array $data) {
        $this->db->insert($this->campaign_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Campaign Login
     * ----------------------------------
     * @param: Campaignname or email address
     * @param: password
     */
    public function getAll_campaign()
    {
        $q = $this->db->get($this->campaign_table);
        return $q->result();
    }
}
