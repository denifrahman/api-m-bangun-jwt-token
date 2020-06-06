<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{
    protected $user_table = 'user';

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
        $q = $this->db->get($this->user_table);

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
        return $this->db->update($this->user_table, $update_data,['userid'=>$userid]);
    }
    public function getById_user($userid)
    {
        $this->db->where('userid',$userid);
        $q = $this->db->get($this->user_table);
        return $q->row();
    }
}
