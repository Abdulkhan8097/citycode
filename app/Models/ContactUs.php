<?php

//StateModel.php

namespace App\Models;

use CodeIgniter\Model;

class ContactUs extends Model{

	protected $table = 'contact';

	protected $primaryKey = 'id';

	protected $allowedFields = ['id','phone', 'whatsapp', 'instagram', 'mail', 'location'];
	

   public function getContactID() {
        $sql = "SELECT contact.* FROM contact";
        $sql .= " WHERE id = '1' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

}	

?>