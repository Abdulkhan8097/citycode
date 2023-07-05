<?php

namespace App\Models;
use CodeIgniter\Model;

class BranchModel extends Model {

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    protected $allowedFields = ['branch_id', 'company_id', 'branch_name', 'city', 'state','branch_username', 'branch_password','location', 'arb_branch_name','arb_branch_location','arb_branch_username', 'android_token','branch_autho_no','mobile_otp','latitude','longitude','fast_delivery_charges','special_delivery_charges'];
    

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.*,CD.* FROM $this->table AS OT ";
        }
         $sql .= " LEFT JOIN company_details as CD ON (OT.company_id = CD.id) ";
        $sql .= " ";
        $sql .= " WHERE 1 ";

        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND OT.branch_id = '" . $searchArray['id'] . "' ";
        }

        if (isset($searchArray['company_id']) && $searchArray['company_id']) {
            $sql .= " AND OT.company_id = '" . $searchArray['company_id'] . "' ";
        }

        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND OT.branch_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.$this->primaryKey DESC";

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
                    'Authorized Contact' => $objResult->branch_autho_no,
                    'isBranchLoggedIn' => TRUE,
                );

//                $session = session();
//                $session->set($adminSession);
                $txtreturn = $adminSession;
            }
        }
        return $txtreturn;
    }
    
   /* public function getBranchId($branch_id) {
   
      $sql = "SELECT branch.* FROM $this->table";
      $sql .= " WHERE branch_id ='".$branch_id."' ";
      $query = $this->db->query($sql);
      $result =  $query->getRow(); 
   } */    
   
  
  public function getBranchId($id)
  {
    $arrResult =  $this->asArray()
                ->where(['branch_id' => $id])
                ->first();
        return $arrResult;
    }

    public function getComanyChat($id) {
        $sql = "SELECT * FROM $this->table WHERE branch_id='".$id."' ";
        $query = $this->db->query($sql);
        //$result = $query->getResultArray();
       // echo "<pre>";print_r($result);exit;
       // $result = $query->getResult();
        $result = $query->getRow();
        return $result;
    }

    public function getBranchCity($id) {
        $sql = "SELECT cities.*, branch.branch_id, branch.city FROM branch";
        $sql .= " LEFT JOIN cities ON (cities.city_id = branch.city) ";
        $sql .= " WHERE branch_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getBranchData($company_id) {
        $sql = "SELECT branch.* FROM $this->table";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " ORDER BY branch_id DESC";
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

    function checkUserLoginApi($mobile, $password) {

        $userdetails = array();
        $userid = null;
        $objResult = $this->asObject()
                ->where(['branch_autho_no' => $mobile])
                ->first();

        if ($objResult) {

            $dbPassword = $objResult->mobile_otp;
            if (password_verify($password, $dbPassword)) {
                $userdetails = array(
                    'id' => $objResult->branch_id,
                    'email' =>'',
                    'name' => $objResult->branch_name,
                    'city_code' =>'',
                    'interest' => '',
                    'isUserLoggedIn' => TRUE
                );

                $session = session();
                $session->set($userdetails);

                $txtreturn = true;

                $userid = $objResult->branch_id;
            }
        }

        return $userdetails;
    }

    //---------------------Select Branch Name depend on Company ID & Company Discount

    public function getBranchByDiscount($discount_offer, $company_id) {
        $qry="SELECT branch . *
        FROM branch
        LEFT JOIN company_code_details ON ( company_code_details.company_id = branch.company_id )
        WHERE company_code_details.customer_discount =25
        AND company_code_details.company_id = '122'
        ORDER BY branch_id DESC";

        $sql = "SELECT branch.* FROM $this->table";
        $sql .= " LEFT JOIN company_code_details ON (company_code_details.company_id = branch.company_id) ";
        $sql .= " WHERE discount_offer ='" . $discount_offer . "' ";
        $sql .= " AND company_code_details.company_id ='" . $company_id . "' ";
        $sql .= " ORDER BY branch_id DESC";
     //   $sql .= "group by branch_name";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
    ///----------------------------------------


    public function sendmessage() {
         $sql = "SELECT branch.company_id,branch.branch_id,branch.latitude,branch.longitude,branch.branch_name,company_details.company_name  FROM $this->table";
        $sql .= " LEFT JOIN company_details ON (company_details.id = branch.company_id) ";
          $sql .= " WHERE branch.latitude !='' ";
        $sql .= " AND branch.longitude !='' ";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }

}



?>
