<?php
namespace App\Controllers;
use App\Models\ContactUs;
use App\Libraries\Paginationnew;

class Contact extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
     {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


   public function index()
    {
        $session = session();
	    if($session->get('id')){         
          $isIn = $session->get('id'); 		
       }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
		
        $contact = new ContactUs();
        $data['row'] = $contact->getContactID(); 
        
        $this->template->render('admintemplate', 'contents' , 'admin/contact_us', $data);
    }
	
	
	
    public function update() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $phone = $this->request->getPost('phone');
        $whatsapp = $this->request->getPost('whatsapp');
        $instagram = $this->request->getPost('instagram');
        $mail = $this->request->getPost('mail');
        $location = $this->request->getPost('location');

        $contactModel = new ContactUs();
        $arrSaveData = array(
            'phone' => $phone,
            'whatsapp' => $whatsapp,
            'instagram' => $instagram,
            'mail' => $mail,
            'location' => $location
        );
        $newuserdata = (array_filter($arrSaveData));
        $Update = $contactModel->where('id', '1')->set($newuserdata)->update();

        if ($Update) {
            $this->session->setFlashdata('message', 'Updated successfully.');
            return redirect()->to(site_url('Contact'));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('Contact'));
        }
    }



}

?>
