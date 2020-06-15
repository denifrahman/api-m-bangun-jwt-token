<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class News extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load News Model
        $this->load->model('News_model', 'News_Model');
        $this->load->library('crypt'); 
    }

    /**
     * News Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/News/getAll
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
            $data = $this->News_Model->getAll_News();
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
     * News Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/News/getById
     */
    public function getById_get()
    {
        header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $id = $this->get('id');
            $data = $this->News_Model->getById_News($id);
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