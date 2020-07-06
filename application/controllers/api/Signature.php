<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Signature extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Signature Model
        $this->load->model('Signature_model', 'Signature_Model');
        $this->load->library('crypt');
    }

    /**
     * Simpan base64 to Image file
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Signature/base64_to_jpeg
     */
    function base64_to_jpeg_post()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $image_name = 'signatured_'.$this->input->post('image_name');
            $userid_owner = $this->input->post('userid_owner');
            $userid_worker = $this->input->post('userid_worker');
            $kontrakid = $this->input->post('kontrakid');
            $image = base64_decode($this->input->post("image_base64_string"));
            // decoding base64 string value
            $filename = $image_name . '.' . 'png';
            //rename file name with random number
            $path = 'assets/';
            //image uploading folder path
            file_put_contents($path . $filename, $image);
            // image is bind and upload to respective folder
            // print_r(file_put_contents($path . $filename, $image));
            // die;
            $data = $this->Signature_Model->update_signature($kontrakid,$userid_owner,$userid_worker,$filename);
            $last = $this->db->last_query();
            $message = array(
                'status' => true,
                'message'=> 'signature berhasil di tambahkan',
                'last_query'=>$last
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
