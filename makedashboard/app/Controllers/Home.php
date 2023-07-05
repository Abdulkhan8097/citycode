<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('Admin_template/login.php');
    }

    public function login()
    {
        return view('Admin_template/index');
    }
    public function logout()
    {
        $session = session();

        $session->destroy();
        return redirect()->to('Admin_template/login.php');
    }


}
