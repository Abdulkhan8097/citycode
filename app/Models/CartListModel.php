<?php

namespace App\Models;

use CodeIgniter\Model;

class CartListModel extends Model {

    protected $table = 'cart_list';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = ['cart_id', 'user_id', 'company_id', 'branch_id', 'product_id', 'qty', 'created_date', 'cart_status', 'product_cost_mobile', 'product_discount_mobile', 'delivery_charge'];
	


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
    public function getDataApi($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(NT.$this->primaryKey) as total_count FROM $this->table AS NT ";
        }
        else
        {
            $sql = "SELECT NT.*,C.company_name,C.company_arb_name,C.picture as company_image,B.branch_name,B.arb_branch_name,P.product_name,P.arb_product_name,P.picture,P.description,P.arb_description FROM $this->table AS NT ";
        }
         $sql .= " LEFT JOIN company_details AS C ON (NT.company_id = C.id) ";
         $sql .= " LEFT JOIN branch AS B ON (NT.branch_id = B.branch_id) ";
          $sql .= " LEFT JOIN products AS P ON (NT.product_id = P.id) ";
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        // if(isset($searchArray['txtsearch']))
        // {
        //     $sql .= " AND (NT.user_id LIKE '".$searchArray['txtsearch']."%' ";
        //     $sql .= " OR NT.company_id LIKE '".$searchArray['txtsearch']."%') ";
          
        // }
         if(isset($searchArray['user_id']))
       {
           $sql .= " AND NT.user_id = '".$searchArray['user_id']."' ";
       }
       if(isset($searchArray['company_id']))
       {
           $sql .= " AND NT.company_id = '".$searchArray['company_id']."' ";
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
    public function getDataApiCompany($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(NT.$this->primaryKey) as total_count FROM $this->table AS NT ";
        }
        else
        {
            $sql = "SELECT DISTINCT(NT.company_id),C.company_name,C.company_arb_name,C.picture as company_image,B.branch_name,B.arb_branch_name,B.branch_id  FROM $this->table AS NT ";
        }
         $sql .= " LEFT JOIN company_details AS C ON (NT.company_id = C.id) ";
         $sql .= " LEFT JOIN branch AS B ON (NT.branch_id = B.branch_id) ";
          $sql .= " LEFT JOIN products AS P ON (NT.product_id = P.id) ";
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND (NT.user_id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.company_id LIKE '".$searchArray['txtsearch']."%') ";
          
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

}

?>