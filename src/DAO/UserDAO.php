<?php

namespace App\src\DAO;


use App\src\model\User;

class UserDAO extends DAO
{   
    private function buildObject($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);
        $user->setEmail($row['email']);
        $user->setCreatedAt($row['created_at']);
        $user->setRole($row['role_id']);
        return $user;
    } 

    public function register($user)
    {
        extract($user);
        $sql = 'INSERT INTO user (pseudo, email, password, created_at, role_id) VALUES (?, ?, ?, NOW(), ?)';
        $this->createQuery($sql, [$pseudo, $email, password_hash($password, PASSWORD_BCRYPT), 1]);
    }
}