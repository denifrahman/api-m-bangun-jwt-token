<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class SubKategori extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load SubKategori Model
        $this->load->model('SubKategori_model', 'SubKategori_Model');
        $this->load->library('crypt'); 
    }

    /**
     * SubKategori Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/SubKategori/getAll
     */
    public function getAll_get()
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->SubKategori_Model->getAll_SubKategori();
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
    /**
     * SubKategori Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/SubKategori/getAll
     */
    public function getAllByIdKategori_get($id)
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->SubKategori_Model->getAllByIdKategori_SubKategori($id);
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