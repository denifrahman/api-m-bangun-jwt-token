<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Favorite extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load Favorite Model
        $this->load->model('Favorite_model', 'Favorite_Model');
        $this->load->library('crypt');
    }

    /**
     * Add new Favorite with API
     * -------------------------
     * @method: POST
     */
    public function createFavorite_post()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {
            # Create a User Favorite

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);

            # Form Validation
            $this->form_validation->set_rules('userid', 'User_Id', 'trim|required');
            $this->form_validation->set_rules('produkid', 'produkId', 'trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
            else
            {
                // Load Favorite Model
                $this->load->model('Favorite_model', 'Favorite_Model');

                $insert_data = [
                    'userid' => $this->input->post('userid'),
                    'produkid' => $this->input->post('produkid')
                ];

                // Insert Favorite
                $output = $this->Favorite_Model->create_Favorite($insert_data);

                if ($output > 0 AND !empty($output))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Favorite Add"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Favorite not create"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Favorite Get All Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Favorite/getAll
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
            $data = $this->Favorite_Model->getAll_Favorite();
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
     * Favorite Get Data Filter Param
     * --------------------
     * --------------------------
     * @method : GET
     * @param : produkFavoriteakses
     * @link: api/Favorite/getAllByFilterParam
     */
    public function getAllByFilterParam_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');
        $produkId = $this->get('pro_id');
        $userId = $this->get('userid');
        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Favorite_Model->getAllByFilterParam_Favorite($produkId, $userId);
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
     * Delete an Favorite with API
     * @method: DELETE
     */
    public function deleteFavorite_post()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {
            # Delete a User Favorite

            # Form Validation
            $this->form_validation->set_rules('userid', 'User_Id', 'trim|required');
            $this->form_validation->set_rules('produkid', 'produkId', 'trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
            else
            {
                // Load Favorite Model
                $this->load->model('Favorite_model', 'Favorite_Model');

                $delete_Favorite = [
                    'userid' => $this->input->post('userid'),
                    'produkid' => $this->input->post('produkid'),
                ];

                // Delete an Favorite
                $output = $this->Favorite_Model->delete_Favorite($delete_Favorite);

                if ($output > 0 AND !empty($output))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Favorite Deleted"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Favorite not delete"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


}
