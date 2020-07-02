<?php defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_Model extends CI_Model
{
    protected $Invoice_table = 't_invoice';
   
    //  * Use Registration
    //  * @param: {array} Invoice Data
    //  */
    public function createIncoive_Invoice($data)
    {
        $q = $this->db->insert($this->Invoice_table, $data);
        return $q;
    }

    /**
     * Invoice Login
     * ----------------------------------
     * @param: Invoicename or email address
     * @param: password
     */
    public function getAllByParam_Invoice($idKecamatan = '', $idKota = '', $idProvinsi = '', $idSubKategori = '', $key = '', $userId = '', $stInvoice = '', $InvoiceId = '')
    {
        if ($idKecamatan != '') {
            $this->db->where('id_kecamatan', $idKecamatan);
        }
        if ($userId != '') {
            $this->db->where('userid', $userId);
        }
        if ($InvoiceId != '') {
            $this->db->where('Invoiceid', $InvoiceId);
        }
        if ($stInvoice != '') {
            $this->db->where('statusnama', $stInvoice);
        }
        if ($idKota != '') {
            $this->db->where('id_kota', $idKota);
        }
        if ($idProvinsi != '') {
            $this->db->where('id_provinsi', $idProvinsi);
        }
        if ($key != '') {
            $this->db->like('Invoicenama', $key);
            $this->db->where('Invoicestatusid', '3');
        }
        if ($idSubKategori != '') {
            $this->db->where('InvoicekategorisuInvoice', $idSubKategori);
            $this->db->where('Invoicestatusid', '3');
            $this->db->where('Invoiceaktif', '1');
        }
        $this->db->order_by("Invoiceid", "desc");

        $q = $this->db->get($this->Invoice_table);
        return $q->result();
    }
    /**
     * SubInvoice get data by id
     * ----------------------------------
     * @param: SubInvoice get by id
     */
    public function getById_Invoice($id)
    {
        $this->db->where('Invoiceid', $id);
        $this->db->where('Invoiceaktif', '1');
        $q = $this->db->get($this->Invoice_table);
        return $q->result();
    }
    /**
     * SubInvoice get data by id
     * ----------------------------------
     * @param: SubInvoice get by id
     */
    public function chekUserInvoiceding_Invoice($produkid, $userid)
    {
        $this->db->where('userid', $userid);
        $this->db->where('produkid', $produkid);
        $q = $this->db->get($this->Invoice_table);
        if (count($q->result()) <= 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * getCount Invoice By user
     * ----------------------------------
     * @param: $userId
     */
    public function getCountByUserId_Invoice($userId)
    {
        $q = $this->db->query("select getCountInvoiceByUserid('$userId') as count");
        return $q->row();
    }

    /**
     * Get Invoice by user id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Invoice/getByUserIdAndStatusId
     */
    public function getByUserIdAndStatusId_Invoice($userid = '', $statusid = '')
    {
        if ($userid != '') {
            $this->db->where('userid', $userid);
        }
        if ($statusid != '') {
            $this->db->where('statusid', $statusid);
        }
        $q = $this->db->get('v_Invoice');
        return $q->result();
    }
    /**
     * Get Invoice by produk id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Invoice/getByUserIdAndStatusId
     */
    public function getInvoiceByProdukId_Invoice($produkid)
    {
        $this->db->where('produkid', $produkid);
        $this->db->order_by('invoiceid','desc');
        $q = $this->db->get('t_invoice');
        return $q->result();
    }

     /**
     * update Invoice
     * @param array($data);
     * ----------------------------------
     */
    public function updateInvoice_Invoice($data)
    {
        $this->db->where('invoiceid', $data->invoiceid);
        $q =  $this->db->update('t_invoice', $data);
        return $q;
    }
}
