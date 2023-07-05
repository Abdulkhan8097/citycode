<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model{
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'branch_id', 'product_name', 'description', 'quantity', 'price', 'pr_redeempoint', 'show_inredeem','status','created_date', 'updated_date', 'created_by', 'arb_product_name', 'arb_description', 'picture','original_price','discount_per'];

		
		
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
	
	
public function getProductByCompany($company_name)
    {
    	$sql = "SELECT * FROM $this->table";
        $sql .= " WHERE company_name ='".$company_name."' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

   public function getAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = "SELECT ad.* , CD.company_name,CD.company_arb_name,CD.display_name,CD.display_arb_name,CD.picture AS company_picture FROM $this->table AS ad ";
       }
       
        $sql .= "LEFT JOIN company_details as CD ON (ad.company_id = CD.id) ";
        
       $sql .= " ";
       $sql .= " WHERE 1 ";
       if(isset($searchArray['txtsearch']))
       {
           $sql .= " AND ad.product_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR CD.company_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR ad.company_id LIKE '".$searchArray['txtsearch']."%' ";
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
       
       if(isset($searchArray['show_inredeem']))
       {
           $sql .= " AND ad.show_inredeem = '".$searchArray['show_inredeem']."' ";
       }
       
       if(isset($searchArray['company_id']))
       {
           $sql .= " AND ad.company_id = '".$searchArray['company_id']."' ";
       }
       
      $sql .= " ORDER BY ad.id DESC";

       if($limit)
       {
           $sql .= " LIMIT $offset,$limit";
       }
//echo $sql;
       $query = $this->db->query($sql);
       $result = $query->getResult();
       
       if($coutOnly)
       {
           return $result[0]->total_count;
       }

       return $result;
   }
	

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


 }
?>
