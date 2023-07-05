<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model{
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'branch_id', 'coupon_type', 'discount_offer', 'product_name', 'description', 'quantity', 'price', 'pr_redeempoint', 'show_inredeem','status','created_date', 'updated_date', 'created_by', 'arb_product_name', 'arb_description', 'picture', 'original_price', 'discount_per', 'after_discount', 'supplierVat_charges', 'delivery_charge', 'service_charge', 'citycode_vat', 'delivery_km', 'product_cost_mobile', 'product_discount_mobile', 'picture_2', 'picture_3', 'picture_4'];
		
		
	public function getAllProducts() {
   
        $sql = "SELECT products.*, company_details.company_name FROM products";
        $sql .= " LEFT JOIN company_details ON (products.company_name = company_details.id) ";
	$sql .= " ORDER BY products.id DESC"; 
        $query = $this->db->query($sql);
        $result = $query->getResult();       
        return $result;
   }
   

	public function getProductByCompanyName($uid) {   
        $sql = "SELECT * FROM $this->table";
	$sql .= " WHERE created_by ='".$uid."' ";
	$sql .= " ORDER BY products.id DESC"; 
        $query = $this->db->query($sql);
        $result = $query->getResult(); 
        return $result;
    }



public function CompanyName($company_name)
    {
    	$sql = "SELECT company_name FROM $this->table";
        $sql .= " WHERE company_name ='".$company_name."' ";
        $sql .= "group by company_name";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }



    public function getProductID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }
	
    public function getDiscountOffer($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }
    
	
public function getProductByCompany($company_name)
    {
    	$sql = "SELECT * FROM $this->table";
        $sql .= " WHERE company_name ='".$company_name."' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

   public function getAll($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
   { 
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = " SELECT  ad.* , CD.company_name,CD.company_arb_name,CD.display_name,CD.display_arb_name,CD.picture AS company_picture FROM $this->table AS ad ";
       }
       
        $sql .= "LEFT JOIN company_details as CD ON (ad.company_id = CD.id) ";
        
       $sql .= " ";
       $sql .= " WHERE 1 ";
       // if(isset($searchArray['txtsearch']))
       // {
       //     $sql .= " AND ad.product_name LIKE '".$searchArray['txtsearch']."%' ";
       //     $sql .= " OR CD.company_name LIKE '".$searchArray['txtsearch']."%' ";
       //     $sql .= " OR ad.company_id LIKE '".$searchArray['txtsearch']."%' ";


       // }
        if($searchArray['companytxtsearch'] AND $searchArray['companyidsearch'])
       {
       

      
           $sql .= " AND (ad.product_name LIKE '".$searchArray['companytxtsearch']."%' ";
           // $sql .= " OR CD.company_name LIKE '".$searchArray['companytxtsearch']."%' ";
           $sql .= " AND ad.company_id = '" . $searchArray['companyidsearch'] . "' )";
 


       }
       
       if(isset($searchArray['id']))
       {
           $sql .= " AND ad.id = '".$searchArray['id']."' ";
       }

       if (isset($searchArray['pr_redeempoint'])) {
        $sql .= " AND ad.pr_redeempoint = '" . $searchArray['pr_redeempoint'] . "' ";
    }
       
       if(isset($searchArray['branch']))
       {
           $sql .= " AND ad.branch = '".$searchArray['branch']."' ";
       }
       
       if(isset($searchArray['status']))
       {
           $sql .= " AND ad.status = ".$searchArray['status']." ";
       }
       if(isset($searchArray['show_inredeem']))
       {
           $sql .= " AND ad.show_inredeem = '".$searchArray['show_inredeem']."' ";
       }
       
        if (isset($searchArray['company_id']) && $searchArray['company_id']) {
            // print_r($searchArray['company_id']);exit;
            
            if(is_array($searchArray['company_id']))
            {
                $in_array = implode("','",$searchArray['company_id']);
                
                 $sql .= " AND ad.company_id IN ('" . $in_array . "') ";

            }
            else
            {
             $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
            
             
            }
           
        }
        
        
        
        if (isset($searchArray['branch_id']) && $searchArray['branch_id']) {
            
            if(is_array($searchArray['branch_id']))
            {
                $in_string = "";
                foreach($searchArray['branch_id'] as $vlaue)
                {
                   // $in_string ." LIKE '%,".$vlaue.",%' ";
                    $in_string ." branch_id like '%".$vlaue."%'  ";
                }
                
                 $sql .= " AND  ('" . $in_string . "') ";
            }
            else
            {
             $sql .= " AND ad.branch_id LIKE '%" . $searchArray['branch_id'] . "%' ";
            }
           
        }
       
        
        if (isset($searchArray['discount_offer']) && $searchArray['discount_offer']) {
            
            if(is_array($searchArray['discount_offer']))
            {
                $in_array = implode("','",$searchArray['discount_offer']);
                
                 $sql .= " AND ad.discount_offer IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.discount_offer = '" . $searchArray['discount_offer'] . "' ";
            }
           
        }
         if(isset($searchArray['txtsearch']))
       {
           $sql .= " AND ad.product_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR CD.company_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR ad.company_id LIKE '".$searchArray['txtsearch']."%' ";


       }elseif(isset($searchArray['company_id']) && $searchArray['company_id']) {
         
            // print_r($searchArray['company_id']);exit;
            
            if(is_array($searchArray['company_id']))
            {
                $in_array = implode("','",$searchArray['company_id']);
                
                 $sql .= " AND ad.company_id IN ('" . $in_array . "') ";

            }
            else
            {
             $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
            
             
            }
           
        }
       
       else{
        $sql .= " GROUP BY ad.company_id";
       }
       
     
      
    
      $sql .= " ORDER BY ad.id DESC";

       if($limit)
       {
           $sql .= " LIMIT $offset,$limit";
       }
       if($showQuery)
       {
           echo $sql;
       }

       $query = $this->db->query($sql);
       $result = $query->getResult();
       
       if($coutOnly)
       {
           return $result[0]->total_count;
       }
      // echo  $this->db->getLastQuery();

       return $result;
   }
	


  //  public function getAll1($searchArray=array(), $offset='', $limit='',$coutOnly='')
  // {
  //     if($coutOnly)
  //     {
  //         $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
  //     }
  //     else
  //     {
  //         $sql = "SELECT ad.* , CD.company_name,CD.company_arb_name,CD.display_name,CD.display_arb_name,CD.picture AS company_picture FROM $this->table AS ad ";
  //     }
      
  //      $sql .= "LEFT JOIN company_details as CD ON (ad.company_id = CD.id) ";
       
  //     $sql .= " ";
  //     $sql .= " WHERE 1 ";
  //     if(isset($searchArray['txtsearch']))
  //     {
  //         $sql .= " AND ad.product_name LIKE '".$searchArray['txtsearch']."%' ";
  //         $sql .= " OR CD.company_name LIKE '".$searchArray['txtsearch']."%' ";
  //         $sql .= " OR ad.company_id LIKE '".$searchArray['txtsearch']."%' ";
  //     }
      
  //     if(isset($searchArray['id']))
  //     {
  //         $sql .= " AND ad.id = '".$searchArray['id']."' ";
  //     }

  //     if (isset($searchArray['pr_redeempoint'])) {
  //      $sql .= " AND ad.pr_redeempoint = '" . $searchArray['pr_redeempoint'] . "' ";
  //  }
      
  //     if(isset($searchArray['branch']))
  //     {
  //         $sql .= " AND ad.branch = '".$searchArray['branch']."' ";
  //     }
      
  //     if(isset($searchArray['show_inredeem']))
  //     {
  //         $sql .= " AND ad.show_inredeem = '".$searchArray['show_inredeem']."' ";
  //     }
      
  //     if(isset($searchArray['company_id']))
  //     {
  //         $sql .= " AND ad.company_id = '".$searchArray['company_id']."' ";
  //     }
      
  //    $sql .= " AND ad.status=1 ORDER BY ad.id DESC";

  //     if($limit)
  //     {
  //         $sql .= " LIMIT $offset,$limit";
  //     }
  //      //echo $sql; exit;
  //     $query = $this->db->query($sql);
  //     $result = $query->getResult();
      
  //     if($coutOnly)
  //     {
  //         return $result[0]->total_count;
  //     }

  //     return $result;
  // }

    public function getBranchName($id) {
        $sql = "SELECT products.company_id, branch.branch_id, branch.branch_name, branch.arb_branch_name FROM products";
        $sql .= " LEFT JOIN branch ON (branch.company_id = products.company_id) ";
        $sql .= " WHERE id ='" . $id . "' "; 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


    ////////////////////// for redeem product //////////////////////////


    public function getRedeemID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }

    
	public function getBannerByCreatedBy($uid) {   
        $sql = "SELECT * FROM $this->table";
	$sql .= " WHERE created_by ='".$uid."' ";
	$sql .= " ORDER BY id DESC"; 
        $query = $this->db->query($sql);
        $result = $query->getResult(); 
        return $result;
    }


    public function getCompanyBranch($id) {
        $sql = "SELECT branch.branch_id, branch.company_id, branch.branch_name, branch.arb_branch_name FROM branch";
        $sql .= " WHERE branch.company_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getupdatedata(){
        $sql = "SELECT * FROM $this->table WHERE original_price='0' ";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getupdate($price,$id){
        $sql = " UPDATE $this->table SET original_price= ".$price." WHERE id=".$id." ";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
  public function rechange($company_id,$red){
       
        return $this->db
                        ->table('company_details')
                        ->where(["id" => $company_id])
                        ->set($red)
		       ->update();
 
    }


 }
?>
