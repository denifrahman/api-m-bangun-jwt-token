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
    public function getAllByParam_Invoice($invoiceid='',$produkid='',$invoice_status='',$invoice_tgl_bayar='',$invoice_nominal='',$invoice_termin ='',$userid='')
    {
        if ($invoiceid != '') {
            $this->db->where('invoiceid', $invoiceid);
        }
        if ($produkid != '') {
            $this->db->where('produkid', $produkid);
        }
        if ($invoice_status != '') {
            $this->db->where('invoice_status', $invoice_status);
        }
        if ($invoice_tgl_bayar != '') {
            $this->db->where('invoice_tgl_bayar', $invoice_tgl_bayar);
        }
        if ($invoice_nominal != '') {
            $this->db->where('invoice_nominal', $invoice_nominal);
        }
        if ($invoice_termin != '') {
            $this->db->where('invoice_termin', $invoice_termin);
        }
        if ($userid != '') {
            $this->db->where('userid', $userid);
        }
        
        // $this->db->order_by("invoicreate", "desc");
        // $this->db->where("invoice", "1");
        $q = $this->db->get('v_invoice');
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
