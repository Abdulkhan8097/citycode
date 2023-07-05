<?php namespace App\Controllers;

class Home extends BaseController
{
     public  $data = array();
     
	public function index()
	{
          
		echo view('admin/header');
                
		//return view('admin/orders/today_list');
		echo view('admin/footer');
	}

	

}
