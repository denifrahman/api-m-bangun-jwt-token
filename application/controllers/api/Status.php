<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Status extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load Status Model
        $this->load->model('Status_model', 'Status_Model');
        $this->load->library('crypt'); 
    }

    /**
     * Status Get All Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Status/getAll
     */
    public function getAll_get()
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        // $is_valid_token = $this->authorization_token->validateToken();
        // if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Status_Model->getAll_Status();
            $message = $data;
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // }else{
            // $message = array(
            //     'status' => $is_valid_token['status'],
            //     'message' => $is_valid_token['message'],
            // );
            // $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // }
    }

     /**
     * Status Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkStatusakses
     * @link: api/Status/getAllByFilterParam
     */
    public function getAllByFilterParam_get()
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        $akses = $this->input->get('akses');
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Status_Model->getAllByFilterParam_Status($akses);
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
     * Status Get Data All By id 
     * --------------------
     * --------------------------
     * @method : GET
     * @param : Statusid
     * @link: api/Status/getAllById
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
            $data = $this->Status_Model->getById_Status($id);
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