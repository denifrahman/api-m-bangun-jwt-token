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
        $output = $this->Kontrak_Model->updateKontrak_Kontrak($produkid,$kontrakbody,$userid_owner,$userid_worker,$kontrakid);
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
        $output = $this->Kontrak_Model->createIncoive_Kontrak($produkid,$kontrakbody,$userid_owner,$userid_worker);
        $message = array(
            'status' => $output
        );
        $this->response($message);
    }


    /**
     * Get Kontrak by produk id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kontrak/getByUserIdAndStatusId
     */
    public function getKontrakByProdukId_get($produkid)
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        if (!empty($produkid)) {
            $data = $this->Kontrak_Model->getKontrakByProdukId_Kontrak($produkid);
            $message = array(
                'status' => true,
                'data' => $data
            );
            $this->response($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'gagal',
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function pdf_get()
    {
        $produkid = $this->get('id', TRUE);
        $this->load->library('Pdf');
        $data['kontrak'] = $this->Kontrak_Model->getKontrakByProdukId_Kontrak($produkid);
            // var_dump($data['kontrak']);
            // die;
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-petanikode.pdf";
        $this->pdf->load_view('Pdf', $data);
    }
}
