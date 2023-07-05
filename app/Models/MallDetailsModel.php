<?php

namespace App\Models;

use CodeIgniter\Model;

class MallDetailsModel extends Model {

    protected $table = 'mall_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'mall_name', 'arabic_mall_name'];
	


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
            $sql .= " OR NT.interest LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.company_id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.description LIKE '".$searchArray['txtsearch']."%' ";
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

        //echo "<pre>";print_r($result);exit;
        return $result;
    }
	
	
    public function getMallID($id) {
        $sql = "SELECT * FROM mall_details";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getDetailsCompany($strInterest) {
        //echo "<pre>";print_r($strInterest);exit;
        $sql = "SELECT *,notification.id as notation_id,notification.image as notifyimage, notification.company_id FROM notification"; 
        $sql .= " LEFT JOIN company_details ON(company_details.id = notification.company_id) ";
        $sql .= " LEFT JOIN branch ON(branch.company_id = company_details.id) ";
        $sql .= " LEFT JOIN orders ON(orders.od_id = notification.order_id) ";
        $sql .= "WHERE ".$strInterest;
        $sql .= "ORDER BY notation_id DESC";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }




}

?>
