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
     * Kategori Get All Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kategori/getAll
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
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->Kategori_Model->getAll_Kategori();
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Kategori Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : Kategorikategoriakses
     * @link: api/Kategori/getAllByFilterParam
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
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->Kategori_Model->getAllByFilterParam_Kategori($akses);
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
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
        $produkkategoriid = $this->get('produkkategoriid');
        $produkkategorinama = $this->get('produkkategorinama');
        $produkkategoriaktif = $this->get('produkkategoriaktif');
        $produkkategoriakses = $this->get('produkkategoriakses');
        $produkkategorireq = $this->get('produkkategorireq');
        $produkkategoriflag = $this->get('produkkategoriflag');
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->Kategori_Model->getAllByParam_kategori($produkkategoriid, $produkkategorinama,  $produkkategoriakses, $produkkategorireq, $produkkategoriflag, $produkkategoriaktif);
            $qry = $this->db->last_query();
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data,
                'last' => $qry
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    /**
     * Kategori Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Kategori/getAll
     */
    public function getAllGroupByParam_get()
    {
        $produkkategoriid = $this->get('produkkategoriid');
        $produkkategorinama = $this->get('produkkategorinama');
        $produkkategoriaktif = $this->get('produkkategoriaktif');
        $produkkategoriakses = $this->get('produkkategoriakses');
        $produkkategorireq = $this->get('produkkategorireq');
        $produkkategoriflag = $this->get('produkkategoriflag');
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data =$this->Kategori_Model->getAllByParam_kategori($produkkategoriid, $produkkategorinama,  $produkkategoriakses, $produkkategorireq, $produkkategoriflag, $produkkategoriaktif);
            $tmp = array();

            foreach ($data as $arg) {
                $tmp[$arg->produkkategoriflag][] = $arg;
            }

            $output = array();
            
            foreach ($tmp as $type => $labels) {
                $output[] = array(
                    'flag' => $type,
                    'chilrdern'=>$labels
                );
            }
            // var_dump($output);
            // die;
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $output,
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Kategori Get Data All By id 
     * --------------------
     * --------------------------
     * @method : GET
     * @param : kategoriid
     * @link: api/Kategori/getAllById
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
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->Kategori_Model->getById_Kategori($id);
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $data
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => $is_valid_token['status'],
                'message' => $is_valid_token['message'],
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
