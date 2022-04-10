<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Controllers\RsaFunction;
use DateTime;

/**
 * @property IncomingRequest $request 
 */

class Auth extends BaseController
{
    public $userModel;
    public $rsaFunction;
    public $session;
    public function __construct()
    {
        $this->userModel = new Users();
        $this->rsaFunction = new RsaFunction();
        $this->session = \Config\Services::session();
        helper('date');
    }

    public function login()
    {
        if ($this->request->getMethod() == 'post') {

            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);

            $userdata = $this->userModel->checkEmail($email);

            if($userdata) {
                $raw_password = $this->rsaFunction->encrypt($userdata->prime_no_1, $userdata->prime_no_2, $this->request->getVar('password'));
            
                if($userdata->password === md5($raw_password)) {

                    if($userdata->status == 1) {

                        $this->session->setTempdata('success','Login Successful!');
                        return redirect()->to(current_url());
            
                    } else {
                        $this->session->setTempdata('error','Please verify your email');
                        return redirect()->to(current_url());
                    }
                    
                } else {
                    $this->session->setTempdata('error','Incorrect email or password');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setTempdata('error','Incorrect email or password');
                return redirect()->to(current_url());
            }
                            
        }

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
            $password = $this->rsaFunction->encrypt($prime1, $prime2, $this->request->getVar('password'));
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

            if($this->userModel->checkEmail($email) == false) {

                if($this->userModel->addUser($userdata)) {
                    // $subject = 'RSA GNU | Account Activation';
                    // $body = "Hi $name,<br>Thanks for creating an account with us. Please activate your account.<a href=\"".base_url()."/auth/activate/$unique_id\" target='_blank'>Activate Now</a>";

                    $this->session->setTempdata('success','User Registered');
                    return redirect()->to(current_url());

                } else {
                    $this->session->setTempdata('error','Something went wrong');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setTempdata('error','Email already exists!');
                return redirect()->to(current_url());
            }
        }

        $data = array(
            'title' => 'RSA | Register User',
            'team' => 'GNU G11',
        );
        return view('register', $data);
    }

    public function activate($unique_id = null) {
        $data = [];
        if(!empty($unique_id)) {
            $userdata = $this->userModel->verifyUniqueID($unique_id);
            // die(print_r($data));
            if($userdata) {
                if($this->isLinkValid($userdata->activation_date)) {
                    if($userdata->status == 0) {
                        if($this->userModel->updateStatus($unique_id)) {
                            $data['success'] = 'Email verified successfully!';
                        }
                    } else {
                        $data['success'] = 'Email is already verified!';
                    }
                } else {
                    $data['error'] = 'Sorry! Link Expired!';
                }
            } else {
                $data['error'] = 'Invalid Link!';
            }
        }
        else {
            $data['error'] = 'Sorry! Unable to process request!';
        }
        return view("activate",$data);
    }

    public function isLinkValid($regTime) {
        $currTime = now();
        $diffTime = (int)$currTime - (int)strtotime($regTime);
        if($diffTime < 3600) {
            // if time is less than 1 hour
            return true;
        } else {
            return false;
        }
    }

    // only login/register is allowed
    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
