<?php

namespace App\src\DAO;

use App\config\Parameter;
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
        $user->setAvatar($row['avatar']);
        return $user;
    } 

    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, email, password, created_at, role_id) VALUES (?, ?, ?, NOW(), ?)';
        $this->createQuery($sql, [$post->get('pseudo'), $post->get('email'), password_hash($post->get('password'), PASSWORD_BCRYPT), 2]);
        return 'Votre compte a été crée avec succès';
    }

    public function checkUserPseudo(Parameter $post)
    {
        $sql = 'SELECT COUNT(pseudo) FROM user WHERE pseudo = ?';
        $result = $this->createQuery($sql, [$post->get('pseudo')]);
        $isUnique = $result->fetchColumn();
        if($isUnique) {
            return '<p>Ce pseudo existe déjà</p>';
        }
    }

    
    public function checkUserEmail(Parameter $post)
    {
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ?';
        $result = $this->createQuery($sql, [$post->get('email')]);
        $isUnique = $result->fetchColumn();
        if($isUnique) {
            return '<p>Cet email est déjà utilisé</p>';
        }
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT user.id, user.email, user.pseudo, user.avatar, user.role_id, user.password, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE email = ?';
        $data = $this->createQuery($sql, [$post->get('email')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid
        ];
    }

    public function editUser(Parameter $post, $userId)
    {
        $sql = 'UPDATE user SET avatar=:avatar WHERE id=:id';
        $this->createQuery($sql, [
            'avatar' => $post->get('picture_file_name'),
            'id' => $userId,
        ]);
    }


    public function getUser($UserId)
    {
        $sql = 'SELECT user.id, user.email, user.email, user.pseudo, user.avatar, user.role_id, user.password, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE user.id = ?';
        $result = $this->createQuery($sql, [$UserId]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($user);
    }






}