<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Produk extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load Produk Model
        $this->load->model('Produk_model', 'Produk_Model');
        $this->load->library('crypt'); 
    }

    /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAll
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
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Produk_Model->getAllByParam_Produk($idKecamatan,$idKota,$idProvinsi, $idSubKategori,$key);
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
      /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAllById
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
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
            $data = $this->Produk_Model->getById_Produk($id);
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
            $idSubKategori = $this->input->post('idSubKategori');
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
                        'userid'=>$userid,
                        'produkthumbnail'=>$file_name_produkthumbnail,
                        'produkfoto1'=>$file_name_produkfoto1,
                        'produkfoto2'=>$file_name_produkfoto2,
                        'produkfoto3'=>$file_name_produkfoto3,
                        'produkfoto4'=>$file_name_produkfoto4,
                        'produkpanjang'=>$produkpanjang,
                        'produklebar'=>$produklebar,
                        'produktinggi'=>$produktinggi,
                        'produkbahan'=>$produkbahan,
                        'produkbudget'=>$produkbudget,
                        'produkkategorisubid' =>$idSubKategori

                    );
                    $response = $this->Pengajuan_model->pengajuanRqt_user($data_post);
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
            $message = array(
                'status' => $this->input->post('userid'),
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}