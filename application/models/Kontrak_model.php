<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak_Model extends CI_Model
{
    protected $Kontrak_table = 't_kontrak';
   
    //  * Use Registration
    //  * @param: {array} Kontrak Data
    //  */
    public function createIncoive_Kontrak($produkid,$kontrakbody,$userid_owner,$userid_worker)
    {
        $q = $this->db->query("insert into t_kontrak (produkid,kontrakbody,userid_owner,userid_worker) values ('$produkid','$kontrakbody','$userid_owner','$userid_worker')");
        return $q;
    }

    /**
     * Kontrak Login
     * ----------------------------------
     * @param: Kontrakname or email address
     * @param: password
     */
    public function getKontrakByParam_Kontrak($produkid='',$kontrakid='',$userid_worker='',$userid_owner='')
    {
        if ($produkid != '') {
            $this->db->where('produkid', $produkid);
        }
        if ($kontrakid != '') {
            $this->db->where('kontrakid', $kontrakid);
        }
        if ($userid_worker != '') {
            $this->db->where('userid_worker', $userid_worker);
        }
        if ($userid_owner != '') {
            $this->db->where('userid_owner', $userid_owner);
        }
        $this->db->order_by("kontrakid", "desc");
        $q = $this->db->get('v_kontrak');
        return $q->row();
    }

      /**
     * getALlKontrakByParam
     * ----------------------------------
     * @param: Kontrakname or email address
     * @param: $produkid='',$kontrakid='',$userid_worker='',$userid_owner=''
     */
    public function getAllKontrakByParam_Kontrak($produkid='',$kontrakid='',$userid_worker='',$userid_owner='')
    {
        if ($produkid != '') {
            $this->db->where('produkid', $produkid);
        }
        if ($kontrakid != '') {
            $this->db->where('kontrakid', $kontrakid);
        }
        if ($userid_worker != '') {
            $this->db->where('userid_worker', $userid_worker);
        }
        if ($userid_owner != '') {
            $this->db->where('userid_owner', $userid_owner);
        }
        $this->db->order_by("kontrakid", "desc");
        $q = $this->db->get('v_kontrak');
        return $q->result();
    }
    /**
     * SubKontrak get data by id
     * ----------------------------------
     * @param: SubKontrak get by id
     */
    public function getById_Kontrak($id)
    {
        $this->db->where('Kontrakid', $id);
        $this->db->where('Kontrakaktif', '1');
        $q = $this->db->get($this->Kontrak_table);
        return $q->result();
    }
    /**
     * SubKontrak get data by id
     * ----------------------------------
     * @param: SubKontrak get by id
     */
    public function chekUserKontrakding_Kontrak($produkid, $userid)
    {
        $this->db->where('userid', $userid);
        $this->db->where('produkid', $produkid);
        $q = $this->db->get($this->Kontrak_table);
        if (count($q->result()) <= 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * getCount Kontrak By user
     * ----------------------------------
     * @param: $userId
     */
    public function getCountByUserId_Kontrak($userId)
    {
        $q = $this->db->query("select getCountKontrakByUserid('$userId') as count");
        return $q->row();
    }

    /**
     * Get Kontrak by user id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/getByUserIdAndStatusId
     */
    public function getByUserIdAndStatusId_Kontrak($userid = '', $statusid = '')
    {
        if ($userid != '') {
            $this->db->where('userid', $userid);
        }
        if ($statusid != '') {
            $this->db->where('statusid', $statusid);
        }
        $q = $this->db->get('v_Kontrak');
        return $q->result();
    }
    /**
     * Get Kontrak by produk id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/getByUserIdAndStatusId
     */
    public function getKontrakByProdukId_Kontrak($produkid)
    {
        $this->db->where('produkid', $produkid);
        $q = $this->db->get('v_kontrak');
        return $q->row();
    }

     /**
     * update Kontrak
     * @param array($data);
     * ----------------------------------
     */
    public function updateKontrak_Kontrak($produkid,$kontrakbody,$userid_owner,$userid_worker,$kontrakid)
    {
        // $this->db->where('kontrakid', $kontrakid);
        $q =  $this->db->query("update t_kontrak set produkid = '$produkid', kontrakbody = '$kontrakbody' where kontrakid = '$kontrakid' ");
        return $q;
    }
}
