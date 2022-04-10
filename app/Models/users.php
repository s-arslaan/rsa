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

    public function checkEmail($email) {

        $builder = $this->db->table($this->DBPrefix.'users');
        $builder->select('*')->where('email',$email);
        // $builder->select('password,unique_id,status')->where('email',$email);
        $res = $builder->get();

        if(count($res->getResultArray()) != 0)  {
            return $res->getRow();
        } else {
            return false;
        }
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
        $res = $builder->get();

        if(count($res->getResultArray()) == 1)  {
            return $res->getRow();
        } else {
            return false;
        }
    }
    
    public function updateStatus($id) {
        $builder = $this->db->table($this->DBPrefix.'users');
        $builder->where('unique_id',$id);
        $builder->update(['status'=>1]);
    
        if($this->db->affectedRows() == 1)  {
            return true;
        } else {
            return false;
        }
    }
}