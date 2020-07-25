<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Kota extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load Kota Model
        $this->load->model('Kota_model', 'Kota_Model');
        $this->load->library('crypt'); 
    }

    /**
     * Kota Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kota/getAll
     */
    public function getAllByParam_get()
    {
        header("Access-Control-Allow-Origin: *");
        
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $query_param = $_GET;
            $data = $this->Kota_Model->getAllByParam($query_param);
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
     * create
     * --------------------
     * --------------------------
     * @method : POST
     * @link: api/Kota/getAll
     */
    public function create_post()
    {
        header("Access-Control-Allow-Origin: *");
        
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $body = $_POST;
            $data = $this->Kota_Model->create($body);
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
     * update
     * --------------------
     * --------------------------
     * @method : PUT
     * @link: api/Kota/update
     */
    public function update_post()
    {
        header("Access-Control-Allow-Origin: *");
        
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $body = $_POST;
            $data = $this->Kota_Model->update($body);
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
     * delete
     * --------------------
     * --------------------------
     * @method : PUT
     * @link: api/Kota/update
     */
    public function delete_post()
    {
        header("Access-Control-Allow-Origin: *");
        
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $body = $_POST;
            $data = $this->Kota_Model->delete($body);
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
}