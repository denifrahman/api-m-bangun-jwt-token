<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produk_Model extends CI_Model
{
    protected $produk_table = 'v_produk';
    public $column_order = array('produknama', 'usernamalengkap', 'produkalamat', 'produkwaktupengerjaan', 'produkthumbnail','produkfoto1'); //set column field database for datatable orderable
    public $column_search = array('produknama', 'usernamalengkap', 'produkalamat', 'produkwaktupengerjaan', 'produkthumbnail','produkfoto1'); //set column field database for datatable searchable
    public $order = array('produkcreate' => 'desc'); // defau


    /**
     * Use Registration
     * @param: {array} Produk Data
     */
    public function insert_Produk(array $data)
    {
        $this->db->insert($this->produk_table, $data);
        return $this->db->insert_id();
    }

    /*
    Fungsi : mengambil data sesuai parameter
    Parameter :
    - $param : Berupa nama kolom ( String )
    - $id : Berupa value dari kolom ( String )
    - $limit : Berupa limitasi untuk row yang diambil ( int )
    Return : Array(Array())
     */
    private function _get_datatables_query($aktif, $status = '')
    {
        if ($status != '') {
            $this->db->where('statusnama', $status);
        }
        $this->db->where('produkaktif', $aktif);
        $this->db->from($this->produk_table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function get_all($aktif, $status)
    {
        $this->_get_datatables_query($aktif, $status);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($aktif, $status)
    {
        $this->_get_datatables_query($aktif, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($aktif, $status)
    {
        if ($status != '') {
            $this->db->where('statusnama', $status);
        }
        $this->db->where('produkaktif', $aktif);
        $this->db->from($this->produk_table);
        return $this->db->count_all_results();
    }
    /*
    Fungsi : mengambil data sesuai parameter
    Parameter :
    - $param : Berupa nama kolom ( String )
    - $id : Berupa value dari kolom ( String )
    - $limit : Berupa limitasi untuk row yang diambil ( int )
    Return : Array(Array())
     */
    private function _get_datatables_query_by_userid($aktif, $status = '', $userid)
    {
        if ($status != '') {
            $this->db->where('statusnama', $status);
        }
        $this->db->where('produkaktif', $aktif);
        $this->db->where('produkkategoriflag', '2');
        $this->db->where('userid', $userid);
        $this->db->from($this->produk_table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function get_all_by_userid($aktif, $status , $userid)
    {
        $this->_get_datatables_query_by_userid($aktif, $status , $userid);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_by_userid($aktif, $status, $userid)
    {
        $this->_get_datatables_query($aktif, $status, $userid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_by_userid($aktif, $status , $userid)
    {
        if ($status != '') {
            $this->db->where('statusnama', $status);
        }
        $this->db->where('userid', $userid);
        $this->db->where('produkaktif', $aktif);
        $this->db->where('produkkategoriflag', '2');
        $this->db->from($this->produk_table);
        return $this->db->count_all_results();
    }

    /**
     * Produk Login
     * ----------------------------------
     * @param: Produkname or email address
     * @param: password
     */
    public function getAllByParam_Produk($idKecamatan = '', $idKota = '', $idProvinsi = '', $idSubKategori = '', $key = '', $userId = '', $stproduk = '', $produkId = '')
    {
        if ($idKecamatan != '') {
            $this->db->where('id_kecamatan', $idKecamatan);
        }
        if ($userId != '') {
            $this->db->where('userid', $userId);
        }
        if ($produkId != '') {
            $this->db->where('produkid', $produkId);
        }
        if ($stproduk != '') {
            $this->db->where('statusnama', $stproduk);
        }
        if ($idKota != '') {
            $this->db->where('id_kota', $idKota);
        }
        if ($idProvinsi != '') {
            $this->db->where('id_provinsi', $idProvinsi);
        }
        if ($key != '') {
            $this->db->like('produknama', $key);
            $this->db->where('Produkstatusid', '3');
        }
        if ($idSubKategori != '') {
            $this->db->where('produkkategorisubid', $idSubKategori);
            $this->db->where('Produkstatusid', '3');
            $this->db->where('Produkaktif', '1');
        }
        $this->db->order_by("produkid", "desc");

        $q = $this->db->get($this->produk_table);
        return $q->result();
    }
    /**
     * SubProduk get data by id
     * ----------------------------------
     * @param: SubProduk get by id
     */
    public function getById_Produk($id)
    {
        $this->db->where('Produkid', $id);
        $q = $this->db->get($this->produk_table);
        return $q->result();
    }
    /**
     * getCount Produk By user
     * ----------------------------------
     * @param: $userId
     */
    public function getCountByUserId_Produk($userId)
    {
        $q = $this->db->query("select getCountProdukByUserid('$userId') as count");
        return $q->row();
    }
 
    /**
     * getAll By nama
     * ----------------------------------
     */
    public function getAllByNama_Produk($nama = '')
    {
        // $q = $this->db->query("select * from v_produk where statusnama = 'NEW' AND produkaktif = '0'");
        $this->db->order_by('produkcreate', 'desc');
        if ($nama != '') {
            $this->db->like('produknama', urldecode($nama));
        }
        $q = $this->db->get($this->produk_table);
        return $q->result();
    }

    /**
     * Count Produk
     * ----------------------------------
     */
    public function getCount_Produk()
    {
        $q =  $this->db->query("select count(produkid) as count from v_produk");
        return $q->row();
    }
    /**
     * create Produk
     * @param array($data);
     * ----------------------------------
     */
    public function create_Produk($data)
    {
        $q =  $this->db->insert('produk', $data);
        return $q;
    }
    /**
     * update Status Produk
     * @param array($data);
     * ----------------------------------
     */
    public function updateStatus_Produk($data)
    {
        $this->db->where('produkid', $data['produkid']);
        $q =  $this->db->update('produk', $data);
        return $q;
    }
    /**
     * update Produk
     * @param array($data);
     * ----------------------------------
     */
    public function update_Produk($data)
    {
        $this->db->where('produkid', $data['produkid']);
        $q =  $this->db->update('produk', $data);
        return $q;
    }
}
