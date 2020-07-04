<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Kontrak extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kontrak_model', 'Kontrak_Model');
    }


    /**
     * Produk update Status
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/updateStatus
     */
    public function updateKontrak_post()
    {
        $produkid = addslashes($this->input->post('produkid'));
        $kontrakbody = addslashes($this->input->post('kontrakbody'));
        $userid_worker = addslashes($this->input->post('userid_worker'));
        $userid_owner = addslashes($this->input->post('userid_owner'));
        $kontrakid = addslashes($this->input->post('kontrakid'));
        $data = array(
            'kontrakid' => $kontrakid,
            'produkid' => $produkid,
            'kontrakbody' => $kontrakbody,
            'userid_worker' => $userid_worker,
            'userid_owner' => $userid_owner
        );
        $output = $this->Kontrak_Model->updateKontrak_Kontrak($produkid, $kontrakbody, $userid_owner, $userid_worker, $kontrakid);
        $message = array(
            'status' => $output
        );
        $this->response($message);
    }
    /**
     * Produk add Kontrak
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/updateStatus
     */
    public function createKontrak_post()
    {
        $produkid = addslashes($this->input->post('produkid'));
        $kontrakbody = addslashes($this->input->post('kontrakbody'));
        $userid_worker = addslashes($this->input->post('userid_worker'));
        $userid_owner = addslashes($this->input->post('userid_owner'));
        $data = array(
            'produkid' => $produkid,
            'kontrakbody' => $kontrakbody,
            'userid_worker' => $userid_worker,
            'userid_owner' => $userid_owner
        );
        $output = $this->Kontrak_Model->createIncoive_Kontrak($produkid, $kontrakbody, $userid_owner, $userid_worker);
        $message = array(
            'status' => $output
        );
        $this->response($message);
    }


    /**
     * Get Kontrak param
     * response data objek
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/getKontrakByParam?
     */

    public function getKontrakByParam_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $produkid = $this->get('produkId');
            $kontrakid = $this->get('kontrakId');
            $userid_worker = $this->get('userIdWorker');
            $userid_owner = $this->get('userIdOwner');
            $data = $this->Kontrak_Model->getKontrakByParam_Kontrak($produkid,$kontrakid,$userid_worker,$userid_owner);
            $message = array(
                'status' => true,
                'data' => $data
            );
            $this->response($message);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    /**
     * Get Kontrak param
     * response data array
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/getAllKontrakByParam?
     */

    public function getAllKontrakByParam_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $produkid = $this->get('produkId');
            $kontrakid = $this->get('kontrakId');
            $userid_worker = $this->get('userIdWorker');
            $userid_owner = $this->get('userIdOwner');
            $data = $this->Kontrak_Model->getKontrakByParam_Kontrak($produkid,$kontrakid,$userid_worker,$userid_owner);
            $message = array(
                'status' => true,
                'data' => $data
            );
            $this->response($message);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Get Kontrak pdf by id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/pdf?id=''
     */
    public function pdf_get()
    {
        $produkid = $this->get('id', TRUE);
        $this->load->library('pdf');
        $data['kontrak'] = $this->Kontrak_Model->getKontrakByProdukId_Kontrak($produkid);
        // var_dump($data['kontrak']);
        // die;
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-petanikode.pdf";
        $this->pdf->load_view('Pdf', $data);
    }
}
