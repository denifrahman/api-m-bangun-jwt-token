<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{
    protected $user_table = 'v_user';

    /**
     * Use Registration
     * @param: {array} User Data
     */
    public function insert_user(array $data)
    {
        $this->db->insert($this->user_table, $data);
        return $this->db->insert_id();
    }

    /**
     * User Login
     * ----------------------------------
     * @param: username or email address
     * @param: password
     */
    public function login_user($username, $password)
    {
        $this->db->where('useremail', $username);
        $this->db->where('userpassword', $password);
        $q = $this->db->get('user');

        return $q->row();
    }
    /**
     * Update Foto Profile
     * ----------------------------------
     * @param: user id
     */
    public function editFotoById_user($userid, $file_name)
    {

        // Update an Article
        $update_data = [
            'userid' =>  $userid,
            'userfoto' =>  $file_name
        ];
        // $this->db->where('userid',$userid);
        return $this->db->update('user', $update_data,['userid'=>$userid]);
    }
    public function getById_user($userid)
    {
        $this->db->where('userid',$userid);
        $q = $this->db->get('v_user');
        return $q->row();
    }
       /**
     * Update akun
     * --------------------
     * @param: _imageFileSiup, _imageFileAkte, idKategori,idSubKategori, namaPerusahaan
     * --------------------------
     * @method : POST
     * @link: api/users/updateAkunPremium
     */
    public function updateAkunPremium_user($userid = '',$file_name_akte = '',$file_name_siup = '',$userPerusahaan = '' ,$idSubKategori = '',$idKategori = '')
    {

        // Update user
            if($file_name_akte == '' && $file_name_siup == ''){
                $update_data = [
                    'userperusahaan' =>  $userPerusahaan,
                    'produkkategorisubid'=>$idSubKategori,
                    'produkkategoriid'=>$idKategori
                ];
            }else{
                $update_data = [
                    'usersiup' =>  $file_name_siup,
                    'userakteperusahaan' =>  $file_name_akte,
                    'userperusahaan' =>  $userPerusahaan,
                    'produkkategorisubid'=>$idSubKategori,
                    'produkkategoriid'=>$idKategori
                ];
            }
        // $this->db->where('userid',$userid);
        return $this->db->update('user', $update_data,['userid'=>$userid]);
    }
       /**
     * Update akun
     * --------------------
     * @param: $userid = '',$usernama = '',$usertelp = '',$userpassword = ''
     * --------------------------
     * @method : POST
     * @link: api/users/updateDataAkun
     */
    public function updateDataAkun_user($userid = '',$usernamalengkap = '',$usertelp = '',$userpassword = '' )
    {

        // Update user
            if($userpassword == ''){
                $update_data = [
                    'usernamalengkap' =>  $usernamalengkap,
                    'usertelp'=>$usertelp,
                ];
            }else{
                $update_data = [
                    'usernamalengkap' =>  $usernamalengkap,
                    'userpassword' =>  $userpassword,
                    'usertelp'=>$usertelp,
                ];
            }
        // $this->db->where('userid',$userid);
        return $this->db->update('user', $update_data,['userid'=>$userid]);
    }
}
