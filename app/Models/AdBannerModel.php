<?php namespace App\Models;

use CodeIgniter\Model;

class AdBannerModel extends Model{
    
    protected $table = 'advertisement_banner';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'banner_id', 'banner', 'created_by'];
    
   

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,A.url,A.banner_type, A.governorate, A.gender, A.start_date, A.end_date, A.in_app, A.company_id";
            $sql .= " FROM $this->table AS ad ";
        }
         $sql .= " LEFT JOIN advertisement AS A ON (ad.banner_id = A.id) ";
          
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
           
        }
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND ad.id LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }
        
        
        $sql .= " ORDER BY $this->primaryKey DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

//        echo $sql; die;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }

        return $result;
    }


    public function getData1($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,A.url,A.banner_type, A.governorate, A.gender, A.start_date, A.end_date, A.in_app, A.company_id";
            $sql .= " FROM $this->table AS ad ";
        }
         $sql .= " LEFT JOIN advertisement AS A ON (ad.banner_id = A.id) ";
          
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
           
        }
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND ad.id LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }
        
        
        $sql .= " AND A.status='1' ORDER BY $this->primaryKey DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

//        echo $sql; die;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }

        return $result;
    }
   
   /* public function getBannersID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }*/

    public function getData12($user_id) {
        //echo $language;exit;
        $sql ="SELECT * FROM `customer` WHERE `id` ='".$user_id."'";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        //echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function getfinalData($gender,$governorate,$language) {
        //echo $language;exit;
        if ($language=='english') {
            $flanguage='english';
        }elseif($language=='arb') {
            $flanguage='arb';
        }else{
            $flanguage='all';
        }
        $currentdate = date('Y-m-d');
        //echo $currentdate;exit;
        $sql = "SELECT ad.*,A.url,A.banner_type, A.governorate, A.gender, A.start_date, A.end_date, A.in_app, A.company_id";
        $sql .= " FROM $this->table AS ad ";
        $sql .= " LEFT JOIN advertisement AS A ON (ad.banner_id = A.id) ";
        $sql .= " WHERE 1 ";
        $sql .= " AND A.gender LIKE '%".$gender."%' ";
        $sql .= " AND A.governorate LIKE '%".$governorate."%' ";
        $sql .= " AND (A.banner_type ='".$flanguage."' OR A.banner_type='all')";
        $sql .= " AND A.end_date >='".$currentdate."' ";
         $sql .= " AND A.status='0' ";
        //$sql .= " AND A.banner_type '".$flanguage."%' ";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResult();
        //echo "<pre>";print_r($result);exit;
        return $result;
    }




    public function getBanner(){
        $sql =  "SELECT advertisement_banner.* FROM $this->table";
        $sql .= " WHERE created_by = '1' ";						
        $sql .= " ORDER BY id DESC"; 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


	public function getBannerById($banner_id){
        $sql =  "SELECT id, banner_id, banner FROM $this->table";						
        $sql .= " WHERE banner_id ='".$banner_id."' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


  
 }
?>


