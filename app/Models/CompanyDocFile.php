<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyDocFile extends Model {

    protected $table = 'company_doc_banner';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'doc', 'banner', 'type' ,'business_id','b_status'];

    
    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.* FROM $this->table AS OT ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND OT.id = '" . $searchArray['id'] . "' ";
           
        }
        
        if (isset($searchArray['company_id']) && $searchArray['company_id']) {
            $status=1;
            $sql .= " AND (OT.company_id = '" . $searchArray['company_id'] . "' && OT.b_status = '" . $status . "')";
           
        }
        
        if (isset($searchArray['type']) && $searchArray['type']) {
            $sql .= " AND OT.type = '" . $searchArray['type'] . "' ";
           
        }
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND OT.name LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.id DESC";

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
    
    
    public function getBannerId($id) {
        $arrResult = $this->asArray()
                ->where(['id' => $id])
                ->first();
        return $arrResult;
    }

    //////////// for banner file ///////////////////

    public function getBanner($company_id) {
        $sql = "SELECT id, company_id, banner, type FROM $this->table";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " AND type = 'banner' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
      public function getBanneradmin() {
        $sql = "SELECT ad.*,A.company_name FROM $this->table AS ad";
       $sql .= " LEFT JOIN company_details AS A ON (ad.company_id  = A.id) ";
        $sql .= " Where type = 'banner' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
       // echo $this->db->getLastQuery();
        return $result;
    }

    ///////////// for doc file //////////////

    public function getDocFile($company_id) {
        $sql = "SELECT id, company_id, doc, type FROM $this->table";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " AND type = 'doc' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getImagesFile($b_id) {
        $sql = "SELECT * FROM $this->table";
        $sql .= " WHERE business_id ='" . $b_id . "' ";
        $sql .= " AND type = 'business' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
       // echo "<pre>";print_r($result);exit;
        return $result;
    }
    public function getDatalist($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(NT.id) as total_count FROM $this->table AS NT ";
            // print_r($sql);exit;

        }
        else
        {
            // $sql = "SELECT NT.* FROM $this->table AS NT ";
             $sql = "SELECT NT.*,A.company_name FROM $this->table AS NT";
        }
        $sql .= " LEFT JOIN company_details AS A ON (NT.company_id  = A.id) ";

        $sql .= " ";
        $sql .= " WHERE 1 ";
        $sql .= " AND type = 'banner' ";
        
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND A.company_name LIKE '".$searchArray['txtsearch']."%' ";
           
        }

     
        
        $sql .= " ORDER BY NT.id DESC"; 

        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();
        
        if($coutOnly)
        {
             // echo $this->db->getLastQuery();

             return $result[0]->total_count;
         
        }
// echo $this->db->getLastQuery();
        return $result;
    }

}

?>
