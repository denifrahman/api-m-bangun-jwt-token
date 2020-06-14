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
        $this->db->insert('user', $data);
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
        $update_data = array(
            'userid' => $userid,
            'userfoto' => $file_name
        );
        // $this->db->where('userid',$userid);
        return $this->db->update('user', $update_data, array('userid' => $userid));
    }

    public function getById_user($userid)
    {
        $this->db->where('userid', $userid);
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
    public function updateAkunPremium_user($data)
    {
        $query =$this->db->update('user', $data, array('userid' => $data['userid'])); 
        return $query;
    }

    /**
     * Update akun
     * --------------------
     * @param: $userid = '',$usernama = '',$usertelp = '',$userpassword = ''
     * --------------------------
     * @method : POST
     * @link: api/users/updateDataAkun
     */
    public function updateDataAkun_user($userid = '', $usernamalengkap = '', $usertelp = '', $userpassword = '')
    {

        // Update user
        if ($userpassword == '') {
            $update_data = array(
                'usernamalengkap' => $usernamalengkap,
                'usertelp' => $usertelp,
            );
        } else {
            $update_data = array(
                'usernamalengkap' => $usernamalengkap,
                'userpassword' => $userpassword,
                'usertelp' => $usertelp,
            );
        }
        // $this->db->where('userid',$userid);
        return $this->db->update('user', $update_data, array('userid' => $userid));
    }
}
