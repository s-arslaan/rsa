<?php

namespace App\Controllers;

class RsaFunction extends BaseController
{
    public function index() {
        return view('rsa_function');
        // $res = array(
        //     'name' => 'ars',
        //     'name2' => 'shaikh',
        //     'city' => 'ahmedabad'
        // );
        // header('Content-Type: application/json');
        // return json_encode( $res );
    }
    
    public function encrypt($p,$q) {
        // return view('welcome');
        header('Content-Type: application/json');
        return json_encode( $p );
    }
}
