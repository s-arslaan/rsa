<?php

namespace App\Controllers;
use App\Models\Users;

class Home extends BaseController
{
    public $userModel;
    public function __construct()
    {
        $this->userModel = new Users();
    }

    public function index()
    {   
        $data = array(
            'title' => 'RSA Algorithm DSS',
            'team' => 'GNU G11',
            'users' => $this->userModel->getUsers(),
        );

        return view('index_view', $data);
    }
}
