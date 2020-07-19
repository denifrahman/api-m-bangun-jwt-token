<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class ChekVersion extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load ChekVersion Model
        $this->load->model('ChekVersion_model', 'ChekVersion_Model');
        $this->load->library('crypt');
    }

    /**
     * ChekVersion Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/ChekVersion/getLastVersion
     */
    public function getLastVersion_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->ChekVersion_Model->getLastVersion_ChekVersion();
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
