<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak_Model extends CI_Model
{
    protected $Kontrak_table = 't_kontrak';
   
    //  * Use Registration
    //  * @param: {array} Kontrak Data
    //  */
    public function createIncoive_Kontrak($data)
    {
        $q = $this->db->insert($this->Kontrak_table, $data);
        return $q;
    }

    /**
     * Kontrak Login
     * ----------------------------------
     * @param: Kontrakname or email address
     * @param: password
     */
    public function getAllByParam_Kontrak($idKecamatan = '', $idKota = '', $idProvinsi = '', $idSubKategori = '', $key = '', $userId = '', $stKontrak = '', $KontrakId = '')
    {
        if ($idKecamatan != '') {
            $this->db->where('id_kecamatan', $idKecamatan);
        }
        if ($userId != '') {
            $this->db->where('userid', $userId);
        }
        if ($KontrakId != '') {
            $this->db->where('Kontrakid', $KontrakId);
        }
        if ($stKontrak != '') {
            $this->db->where('statusnama', $stKontrak);
        }
        if ($idKota != '') {
            $this->db->where('id_kota', $idKota);
        }
        if ($idProvinsi != '') {
            $this->db->where('id_provinsi', $idProvinsi);
        }
        if ($key != '') {
            $this->db->like('Kontraknama', $key);
            $this->db->where('Kontrakstatusid', '3');
        }
        if ($idSubKategori != '') {
            $this->db->where('KontrakkategorisuKontrak', $idSubKategori);
            $this->db->where('Kontrakstatusid', '3');
            $this->db->where('Kontrakaktif', '1');
        }
        $this->db->order_by("Kontrakid", "desc");

        $q = $this->db->get($this->Kontrak_table);
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
