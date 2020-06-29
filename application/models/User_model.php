<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{
    protected $user_table = 'v_user';

    public $column_order = array('usernamalengkap','useraktivasiakunpremium','usercreate','useralamat','produkkategorisubnama'); //set column field database for datatable orderable
    public $column_search = array('usernamalengkap','useraktivasiakunpremium','usercreate','useralamat','produkkategorisubnama'); //set column field database for datatable searchable
    public $order = array('userid' => 'asc'); // defau



    /*
    Fungsi : mengambil data sesuai parameter
    Parameter :
    - $param : Berupa nama kolom ( String )
    - $id : Berupa value dari kolom ( String )
    - $limit : Berupa limitasi untuk row yang diambil ( int )
    Return : Array(Array())
     */
    private function _get_datatables_query($status,$aktivasi='')
    {
        if($aktivasi != ''){
            if($aktivasi == '0'){
                $this->db->where('useraktivasiakunpremium' , $aktivasi);
                $this->db->where('produkkategoriid !=' , null);
            }
        }
        $this->db->where('useraktif' , $status);
        $this->db->where('userroleid !=', '1' );
        $this->db->from($this->user_table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function get_all($status,$aktivasi)
    {
        $this->_get_datatables_query($status,$aktivasi);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($status, $aktivasi)
    {
        $this->_get_datatables_query($status, $aktivasi);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($status, $aktivasi = '')
    {
        if($aktivasi != ''){
            if($aktivasi == '0'){
                $this->db->where('useraktivasiakunpremium' , $aktivasi);
                $this->db->where('produkkategoriid !=' , null);
            }
        }
        $this->db->where('useraktif' , $status);
        $this->db->where('userroleid !=' , '1' );
        $this->db->from($this->user_table);
        return $this->db->count_all_results();
    }

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
     * Status Login
     * ----------------------------------
     * @param: Statusname or email address
     * @param: password
     */
    public function getMemberAktif_user($number, $offset)
    {
        $this->db->where('useraktif', '1');
        $q = $this->db->get($this->user_table, $number, $offset);
        return $q->result();
    }
    /**
     * Count Status
     * ----------------------------------
     */
    public function getCountMemberAktif_user()
    {
        $q =  $this->db->query("select count(userid) as count from user where useraktif = 1");
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
        $query = $this->db->update('user', $data, array('userid' => $data['userid']));
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
    /**
     * Delete user
     * --------------------
     * @param: $userid = ''
     * --------------------------
     * @method : POST
     * @link: api/users/delete_user
     */
    public function delete_user($id)
    {
        // $this->db->where('userid',$userid);
        return $this->db->query("update user set useraktif = '0' where userid = '$id' ");
    }
    /**
     * Aktif user
     * --------------------
     * @param: $userid = ''
     * --------------------------
     * @method : POST
     * @link: api/users/aktif_user
     */
    public function aktif_user($id)
    {
        // $this->db->where('userid',$userid);
        return $this->db->query("update user set useraktif = '1' where userid = '$id' ");
    }
}
