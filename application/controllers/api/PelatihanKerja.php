<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class PelatihanKerja extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * Add new Pelatihan kerja with API
     * -------------------------
     * @method: POST
     */
    public function insertPelatihanKerja_post()
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
            # Create a User PelatihanKerja

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            
            # Form Validation
            $this->form_validation->set_rules('userid', 'UserId', 'trim|required');
            $this->form_validation->set_rules('pkuniversitas', 'pkuniversitas', 'trim|required');
            $this->form_validation->set_rules('pkfakultas', 'pkfakultas', 'trim|required');
            $this->form_validation->set_rules('pkjurusan', 'pkjurusan', 'trim|required');
            $this->form_validation->set_rules('pkalamat', 'pkalamat', 'trim|required');
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
                // Load PelatihanKerja Model
                $this->load->model('PelatihanKerja_model', 'PelatihanKerjaModel');

                $insert_data = [
                    'userid' => $this->input->post('userid'),
                    'pkfakultas' => $this->input->post('pkfakultas', TRUE),
                    'pkuniversitas' => $this->input->post('pkuniversitas', TRUE),
                    'pkjurusan' => $this->input->post('pkjurusan', TRUE),
                    'pkalamat' => $this->input->post('pkalamat', TRUE),
                ];

                // Insert PelatihanKerja
                $output = $this->PelatihanKerjaModel->insert_PelatihanKerja($insert_data);

                if ($output > 0 AND !empty($output))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "PelatihanKerja Add"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "PelatihanKerja not create"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete an PelatihanKerja with API
     * @method: DELETE
     */
    public function deletePelatihanKerja_delete($id)
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
            # Delete a User PelatihanKerja

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $id = $this->security->xss_clean($id);
            
            if (empty($id) AND !is_numeric($id))
            {
                $this->response(['status' => FALSE, 'message' => 'Invalid PelatihanKerja ID' ], REST_Controller::HTTP_NOT_FOUND);
            }
            else
            {
                // Load PelatihanKerja Model
                $this->load->model('PelatihanKerja_model', 'PelatihanKerjaModel');

                $delete_PelatihanKerja = [
                    'id' => $id,
                    'user_id' => $is_valid_token['data']->id,
                ];

                // Delete an PelatihanKerja
                $output = $this->PelatihanKerjaModel->delete_PelatihanKerja($delete_PelatihanKerja);

                if ($output > 0 AND !empty($output))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "PelatihanKerja Deleted"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "PelatihanKerja not delete"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update an PelatihanKerja with API
     * @method: PUT
     */
    public function updatePelatihanKerja_put()
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
            # Update a User PelatihanKerja


            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);
            
            $this->form_validation->set_data([
                'id' => $this->input->post('id', TRUE),
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
            ]);
            
            # Form Validation
            $this->form_validation->set_rules('id', 'PelatihanKerja ID', 'trim|required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[200]');
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
                // Load PelatihanKerja Model
                $this->load->model('PelatihanKerja_model', 'PelatihanKerjaModel');

                $update_data = [
                    'user_id' => $is_valid_token['data']->id,
                    'id' => $this->input->post('id', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                ];

                // Update an PelatihanKerja
                $output = $this->PelatihanKerjaModel->update_PelatihanKerja($update_data);

                if ($output > 0 AND !empty($output))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "PelatihanKerja Updated"
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "PelatihanKerja not update"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}