<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductMultipleImage extends Model {

    protected $table = 'product_multiple_image';
    protected $primaryKey = 'img_id';
    protected $allowedFields = ['img_id', 'product_id', 'product_image_name', 'created'];

   

    public function getDataAll($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.img_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name AS companyname,BN.banner FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN advertisement_banner AS BN ON (ad.id = BN.banner_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        if (isset($searchArray['company_id'])) {
             $sql .= " AND (ad.company_id = '" . $searchArray['company_id'] . "' ";
             $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ) ";

        }
      
        $sql .= " ORDER BY img_id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        // if($showQuery)
        // { 
        //     echo $sql;
        //     die();
        // }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
//print_r($coutOnly); die('aa');
            return $result[0]->total_count;
        }

        return $result;
    }
    //  public function getProductId($id) {
    //     $arrResult = $this->asArray()
    //             ->where(['product_id' => $id])
    //             ->find();
    //     return $arrResult;
    // }

     public function getProductId($product_id) {
        $sql = "SELECT img_id, product_image_name FROM $this->table";
        $sql .= " WHERE product_id ='" . $product_id . "' ";
        $sql .= " ORDER BY img_id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


}

?>
