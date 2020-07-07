<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Invoice extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_model', 'Invoice_Model');
    }

    
    /**
     * Produk update Status
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Invoice/updateStatus
     */
    public function updateInvoice_post()
    {
        $data  = file_get_contents('php://input');
        $output = $this->Invoice_Model->updateInvoice_Invoice(json_decode($data));
        $message = array(
            'status' => $output
        );
        $this->response($message);
    }
    /**
     * Produk add invoice
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Invoice/updateStatus
     */
    public function createInvoice_post()
    {
        $data  = file_get_contents('php://input');
        $output = $this->Invoice_Model->createIncoive_Invoice(json_decode($data));
        $message = array(
            'status' => $output
        );
        $this->response($message);
    }

    
    /**
     * Get Invoice by produk id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Invoice/getByUserIdAndStatusId
     */
    public function getAllInvoiceByParam_get()
    {
        header("Access-Control-Allow-Origin: *");

         // Load Authorization Token Library
         $this->load->library('Authorization_Token');

         /**
          * User Token Validation
          */
         $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE) {
            $invoiceid = $this->get('invoiceId');
            $invoice_status = $this->get('invoiceStatus');
            $invoice_tgl_bayar = $this->get('invoiceTglBayar');
            $invoice_nominal = $this->get('invoiceNominal');
            $invoice_termin = $this->get('invoiceTermin');
            $userid = $this->get('userId');
            $produkid = $this->get('produkId');
            $data = $this->Invoice_Model->getAllByParam_Invoice($invoiceid,$produkid,$invoice_status,$invoice_tgl_bayar,$invoice_nominal,$invoice_termin,$userid);
            // $last=$this->db->query_last();
            $message = array(
                'status' => true,
                'data' => $data,
                // 'last'=>$last
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => false,
                'message' => 'gagal',
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
