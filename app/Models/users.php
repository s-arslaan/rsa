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

    public function addUser($data) {
        $builder = $this->db->table($this->DBPrefix.'users');
        $builder->insert($data);

        if($this->db->affectedRows() == 1) {
            return True;
        } else {
            return False;
        }
    }

    public function verifyUniqueID($id) {

        $builder = $this->db->table($this->DBPrefix.'users');
        $builder->select('activation_date,unique_id,status')->where('unique_id',$id);
        $res = $builder->get()->getRow();

        if(isset($res->unique_id))  {
            return $res;
        } else {
            return 'not';
        }

    }
}