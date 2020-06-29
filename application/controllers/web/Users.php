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
                'usercreate' => time(),
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

    function getMemberAktif_post()
    {
        $status = $this->input->post('status');
        $aktivasi = $this->input->post('aktivasi');
        $list = $this->UserModel->get_all($status, $aktivasi);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $btnDelete = '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit" onclick="hapus(' . $customers->userid . ')"><i class="flaticon-delete"></i>';
            $btnAktif = '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit" onclick="aktif(' . $customers->userid . ')"><i class="la la-edit"></i></a>';
            $btnOption = '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
              <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-32px, 27px, 0px);">
                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
            </div>
        </span>';
            $jenisAkun = '';
            if ($customers->produkkategorinama == null && $customers->useraktivasiakunpremium == '0') {
                $jenisAkun = '<span style="color: blue; font-weight: 500;">Standart</span>';
            } else if ($customers->produkkategorinama == 'Kontraktor') {
                $jenisAkun = '<span style="color: #248a03; font-weight: 500;">' . $customers->produkkategorisubnama . '</span>';
            } else if ($customers->produkkategorinama == 'Jasa') {
                $jenisAkun = '<span style="color: orange; font-weight: 500;">' . $customers->produkkategorisubnama . '</span>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->usernamalengkap;
            $row[] = $customers->useralamat;
            $row[] = $customers->usercreate;
            $row[] = $jenisAkun;
            $row[] = $customers->useraktivasiakunpremium == '0' ? '' : '<center><img src="http://localhost:8888/api_jwt/assets/icon/verified.png" class="m--img-rounded m--marginless" style="width:15px; height:15px;"></center>';
            $row[] = $status == '0' ? $btnAktif.$btnOption : $btnDelete . $btnOption;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->UserModel->count_all($status, $aktivasi),
            "recordsFiltered" => $this->UserModel->count_filtered($status, $aktivasi),
            "data" => $data,
            "aktivasi" => $aktivasi
        );
        $this->response($output);
    }
    /**
     * Delete an Article with API
     * @method: DELETE
     */
    public function deleteUser_get($id)
    {
        header("Access-Control-Allow-Origin: *");
        if (empty($id)) {
            $this->response(['status' => $id, 'message' => 'Invalid Article ID']);
        } else {
            // Delete an Article
            $output = $this->UserModel->delete_user($id);

            if ($output > 0 and !empty($output)) {
                // Success
                $message = [
                    'status' => true,
                    'message' => "User Deleted"
                ];
                $this->response($message);
            } else {
                // Error
                $message = [
                    'status' => FALSE,
                    'message' => "User not delete"
                ];
                $this->response($message);
            }
        }
    }
    /**
     * Delete an User with API
     * @method: DELETE
     */
    public function aktifUser_get($id)
    {
        header("Access-Control-Allow-Origin: *");
        if (empty($id)) {
            $this->response(['status' => $id, 'message' => 'Invalid Article ID']);
        } else {
            // Delete an Article
            $output = $this->UserModel->aktif_user($id);

            if ($output > 0 and !empty($output)) {
                // Success
                $message = [
                    'status' => true,
                    'message' => "User aktif"
                ];
                $this->response($message);
            } else {
                // Error
                $message = [
                    'status' => FALSE,
                    'message' => "User not aktif"
                ];
                $this->response($message);
            }
        }
    }
}
