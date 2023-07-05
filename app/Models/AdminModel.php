<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model{
    
     protected $table = 'admin';
     protected $primaryKey = 'id';
     protected $allowedFields = ['id', 'fname', 'lname', 'email', 'phone', 'password', 'admin_created', 'admin_status','admin_type'];

	// public function savedata($arrSaveData){

    //     $this->save($arrSaveData);
        
    //     return $this->getInsertID();
    // }

    function checkAdminLogin($username,$password){

		$txtreturn = false;

        $objResult =  $this->asObject()
	                        ->where(['email' => $username])
	                        ->first();
                        
                    //    $newData = [
                    //            'password' => password_hash('987654', 1),
                    //        ];
                    //       print_r($newData);
                    // $this->where('id',1)->set($newData)->update(); 
                   

			if($objResult) {
                       
			$dbPassword = $objResult->password;
			
            if(password_verify($password,$dbPassword))
				{
					$adminSession = array(
						'user_id' => $objResult->id,
						'email'   => $objResult->email,
						'name'   => $objResult->fname,
						'isAdminLoggedIn' 	=> TRUE,
                        'LoggedIn'   => TRUE,
					);
                                        
                   $session = session();
                   $session->set($adminSession);
				
					$txtreturn = true;
				}
				
			}

			return $txtreturn;
		}

	public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.email LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.phone LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.admin_type LIKE '".$searchArray['txtsearch']."%' ";
        }
       $sql .= " ORDER BY id DESC";

        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();
        
        if($coutOnly)
        {
            return $result[0]->total_count;
        }

        return $result;
    }

    public function getSubAdmindetail($id)
    {
        $arrResult =  $this->asArray()
                    ->where(['id' => $id])
                    ->first();

        return $arrResult;
    }


////////////////////////////////////
public function count() {
$this->db->select('id');
$this->db->from('company_details');
$num_results = $this->db->count_all_results();
}

//////////////////////////////////////////////////////////////////////

    public function LoginID()
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => 1])
                  ->first();
      return $arrResult;
    }

}

?>
