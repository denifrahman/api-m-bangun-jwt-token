<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_Model extends CI_Model
{
    protected $Pengajuan_table = 'produk';

    /**
     * Use Registration
     * @param: {array} Pengajuan Data
     */
    public function insert_Pengajuan(array $data) {
        return $this->db->insert($this->Pengajuan_table, $data);
    }

    /**
     * Pengajuan Login
     * ----------------------------------
     * @param: Pengajuanname or email address
     * @param: password
     */
    public function getAllByParam_Pengajuan($idKecamatan = '',$idKota = '',$idProvinsi = '', $idSubKategori = '',$key = '')
    {
        if($idKecamatan != ''){
            $this->db->where('id_kecamatan',$idKecamatan);
        }
        if($idKota != ''){
            $this->db->where('id_kota',$idKota);
        }
        if($idProvinsi != ''){
            $this->db->where('id_provinsi',$idKota);
        }
        if($key != ''){
            $this->db->like('Pengajuannama',$key);
        }
        if($idSubKategori != ''){
            $this->db->where('Pengajuankategorisubid',$idSubKategori);
        }
        $this->db->where('Pengajuanaktif','1');
        $q = $this->db->get($this->Pengajuan_table);
        return $q->result();
    }
     /**
     * SubPengajuan get data by id
     * ----------------------------------
     * @param: SubPengajuan get by id
     */
    public function getById_Pengajuan($id)
    {
        $this->db->where('Pengajuanid',$id);
        $this->db->where('Pengajuanaktif','1');
        $q = $this->db->get($this->Pengajuan_table);
        return $q->result();
    }
}
