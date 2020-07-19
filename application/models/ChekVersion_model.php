<?php defined('BASEPATH') or exit('No direct script access allowed');

class ChekVersion_Model extends CI_Model
{
    protected $ChekVersion_table = 't_version_app';

    
    public function getLastVersion_ChekVersion()
    {   
        $this->db->order_by('versionid', 'DESC');
        $this->db->limit('1');
        $q = $this->db->get($this->ChekVersion_table);
        return $q->result();
    }
}
