<?php

//StateModel.php

namespace App\Models;

use CodeIgniter\Model;

class CompanyEnquiryModel extends Model{

	protected $table = 'company_enquiry';

	protected $primaryKey = 'ce_id';

	protected $allowedFields = ['ce_id','ce_userid','ce_companyid', 'ce_details', 'ce_createddate', ];

   public function getEnquiryID($id) {
        $sql = "SELECT company_enquiry.*, customer.name, customer.city_code, customer.gender, customer.mobile, company_details.company_name FROM company_enquiry";
        $sql .= " LEFT JOIN company_details ON (company_details.id = company_enquiry.ce_companyid) ";
        $sql .= " LEFT JOIN customer ON (customer.id = company_enquiry.ce_userid) ";
       $sql .= " WHERE ce_id ='" . $id . "' "; 
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }




public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.*, customer.name, customer.city_code, customer.gender, customer.mobile, company_details.company_name FROM $this->table AS ad ";
        }
            $sql .= "LEFT JOIN company_details ON (ad.ce_companyid = company_details.id) ";
            $sql .= "LEFT JOIN customer ON (ad.ce_userid = customer.id) ";

        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.ce_details LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR customer.name LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR company_details.company_name LIKE '".$searchArray['txtsearch']."%' ";
        }

        if(isset($searchArray['ce_companyid']))
       {
           $sql .= " AND ad.ce_companyid = '".$searchArray['ce_companyid']."' ";
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