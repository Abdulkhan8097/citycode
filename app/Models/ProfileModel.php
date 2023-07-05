<?php namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model {

    protected $table = 'users';
     protected $primaryKey = 'id';
     protected $allowedFields = ['id', 'name','password', 'address'];
      protected $db ;
      
    function __construct() {      
        parent::__construct();
       $this->db = \Config\Database::connect();
    }


    public function getUserDetails($user_id) {
        $arrResult =  $this->asArray()
                        ->where(['id' => $user_id])
                        ->findAll();
        
        return isset($arrResult[0]) ? $arrResult[0] : array();
    }
     public function update_password($data, $id) {
        $this->db->where('id', $id);
        $query = $this->db->update('users', $data);
        $this->db->last_query();
        return true;
    }

}

?>