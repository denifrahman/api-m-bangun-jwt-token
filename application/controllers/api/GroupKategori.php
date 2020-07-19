<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class GroupKategori extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load GroupKategori Model
        $this->load->model('GroupKategori_model', 'GroupKategori_Model');
        $this->load->library('crypt');
    }

    /**
     * GroupKategori Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/GroupKategori/getAll
     */
    public function getAllByParam_get()
    {
        $group_kategori_id = $this->get('GroupKategori_id');
        $group_nama = $this->get('group_nama');
        $thumbnail = $this->get('thumbnail');
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->GroupKategori_Model->getAllByParam_GroupKategori($group_kategori_id,$group_nama,$thumbnail);
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
