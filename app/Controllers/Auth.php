<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;

class Auth extends BaseController
{
    public $userModel;
    public function __construct()
    {
        $this->userModel = new Users();
    }

    public function login() {

        $data = array(
            'title' => 'RSA | Login',
            'team' => 'GNU G11',
        );
        return view('login', $data);
    }
    
    public function register() {

        $data = array(
            'title' => 'RSA | Register User',
            'team' => 'GNU G11',
        );
        return view('register', $data);
    }

    // only login/register is allowed
    public function _remap($method) {
        if(method_exists($this, $method)) {
            if($method == "register") {
                return $this->$method();
            }
            else if($method == "login") {
                return $this->$method();
            }
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
