<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Controllers\RsaFunction;

/**
 * @property IncomingRequest $request 
 */

class Auth extends BaseController
{
    public $userModel;
    public $rsafunc;
    public $session;
    public function __construct()
    {
        $this->userModel = new Users();
        $this->rsafunc = new RsaFunction();
        $this->session = \Config\Services::session();
    }

    public function login()
    {

        $data = array(
            'title' => 'RSA | Login',
            'team' => 'GNU G11',
        );
        return view('login', $data);
    }

    public function register()
    {

        if ($this->request->getMethod() == 'post') {

            $prime1 = 3;
            $prime2 = 13;
            $name = htmlentities($this->request->getVar('name'));
            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            $password = $this->rsafunc->encrypt($prime1, $prime2, $this->request->getVar('password'));
            $mobile = $this->request->getVar('mobile');
            $unique_id = md5(str_shuffle($name.time()));

            $userdata = array(
                'name' => $name,
                'email' => $email,
                'password' => md5($password),
                'mobile' => $mobile,
                'prime_no_1' => $prime1,
                'prime_no_2' => $prime2,
                'activation_date' => date('Y-m-d h:i:s'),
                'unique_id' => $unique_id,
            );
            // die(print_r($userdata));
            
            if($this->userModel->addUser($userdata)) {
                // $subject = 'RSA GNU | Account Activation';
                // $body = "Hi $name,<br>Thanks for creating an account with us. Please activate your account.<a href=\"".base_url()."/auth/activate/$unique_id\" target='_blank'>Activate Now</a>";

                $this->session->setTempdata('success','User Registered');
                return redirect()->to(current_url());

            } else {
                $this->session->setTempdata('error','Something went wrong');
                return redirect()->to(current_url());
            }
        }

        $data = array(
            'title' => 'RSA | Register User',
            'team' => 'GNU G11',
        );
        return view('register', $data);
    }

    // only login/register is allowed
    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            
            if ($method == "register") {
                return $this->$method();
            } else if ($method == "login") {
                return $this->$method();
            } else if ($method == "activate") {
                return $this->$method($param);
            }
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
