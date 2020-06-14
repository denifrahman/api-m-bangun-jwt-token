<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Produk extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load Produk Model
        $this->load->model('Produk_model', 'Produk_Model');
        $this->load->library('crypt'); 
    }

    /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAll
     */
    public function getAllByParam_get()
    {
        $idKecamatan = $this->get('kec');
        $idKota = $this->get('kota');
        $idProvinsi = $this->get('prov');
        $idSubKategori = $this->get('sub');
        $key = $this->get('key');
        $userId = $this->get('userid');
        $stproduk = $this->get('stp');
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Produk_Model->getAllByParam_Produk($idKecamatan,$idKota,$idProvinsi, $idSubKategori,$key,$userId,$stproduk);
            $qry = $this->db->last_query();
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data,
                'last'=>$qry
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAllById
     */
    public function getAllById_get($id)
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Produk_Model->getById_Produk($id);
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}