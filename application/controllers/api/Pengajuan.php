<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Pengajuan extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Pengajuan Model
        $this->load->model('Pengajuan_model', 'Pengajuan_Model');
        $this->load->library('crypt');
    }

    /**
     * Pengajuan Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Pengajuan/getAll
     */
    public function getAllByParam_get()
    {
        $idKecamatan = $this->get('kec');
        $idKota = $this->get('kota');
        $idProvinsi = $this->get('prov');
        $idSubKategori = $this->get('sub');
        $key = $this->get('key');
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
            $data = $this->Pengajuan_Model->getAllByParam_Pengajuan($idKecamatan, $idKota, $idProvinsi, $idSubKategori, $key);
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
     * Pengajuan Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Pengajuan/getAllById
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
            $data = $this->Pengajuan_Model->getById_Pengajuan($id);
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
     * Update akun
     * --------------------
     * @param: _imageFileSiup, _imageFileAkte, idKategori,idSubKategori, namaPerusahaan
     * --------------------------
     * @method : POST
     * @link: api/users/pengajuanRqt
     */
    function pengajuanRqt_post()
    {
        $this->form_validation->set_rules('userid', 'userid', 'trim|required');
        $this->form_validation->set_rules('produkkategorisubid', 'produkkategorisubid', 'trim|required');
        $this->form_validation->set_rules('produkpanjang', 'produkpanjang', 'trim|required');
        $this->form_validation->set_rules('produklebar', 'produklebar', 'trim|required');
        $this->form_validation->set_rules('produktinggi', 'produktinggi', 'trim|required');
        $this->form_validation->set_rules('produkbahan', 'produkbahan', 'trim|required');
        $this->form_validation->set_rules('produkbudget', 'produkbudget', 'trim|required');
        $this->form_validation->set_rules('id_provinsi', 'id_provinsi', 'trim|required');
        $this->form_validation->set_rules('id_kota', 'id_kota', 'trim|required');
        $this->form_validation->set_rules('id_kecamatan', 'id_kecamatan', 'trim|required');
        $this->form_validation->set_rules('waktupengajuan', 'id_kecamatan', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            // Make sure you have created this directory already
            $target_dir = "assets/";
            // Generate a random name 
            $userid = $this->input->post('userid');
            $produkpanjang = $this->input->post('produkpanjang');
            $produklebar = $this->input->post('produklebar');
            $produktinggi = $this->input->post('produktinggi');
            $produkbahan = $this->input->post('produkbahan');
            $produkbudget = $this->input->post('produkbudget');
            $idSubKategori = $this->input->post('produkkategorisubid');
            $produknama = $this->input->post('produknama');
            $produkalamat = $this->input->post('produkalamat');
            $idprovinsi = $this->input->post('id_provinsi');
            $idkota = $this->input->post('id_kota');
            $idkecamatan = $this->input->post('id_kecamatan');
            $waktupengajuan = $this->input->post('waktupengajuan');
            $file_name_produkthumbnail = base_url() . $target_dir . $userid . '_produkthumbnail' . '.' . $_POST['ext'];
            $target_file_produkthumbnail = $target_dir . $userid . '_produkthumbnail' . '.' . $_POST['ext'];
            $file_name_produkfoto1 = base_url() . $target_dir . $userid . '_produkfoto1' . '.' . $_POST['ext'];
            $target_file_produkfoto1 = $target_dir . $userid . '_produkfoto1' . '.' . $_POST['ext'];
            $file_name_produkfoto2 = base_url() . $target_dir . $userid . '_produkfoto2' . '.' . $_POST['ext'];
            $target_file_produkfoto2 = $target_dir . $userid . '_produkfoto2' . '.' . $_POST['ext'];
            $file_name_produkfoto3 = base_url() . $target_dir . $userid . '_produkfoto3' . '.' . $_POST['ext'];
            $target_file_produkfoto3 = $target_dir . $userid . '_produkfoto3' . '.' . $_POST['ext'];
            $file_name_produkfoto4 = base_url() . $target_dir . $userid . '_produkfoto4' . '.' . $_POST['ext'];
            $target_file_produkfoto4 = $target_dir . $userid . '_produkfoto4' . '.' . $_POST['ext'];
            $check = getimagesize($_FILES["produkthumbnail"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["produkthumbnail"]["tmp_name"], $target_file_produkthumbnail) && move_uploaded_file($_FILES["produkfoto1"]["tmp_name"], $target_file_produkfoto1) && move_uploaded_file($_FILES["produkfoto2"]["tmp_name"], $target_file_produkfoto2) && move_uploaded_file($_FILES["produkfoto3"]["tmp_name"], $target_file_produkfoto3) && move_uploaded_file($_FILES["produkfoto4"]["tmp_name"], $target_file_produkfoto4)) {
                    $data_post = array(
                        'userid' => $userid,
                        'produknama' => $produknama,
                        'produkthumbnail' => $file_name_produkthumbnail,
                        'produkfoto1' => $file_name_produkfoto1,
                        'produkfoto2' => $file_name_produkfoto2,
                        'produkfoto3' => $file_name_produkfoto3,
                        'produkfoto4' => $file_name_produkfoto4,
                        'produkpanjang' => $produkpanjang,
                        'produklebar' => $produklebar,
                        'produktinggi' => $produktinggi,
                        'produkbahan' => $produkbahan,
                        'produkbudget' => $produkbudget,
                        'produkkategorisubid' => $idSubKategori,
                        'id_provinsi' => $idprovinsi,
                        'id_kota' => $idkota,
                        'id_kecamatan' => $idkecamatan,
                        'produkalamat' => $produkalamat,
                        'produkwaktupengajuan' => $waktupengajuan,

                    );
                    $response = $this->Pengajuan_Model->insert_Pengajuan($data_post);
                    if ($response) {
                        $message = array(
                            'status' => $response,
                            'message' => "Pengajuan berhasil"
                        );
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    } else {
                        $message = array(
                            'status' => $response,
                            'message' => "Pengajuan gagal, periksa jaringan atau lengkapi jika ada data yang kurang"
                        );
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response('error', REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $this->response('File is not an image', REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $message = array(
                'status' => $this->input->post('userid'),
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
