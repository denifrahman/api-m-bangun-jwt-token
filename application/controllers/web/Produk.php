<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

use function GuzzleHttp\json_decode;

require APPPATH . '/libraries/REST_Controller.php';

class Produk extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Produk Model
        $this->load->model('Produk_model', 'Produk_Model');
        $this->load->library('crypt');
    }

    function getRequest_post()
    {
        $status = $this->input->post('status');
        $aktif = $this->input->post('aktif');
        $list = $this->Produk_Model->get_all($aktif, $status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $btnPublish = '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Publish" onclick="detailRequest(' . $customers->produkid . ')"><i class="fa fa-upload"></i>';
            $btnAktif = '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit" onclick="aktif(' . $customers->produkid . ')"><i class="la la-edit"></i></a>';
            $btnOption = '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
              <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-32px, 27px, 0px);">
                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                <a class="dropdown-item" href="#"><i class="la la-remove"></i> Reject</a>
            </div>
        </span>';
            $foto = '
                <center>
                <span class="m-topbar__userpic">
                        <img src="' . $customers->produkthumbnail . '" class="m--img-rounded m--marginless" style=width:50px;height:50px;>
                </span>
                </center>';
            $leading = '<span style="width: 250px;"><div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-circle symbol-sm">' . $foto . '</div><div class="ml-3"><div class="text-dark-75 font-weight-bold font-size-lg mb-0">' . $customers->produknama . '</div><a href="#" class="text-muted font-weight-normal text-hover-primary">' . $customers->usernamalengkap . '</a><p style="color:blue;">' . $customers->produkkategorinama . ',  ' . $customers->produkkategorisubnama . '</p></div></div></span>';

            $isaktif = '';
            if ($customers->produkaktif == 0) {
                $isaktif = '<p style="color:grey">Non Aktif</p>';
            } else {
                $isaktif = '<p style="color:blue">Aktif</p>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $leading;
            $row[] = $customers->produkalamat;
            $row[] = $customers->produkwaktupengerjaan;
            $row[] = $isaktif;
            $row[] = $status == '0' ? $btnAktif . $btnOption : $btnPublish . $btnOption;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Produk_Model->count_all($aktif, $status),
            "recordsFiltered" => $this->Produk_Model->count_filtered($aktif, $status),
            "data" => $data,
            "aktif" => $aktif
        );
        $this->response($output);
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
        $userId = $this->get('userid');
        $stproduk = $this->get('stp');
        $produkId = $this->get('pro_id');

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        // $is_valid_token = $this->authorization_token->validateToken();
        // if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
        $data = $this->Produk_Model->getAllByParam_Produk($idKecamatan, $idKota, $idProvinsi, $idSubKategori, $key, $userId, $stproduk, $produkId);
        $qry = $this->db->last_query();
        $message = array(
            'status' => true,
            'data' => $data,
            'query' => $qry
        );
        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
    }
    /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAll
     */
    public function getAllRequest_get($pageSize, $pageNumber)
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        // $is_valid_token = $this->authorization_token->validateToken();
        // if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'api/Status';
        $countRow = $this->Produk_Model->getCount_Produk()->count;
        $limit = $pageSize;
        $data = $this->Produk_Model->getAllRequest_Produk($pageNumber, $limit);
        $qry = $this->db->last_query();
        $message = array(
            'status' => true,
            'pageNumber' => $pageNumber,
            'countRow' => $countRow,
            'pageSize' => $pageSize,
            'data' => $data,
            'query' => $qry
        );
        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // else{
        //     $message = array(
        //         'status' => $is_valid_token['status'],
        //         'message' => $is_valid_token['message'],
        //     );
        //     $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // }
    }
    /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAll
     */
    public function getAllByNama_get($nama)
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        // $is_valid_token = $this->authorization_token->validateToken();
        // if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE){

        $data = $this->Produk_Model->getAllByNama_Produk($nama);
        $qry = $this->db->last_query();
        $message = array(
            'status' => true,
            'pageNumber' => 0,
            'countRow' => 10,
            'pageSize' => 10,
            'data' => $data,
            'query' => $qry
        );
        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // else{
        //     $message = array(
        //         'status' => $is_valid_token['status'],
        //         'message' => $is_valid_token['message'],
        //     );
        //     $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        // }
    }

    /**
     * Produk update Status
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/updateStatus
     */
    public function updateStatus_post()
    {
        $fileName                       =  $_POST['produkfile'];
        $config['upload_path']          = 'assets/pdf';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']             = 10000;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']            =  $fileName;

        $this->load->library('upload', $config);

        // $data_input = $_POST;
        // $output = $this->Produk_Model->updateStatus_Produk($data_input);

        // if ($output) {
        if (!$this->upload->do_upload('nama_file')) {
            $error = array('error' => $this->upload->display_errors());
            $_POST['produkfile'] = '';
            $output = $this->Produk_Model->updateStatus_Produk($_POST);
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => $error
            );
            $this->response($error);
        } else {
            $res = array('upload_data' => $this->upload->data());
            $output = $this->Produk_Model->updateStatus_Produk($_POST);
            $message = array(
                'status' => true,
                // 'data'=>$output,
                'message' => $res
            );
        }
        // }
        $this->response($message);
    }
    public function deleteFileByNama_get($nama_file, $id)
    {
        $file = "assets/pdf/" . $nama_file;
        $data_input = array(
            'produkid' => $id,
            'produkfile' => Null
        );
        $output = $this->Produk_Model->updateStatus_Produk($data_input);
        if ($output) {
            if (is_readable($file) && unlink($file)) {
                $message = array(
                    'status' => true,
                    'message' => 'file berhasil di hapus'
                );
                $this->response($message);
            } else {
                $message = array(
                    'status' => true,
                    'message' => 'file tidak berhasil di hapus'
                );
                $this->response($message);
            }
        } else {
            $message = array(
                'status' => $output,
                'message' => 'file tidak berhasil di hapus'
            );
            $this->response($message);
        }
    }
    /**
     * Produk Get Data
     * --------------------
     * --------------------------
     * @method : GET
     * @link: api/Produk/getAllById
     */
    public function getById_get($id)
    {
        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        if (!empty($id)) {
            $data = $this->Produk_Model->getById_Produk($id);
            $message = array(
                'status' => true,
                'data' => $data[0]
            );
            $this->response($message);
        } else {
            $message = array(
                'status' => false,
            );
            $this->response($message);
        }
    }
}
