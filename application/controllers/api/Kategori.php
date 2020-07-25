<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Kategori extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Kategori Model
        $this->load->model('kategori_model', 'Kategori_Model');
        $this->load->library('crypt');
    }

     /**
     * Kategori Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kategori/getAll
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
            $data = $this->Kategori_Model->getAllByParam($query_param);
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
     * @link: api/Kategori/getAll
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
            $data = $this->Kategori_Model->create($body);
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
     * @link: api/Kategori/update
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
            $data = $this->Kategori_Model->update($body);
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
     * @link: api/Kategori/update
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
            $data = $this->Kategori_Model->delete($body);
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
