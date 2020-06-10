<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class JenisPengajuan extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load JenisPengajuan Model
        $this->load->model('JenisPengajuan_model', 'JenisPengajuan_Model');
        $this->load->library('crypt'); 
    }

    /**
     * JenisPengajuan Get All Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/JenisPengajuan/getAll
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
            $data = $this->JenisPengajuan_Model->getAll_JenisPengajuan();
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
     * JenisPengajuan Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : JenisPengajuanakses
     * @link: api/JenisPengajuan/getAllByFilterParam
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
            $data = $this->JenisPengajuan_Model->getAllByFilterParam_JenisPengajuan($akses);
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
     * JenisPengajuan Get Data All By id 
     * --------------------
     * --------------------------
     * @method : GET
     * @param : JenisPengajuanid
     * @link: api/JenisPengajuan/getAllById
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
            $data = $this->JenisPengajuan_Model->getById_JenisPengajuan($id);
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