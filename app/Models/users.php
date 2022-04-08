<?php

namespace App\Models;
use CodeIgniter\Model;

class Users extends Model {
    public function getUsers() {

        $users = array();

        for($i=0; $i<10; $i++) {
            $users[] = [
                'user'.$i, 'email'.$i.'@mail.com' 
            ];
        }

        return $users;
    }
}