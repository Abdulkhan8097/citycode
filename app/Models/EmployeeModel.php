<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model {

    protected $table = 'employee';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'mobileno', 'email', 'password', 'status', 'created_date', 'updated_date'];
	


public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(NT.$this->primaryKey) as total_count FROM $this->table AS NT ";
        }
        else
        {
            $sql = "SELECT NT.* FROM $this->table AS NT ";
        }

        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND NT.id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.name LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.mobileno LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.email LIKE '".$searchArray['txtsearch']."%' ";
        }

        if(isset($searchArray['id']))
       {
           $sql .= " AND NT.id = '".$searchArray['id']."' ";
       }
        
        $sql .= " ORDER BY $this->primaryKey DESC"; 

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
	
	
        public function getEmployeeId($id) {
        $sql = "SELECT employee.* FROM employee";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

	///////////////////////////////////// Login with company_details //////////////////
	
	function checkEmployeeLogin($username, $password) {
	
        $txtreturn = false;
        $objResult = $this->asObject()
                ->where(['email' => $username])
                ->first();
				
        if ($objResult) {
                $dbPassword = $objResult->password;
        if(password_verify($password,$dbPassword)) {
                $adminSession = array(
                    'employee_id' => $objResult->id,
		    'name' => $objResult->name,
		     'mobileno' => $objResult->mobileno,
                    'email' => $objResult->email,                   
                    'isAdminLoggedIn' => TRUE,
                    'LoggedIn' => TRUE,
                );
                $session = session();
                $session->set($adminSession);
                $txtreturn = true;
            }
        }
        return $txtreturn;
    }


}

?>