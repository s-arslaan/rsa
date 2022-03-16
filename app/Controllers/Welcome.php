<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    public function index() {
        // return view('welcome');
        $res = array(
            'name' => 'ars',
            'name2' => 'shaikh',
            'city' => 'ahmedabad'
        );
        header('Content-Type: application/json');
        return json_encode( $res );
    }
    
    public function name($name) {
        // return view('welcome');
        header('Content-Type: application/json');
        return json_encode( $name );
    }
}
