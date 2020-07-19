<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bid_Model extends CI_Model
{
    protected $Bid_table = 't_bids';
    public $column_order = array('statusnama', 'produknama', 'produkbudget', 'bidprice', 'bidcreate'); //set column field database for datatable orderable
    public $column_search = array('statusnama', 'produknama', 'produkbudget', 'bidprice', 'bidcreate'); //set column field database for datatable searchable
    public $order = array('bidcreate' => 'desc'); // defau

    /*
    Fungsi : mengambil data sesuai parameter
    Parameter :
    - $param : Berupa nama kolom ( String )
    - $id : Berupa value dari kolom ( String )
    - $limit : Berupa limitasi untuk row yang diambil ( int )
    Return : Array(Array())
     */
    private function _get_datatables_query($status = '')
    {
        if ($status != '') {
            if ($status == 'New' || $status == 'Kontrak' || $status == 'Progress' || $status == 'Negosiasi') {
                $this->db->where('statusnama !=', 'Batal');
                $this->db->where('statusnama !=', 'Ditolak');
            } else if ($status == 'Ditolak' || $status == 'Batal') {
                $this->db->where('statusnama', $status);
            }
        }
        $this->db->from('v_bid');
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
    public function get_all($status)
    {
        $this->_get_datatables_query($status);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($status)
    {
        $this->_get_datatables_query($status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($status)
    {
        if ($status != '') {
            if ($status == 'New' || $status == 'Kontrak' || $status == 'Progress' || $status == 'Negosiasi') {
                $this->db->where('statusnama !=', 'Batal');
                $this->db->where('statusnama !=', 'Ditolak');
            } else if ($status == 'Ditolak' || $status == 'Batal') {
                $this->db->where('statusnama', 'Batal');
                $this->db->where('statusnama', 'Ditolak');
            }
        }
        $this->db->from('v_bid');
        return $this->db->count_all_results();
    }
    /**
     * Use Registration
     * @param: {array} Bid Data
     */
    public function insert_Bid(array $data)
    {
        $this->db->insert($this->Bid_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Bid Login
     * ----------------------------------
     * @param: Bidname or email address
     * @param: password
     */
    public function getAllByParam_Bid($idKecamatan = '', $idKota = '', $idProvinsi = '', $idSubKategori = '', $key = '', $userId = '', $stBid = '', $BidId = '')
    {
        if ($idKecamatan != '') {
            $this->db->where('id_kecamatan', $idKecamatan);
        }
        if ($userId != '') {
            $this->db->where('userid', $userId);
        }
        if ($BidId != '') {
            $this->db->where('Bidid', $BidId);
        }
        if ($stBid != '') {
            $this->db->where('statusnama', $stBid);
        }
        if ($idKota != '') {
            $this->db->where('id_kota', $idKota);
        }
        if ($idProvinsi != '') {
            $this->db->where('id_provinsi', $idProvinsi);
        }
        if ($key != '') {
            $this->db->like('Bidnama', $key);
            $this->db->where('Bidstatusid', '3');
        }
        if ($idSubKategori != '') {
            $this->db->where('Bidkategorisubid', $idSubKategori);
            $this->db->where('Bidstatusid', '3');
            $this->db->where('Bidaktif', '1');
        }
        $this->db->order_by("Bidid", "desc");

        $q = $this->db->get($this->Bid_table);
        return $q->result();
    }
    /**
     * SubBid get data by id
     * ----------------------------------
     * @param: SubBid get by id
     */
    public function getById_Bid($id)
    {
        $this->db->where('Bidid', $id);
        $this->db->where('Bidaktif', '1');
        $q = $this->db->get($this->Bid_table);
        return $q->result();
    }
    /**
     * SubBid get data by id
     * ----------------------------------
     * @param: SubBid get by id
     */
    public function getBidByParam_Bid($produkid = '', $userid = '', $bidid = '', $bidstatusid = '',$statusnama = '')
    {
        if ($produkid != '') {
            $this->db->where('produkid', $produkid);
        }
        if ($userid != '') {
            $this->db->where('userid', $userid);
        }
        if ($bidid != '') {
            $this->db->where('bidid', $bidid);
        }
        if ($bidstatusid != '') {
            $this->db->where('bidstatusid', $bidstatusid);
        }
        if ($statusnama != '') {
            $this->db->where('statusnama', $statusnama);
        }
        $this->db->where('statusnama !=', 'Ditolak');
        $this->db->where('statusnama !=', 'Batal');
        $q = $this->db->get('v_bid');
        return $q->result();
    }
    /**
     * getCount Bid By user
     * ----------------------------------
     * @param: $userId
     */
    public function getCountByUserId_Bid($userId)
    {
        $q = $this->db->query("select getCountBidByUserid('$userId') as count");
        return $q->row();
    }

    /**
     * Get Bid by user id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Bid/getByUserIdAndStatusId
     */
    public function getByUserIdAndStatusId_Bid($userid = '', $statusid = '')
    {
        if ($userid != '') {
            $this->db->where('userid', $userid);
        }
        if ($statusid != '') {
            $this->db->where('bidstatusid', $statusid);
        }
        $q = $this->db->get('v_bid');
        return $q->result();
    }
    /**
     * Get Bid by produk id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Bid/getByUserIdAndStatusId
     */
    public function getBidByProdukId_Bid($produkid)
    {
        $this->db->where('produkid', $produkid);
        // $this->db->where('statusnama', 'Kontrak')->or_where('statusnama','Progress');
        // $this->db->where('statusnama', 'Progress');
        // $this->db->where('statusnama', 'Finish');
        $q = $this->db->get('v_bid');
        return $q->row();
    }

    /**
     * update Bid
     * @param array($data);
     * ----------------------------------
     */
    public function updateStatus_Bid($data)
    {
        $this->db->where('bidid', $data->bidid);
        $q =  $this->db->update('t_bids', $data);
        return $q;
    }
}
