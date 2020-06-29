<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Bid extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bid_model', 'Bid_Model');
    }

    /**
     * Add new Pelatihan kerja with API
     * -------------------------
     * @method: POST
     */
    public function addBidByUserId_post()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            # Create a User Bids

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);

            # Form Validation
            $this->form_validation->set_rules('userid', 'UserId', 'trim|required');
            $this->form_validation->set_rules('bidprice', 'bidprice', 'trim|required');
            $this->form_validation->set_rules('biddeskripsi', 'biddeskripsi', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            } else {

                $insert_data = [
                    'userid' => $this->input->post('userid'),
                    'bidprice' => $this->input->post('bidprice', TRUE),
                    'biddeskripsi' => $this->input->post('biddeskripsi', TRUE),
                    'produkid' => $this->input->post('produkid', TRUE),
                    'bidwaktupengerjaan' => $this->input->post('bidwaktupengerjaan', TRUE)
                ];

                // Insert Bids
                $output = $this->Bid_Model->insert_Bid($insert_data);

                if ($output > 0 and !empty($output)) {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Bids Add"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Bids not create"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete an Bids with API
     * @method: DELETE
     */
    public function deleteBids_delete($id)
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            # Delete a User Bids

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $id = $this->security->xss_clean($id);

            if (empty($id) and !is_numeric($id)) {
                $this->response(['status' => FALSE, 'message' => 'Invalid Bids ID'], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $delete_Bids = [
                    'id' => $id,
                    'user_id' => $is_valid_token['data']->id,
                ];

                // Delete an Bids
                $output = $this->BidsModel->delete_Bids($delete_Bids);

                if ($output > 0 and !empty($output)) {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Bids Deleted"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Bids not delete"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update an Bids with API
     * @method: PUT
     */
    public function updateBids_put()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            # Update a User Bids


            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);

            $this->form_validation->set_data([
                'id' => $this->input->post('id', TRUE),
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
            ]);

            # Form Validation
            $this->form_validation->set_rules('id', 'Bids ID', 'trim|required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');
            if ($this->form_validation->run() == FALSE) {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            } else {
                // Load Bids Model
                $this->load->model('Bid_model', 'BidsModel');

                $update_data = [
                    'user_id' => $is_valid_token['data']->id,
                    'id' => $this->input->post('id', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                ];

                // Update an Bids
                $output = $this->Bid_Model->update_Bids($update_data);

                if ($output > 0 and !empty($output)) {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Bids Updated"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Bids not update"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Bid chek is bidding
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Bid/chekUserBidding
     */
    public function chekUserBidding_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $produkid = $this->get('produkId');
            $userid = $this->get('userId');
            $data = $this->Bid_Model->chekUserBidding_Bid($produkid, $userid);
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
     * Get Bid by user id
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Bid/getByUserIdAndStatusId
     */
    public function getByUserIdAndStatusId_get()
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $userid = $this->get('userid');
            $statusid = $this->get('statusid');
            $data = $this->Bid_Model->getByUserIdAndStatusId_Bid($userid, $statusid);
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
