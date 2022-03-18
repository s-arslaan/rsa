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
        
        $output = array();

        if(!$this->primeCheck($p) || !$this->primeCheck($q)) {
            $output[] = "---- Not Prime Number ----";
        }
        else {
            
        }

        header('Content-Type: application/json');
        return json_encode( $output );
    }

    protected function primeCheck($num) {
        if($num==2){
            return TRUE;
        }
        elseif ($num<2 || $num%2==0) {
            return FALSE;
        }
        elseif ($num>2) {
            for ($i=2; $i < $num; $i++) { 
                if($num%$i==0) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
}
