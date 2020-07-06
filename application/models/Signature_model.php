<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Signature_Model extends CI_Model
{
    protected $Signature_table = 't_kontrak';

    /**
     * Use Registration
     * @param: {array} Signature Data
     */
    public function insert_Signature(array $data) {
        $this->db->insert($this->Signature_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Signature Login
     * ----------------------------------
     * @param: Signaturename or email address
     * @param: password
     */
    public function getAll_Signature($number,$offset)
    {
        $this->db->where('Signatureaktif','1');
        $q = $this->db->get($this->Signature_table,$number,$offset);
        return $q->result();
    }
     /**
     * Count Signature
     * ----------------------------------
     */
    public function getCount_Signature()
    {
        $q =  $this->db->query("select count(Signatureid) as count from m_Signature where Signatureaktif = 1");
        return $q->row();
    }
      /**
     * Signature Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkSignatureakses
     * @link: api/Signature/getAllByFilterParam
     */
    public function getAllByFilterParam_Signature($akses)
    {
        $this->db->where('Signatureaktif','1');
        $q = $this->db->get($this->Signature_table);
        return $q->result();
    }
     /**
     * SubSignature get data by id
     * ----------------------------------
     * @param: SubSignature get by id
     */
    public function update_signature($kontrakid = '',$userid_owner ='',$userid_worker='',$image_name)
    {
        if($userid_worker != ''){
            $q = $this->db->query("update t_kontrak set worker_signature = '$image_name' where kontrakid = '$kontrakid' ");
        }
        if($userid_owner != ''){
            $q = $this->db->query("update t_kontrak set owner_signature = '$image_name' where kontrakid = '$kontrakid' ");
        }
        return $q;
    }
}
