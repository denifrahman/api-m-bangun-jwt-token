<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sistem_Model extends CI_Model
{
    protected $Sistem_table = 't_version_app';

    
    public function getAllBank_Sistem()
    {   
        $q = $this->db->get('m_bank_sistem');
        return $q->result();
    }
    public function getAllMetodeTransfer_Sistem()
    {   
        $q = $this->db->get('m_metode_transfer');
        return $q->result();
    }
}
