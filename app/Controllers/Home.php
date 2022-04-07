<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {   
        $data = array(
            'title' => 'RSA Algorithm DSS',
            'team' => 'GNU G11',
        );
        return view('index_view', $data);
    }
}
