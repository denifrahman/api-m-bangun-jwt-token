<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Users extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load User Model
        $this->load->model('user_model', 'UserModel');
        $this->load->library('crypt');
    }

    /**
     * User Get Data By Id
     * --------------------
     * --------------------------
     * @method : GET
     * @param: userid
     * @link: api/User/getById
     */
    public function getById_get()
    {
        header("Access-Control-Allow-Origin: *");
        $userid = $this->get('userid');
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->UserModel->getById_user($userid);
            $return_data = array(
                'data_user' => $data,
            );
            $message = array(
                'status' => $is_valid_token['status'],
                'data' => $return_data
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
     * User Register
     * --------------------------
     * @param: usernamalengkap
     * @param: username
     * @param: email
     * @param: password
     * --------------------------
     * @method : POST
     * @link : api/user/register
     */
    public function register_post()
    {
        header("Access-Control-Allow-Origin: *");

        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);

        # Form Validation
        $this->form_validation->set_rules('usernamalengkap', 'Nama lengkap', 'trim|required|max_length[50]');
        $this->form_validation->set_rules(
            'useremail',
            'UserEmail',
            'trim|required|valid_email|max_length[80]|is_unique[user.useremail]',
            array('is_unique' => 'This %s already exists please enter another email address')
        );
        $this->form_validation->set_rules(
            'usertelp',
            'Usertelp',
            'trim|required|max_length[80]|is_unique[user.usertelp]',
            array('is_unique' => 'This %s already exists please enter another phone')
        );
        $this->form_validation->set_rules('userpassword', 'UserPassword', 'trim|required|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            // Form Validation Errors
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $insert_data = array(
                'usernamalengkap' => $this->input->post('usernamalengkap', TRUE),
                'useremail' => $this->input->post('useremail', TRUE),
                'usertelp' => $this->input->post('usertelp', TRUE),
                'userpassword' => $this->crypt->encrypt($this->input->post('userpassword'), 'abcdef0123456789'),
                // 'usercreate' => time(),
                'userfoto' => 'https://previews.123rf.com/images/urfandadashov/urfandadashov1809/urfandadashov180901275/109135379-photo-not-available-vector-icon-isolated-on-transparent-background-photo-not-available-logo-concept.jpg',
                'useraktif' => '1',
                'userstatusid' => '1',
            );

            // Insert User in Database
            $output = $this->UserModel->insert_user($insert_data);
            if ($output > 0 and !empty($output)) {
                // response data
                $response_data = array(
                    'usernamalengkap' => $this->input->post('usernamalengkap', TRUE),
                    'useremail' => $this->input->post('useremail', TRUE),
                    'usertelp' => $this->input->post('usertelp', TRUE),
                    'userpassword' => $this->input->post('userpassword'),
                    'usercreate' => time(),
                    'useraktif' => '1',
                    'userstatusid' => '1',
                );
                // Success 200 Code Send
                $message = array(
                    'status' => true,
                    'message' => "User registration successful",
                    'data' => $response_data
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                // Error
                $message = array(
                    'status' => FALSE,
                    'message' => "Not Register Your Account."
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }


    /**
     * User Login API
     * --------------------
     * @param: username or email
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/users/login
     */
    public function login_post()
    {
        header("Access-Control-Allow-Origin: *");

        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);

        # Form Validation
        $this->form_validation->set_rules('useremail', 'Useremail', 'trim|required');
        $this->form_validation->set_rules('userpassword', 'Userpassword', 'trim|required|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            // Form Validation Errors
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            // Load Login Function
            $output = $this->UserModel->login_user($this->input->post('useremail'), $this->crypt->encrypt($this->input->post('userpassword'), 'abcdef0123456789'));
            if (!empty($output) and $output != FALSE) {
                // Load Authorization Token Library
                $this->load->library('Authorization_Token');

                // Generate Token
                $token_data['id'] = $output->userid;
                $token_data['usernama'] = $output->usernama;
                $token_data['useralamat'] = $output->useralamat;
                $token_data['time'] = time();

                $user_token = $this->authorization_token->generateToken($token_data);

                $return_data = array(
                    'data_user' => $output,
                    'token' => $user_token,
                );

                // Login Success
                $message = array(
                    'status' => true,
                    'data' => $return_data,
                    'message' => "User login successful"
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                // Login Error
                $message = array(
                    'status' => FALSE,
                    'message' => "Invalid Username or Password"
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    /**
     * User Login API
     * --------------------
     * @param: username or email
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/users/loginAdmin
     */
    public function loginAdmin_post()
    {
        header("Access-Control-Allow-Origin: *");

        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);

        # Form Validation

        // Load Login Function

        $output = $this->UserModel->login_user($this->post('data_post')['useremail'], $this->post('data_post')['userpassword']);
        if (!empty($output) and $output != FALSE) {
            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Generate Token
            $token_data['id'] = $output->userid;
            $token_data['usernama'] = $output->usernama;
            $token_data['useralamat'] = $output->useralamat;
            $token_data['time'] = time();

            $user_token = $this->authorization_token->generateToken($token_data);

            $return_data = array(
                'data_user' => $output,
                'token' => $user_token,
            );

            // Login Success
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => "User login successful"
            );
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            // Login Error
            $message = array(
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function createUser_get()
    {
        include_once APPPATH . "vendor/autoload.php";
        // $client = new GetStream\StreamChat\Client(getenv("fjj3mgynqwkg"), getenv("257n6pcwfxchut48vkypxu4ymwzjvpy92bkzw83jkwhe3jwqkpe6qzt58amna9ve"));

        $client = new GetStream\StreamChat\Client('fjj3mgynqwkg', '257n6pcwfxchut48vkypxu4ymwzjvpy92bkzw83jkwhe3jwqkpe6qzt58amna9ve');
        $token = $client->createToken("deni");

        // // with an expiration time
        // $expiration = (new DateTime())->getTimestamp() + 3600;
        // $token = $client->createToken("bob-1", $expiration);
        $bob = array(
            'id' => 'deni',
            'role' => 'admin',
            'name' => 'deni',
        );

        $bob = $client->updateUser($bob);
        $this->response($token, REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * User edit foto
     * --------------------
     * @param: userid
     * --------------------------
     * @method : POST
     * @link: api/users/editFoto
     */

    function editFoto_post()
    {
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            if (isset($_FILES["image"]["name"])) {
                // Make sure you have created this directory already
                $target_dir = "assets/";
                // Generate a random name 
                $userid = $this->input->post('userid');
                $file_name = base_url() . $target_dir . $userid . '.' . $_POST['ext'];
                $target_file = $target_dir . $userid . '.' . $_POST['ext'];
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $response = $this->UserModel->editFotoById_user($userid, $file_name);
                        $message = array(
                            'status' => true,
                            'update' => $response,
                            'message' => "Foto berhasil di ubah"
                        );
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    } else {
                        $this->response('error', REST_Controller::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response('File is not an image', REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("error" => "Please provide a image to upload."), REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update akun
     * --------------------
     * @param: _imageFileSiup, _imageFileAkte, idKategori,idSubKategori, namaPerusahaan
     * --------------------------
     * @method : POST
     * @link: api/users/updateAkunPremium
     */
    function updateAkunPremium_post()
    {
        $this->form_validation->set_rules('userId', 'UserId', 'trim|required');
        $this->form_validation->set_rules('idSubKategori', 'idSubKategori', 'trim|required');
        $this->form_validation->set_rules('idKategori', 'idKategori', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $userid = $this->input->post('userId');
            $idKategori = $this->input->post('idKategori');
            $idSubKategori = $this->input->post('idSubKategori');
            $target_dir = "assets/";
            $file_name_akte = '';
            $file_name_siup = '';
            $file_name_ktp = '';
            $userPerusahaan = '';

            if ($idKategori == '1' || $idKategori == '4') {
                $userPerusahaan = $this->input->post('userPerusahaan');
                $file_name_akte = base_url() . $target_dir . $userid . '_akte' . '.' . $_POST['ext'];
                $file_name_siup = base_url() . $target_dir . $userid . '_siup' . '.' . $_POST['ext'];
                $target_file_akte = $target_dir . $userid . '_akte' . '.' . $_POST['ext'];
                $target_file_siup = $target_dir . $userid . '_siup' . '.' . $_POST['ext'];
                move_uploaded_file($_FILES["imageFileSiup"]["tmp_name"], $target_file_siup);
                move_uploaded_file($_FILES["imageFileAkte"]["tmp_name"], $target_file_akte);
            }

            if ($idKategori == '2') {
                $file_name_ktp = base_url() . $target_dir . $userid . '_ktp' . '.' . $_POST['ext'];
                $target_file_akte = $target_dir . $userid . '_ktp' . '.' . $_POST['ext'];
                move_uploaded_file($_FILES["imageFileKtp"]["tmp_name"], $target_file_akte);
            }
            $update_data = array(
                'userid' => $userid,
                'produkkategorisubid' => $idSubKategori,
                'produkkategoriid' => $idKategori,
                'usersiup' => $file_name_siup,
                'userakteperusahaan' => $file_name_akte,
                'userktp' => $file_name_ktp,
                'userperusahaan' => $userPerusahaan,
            );
            $response = $this->UserModel->updateAkunPremium_user($update_data);
            $message = array(
                'status' => $response,
                'message' => "Update berhasil"
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update akun
     * --------------------
     * @param: $userid, $usernama, $usertelp, $userpassword
     * --------------------------
     * @method : POST
     * @link: api/users/updateDataAkun
     */
    function updateDataAkun_post()
    {
        $this->form_validation->set_rules('userid', 'UserId', 'trim|required');
        $userpassword = $this->input->post('userpassword');
        if ($this->form_validation->run() == TRUE) {
            if (!isset($userid)) {
                $userid = $this->input->post('userid');
                $usernamalengkap = $this->input->post('usernamalengkap');
                $usertelp = $this->input->post('usertelp');
                if ($userpassword != '') {
                    $passwordEncypted = $this->crypt->encrypt($userpassword, 'abcdef0123456789');
                } else {
                    $passwordEncypted = '';
                }
                $response = $this->UserModel->updateDataAkun_user($userid, $usernamalengkap, $usertelp, $passwordEncypted);
                // Generate a random name 
                $message = array(
                    'status' => $response,
                    'message' => "Data berhasil di ubah"
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    /**
     * Update akun
     * --------------------
     * @param: $userid, $usernama, $usertelp, $userpassword
     * --------------------------
     * @method : POST
     * @link: api/users/updateDataAkun
     */
    function updateDataAkunPremium_post()
    {
        if (isset($_POST)) {
            $response = $this->UserModel->updateAkunPremium_user($_POST);
            // // Generate a random name 
            $message = array(
                'status' => $response,
                'message' => "Data berhasil di ubah",
                'last' => $this->db->last_query()
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
