<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_Model extends CI_Model
{
    protected $Produk_table = 'v_produk';

    /**
     * Use Registration
     * @param: {array} Produk Data
     */
    public function insert_Produk(array $data) {
        $this->db->insert($this->Produk_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Produk Login
     * ----------------------------------
     * @param: Produkname or email address
     * @param: password
     */
    public function getAllByParam_Produk($idKecamatan = '',$idKota = '',$idProvinsi = '', $idSubKategori = '',$key = '', $userId = '',$stproduk = '')
    {
        if($idKecamatan != ''){
            $this->db->where('id_kecamatan',$idKecamatan);
        }
        if($userId != ''){
            $this->db->where('userid',$userId);
        }
        if($stproduk != ''){
            $this->db->where('statusnama',$stproduk);
        }
        if($idKota != ''){
            $this->db->where('id_kota',$idKota);
        }
        if($idProvinsi != ''){
            $this->db->where('id_provinsi',$idKota);
        }
        if($key != ''){
            $this->db->like('produknama',$key);
        }
        if($idSubKategori != ''){
            $this->db->where('produkkategorisubid',$idSubKategori);
        }
        $this->db->where('Produkaktif','1');
        $q = $this->db->get($this->Produk_table);
        return $q->result();
    }
     /**
     * SubProduk get data by id
     * ----------------------------------
     * @param: SubProduk get by id
     */
    public function getById_Produk($id)
    {
        $this->db->where('Produkid',$id);
        $this->db->where('Produkaktif','1');
        $q = $this->db->get($this->Produk_table);
        return $q->result();
    }
}
