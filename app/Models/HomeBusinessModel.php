<?php

namespace App\Models;
use CodeIgniter\Model;

class HomeBusinessModel extends Model {

    protected $table = 'business';
    protected $primaryKey = 'business_id';

    protected $allowedFields = ['business_id', 'company_id',  'location', 'arb_location','mobile_no','email_id','description','arb_description','instagram_id','whatsapp_no','android_token'];
    

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {



        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT * FROM $this->table AS OT ";
        }
        $sql .= " LEFT JOIN company_details AS C ON (OT.company_id = C.id) ";
        $sql .= " WHERE 1 ";

        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND OT.business_id = '" . $searchArray['id'] . "' ";
        }

        if (isset($searchArray['company_id']) && $searchArray['company_id']) {
            $sql .= " AND OT.company_id = '" . $searchArray['company_id'] . "' ";
        }

        //echo $sql;exit;
        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();
        $sql .= " ORDER BY OT.business_id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }




        return $result;
    }



    
    function checkBranchLogin($username, $password) {


        $txtreturn = false;

        $objResult = $this->asObject()
                ->where(['branch_username like binary' => $username])
                ->first();
//echo $this->getLastQuery(); die;
        
        if ($objResult) {

$compnee_id = $objResult->company_id;
$companyModel = new CompanyModel();
$resultt = $companyModel->getCompanyDetail($compnee_id);
$auth_contact = $resultt['auth_contact'];

            $dbPassword = $objResult->branch_password;
            if(password_verify($password,$dbPassword)) {
                $adminSession = array(
                    'company_id' => $objResult->company_id,
                    'branch_id' => $objResult->branch_id,
                    'branch_name' => $objResult->branch_name,
                    'arb_branch_name' => $objResult->arb_branch_name,
                    'Authorized Contact' => $auth_contact,
                    'isBranchLoggedIn' => TRUE,
                );

//                $session = session();
//                $session->set($adminSession);
                $txtreturn = $adminSession;
            }
        }

        return $txtreturn;
    }
    
    public function getBusinessData($id) {
   
      $sql = "SELECT business.* FROM $this->table";
      $sql .= " WHERE business_id ='".$id."' ";
      $query = $this->db->query($sql);
      $result =  $query->getRow(); 
      return $result;
    }     
   
  /*
    public function getBusinessData($id){
    $arrResult =  $this->asArray()
                ->where(['branch_id' => $id])
                ->first();
        return $arrResult;
    }*/

    public function getBranchCity($id) {
        $sql = "SELECT cities.*, branch.branch_id, branch.city FROM branch";
        $sql .= " LEFT JOIN cities ON (cities.city_id = branch.city) ";
        $sql .= " WHERE branch_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getHomebusinessData($company_id) {
        $sql = "SELECT business.* FROM $this->table";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " ORDER BY business_id DESC";
       // $sql .= " LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getBranch($offer_id, $company_id) {
        $sql = "SELECT branch.* FROM $this->table";
        $sql .= " LEFT JOIN company_code_details ON (company_code_details.company_id = branch.company_id) ";
        $sql .= " WHERE id ='" . $offer_id . "' ";
        $sql .= " AND company_code_details.company_id ='" . $company_id . "' ";
        $sql .= " ORDER BY branch_id DESC";
     //   $sql .= "group by branch_name";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


    public function usernameExist($user) {
        $arrResult = $this->asArray()
                ->where(['branch_username' => $user])
                ->countAllResults();
        return $arrResult;
    }

    public function EdituserExist($email, $branch_id) {
        $arrResult = $this->asArray()
                ->where('branch_username', $email)
                ->where('branch_id !=', $branch_id)
                ->countAllResults();
        return $arrResult;
    }

}

?>
