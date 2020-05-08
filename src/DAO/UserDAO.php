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
        $user->setStatus($row['status']);
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
        $sql = 'SELECT user.id, user.email, user.pseudo, user.avatar, user.status, user.role_id, user.password, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE email = ?';
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

    public function checkUser($userId)
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE id = ?';
        $result = $this->createQuery($sql, [$userId]);
        $exist = $result->fetchColumn();
        if ($exist) {
            return true;
        }
    }



    public function getUser($UserId)
    {
        $sql = 'SELECT user.id, user.email, user.email, user.pseudo, user.avatar, user.role_id, user.password, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE user.id = ?';
        $result = $this->createQuery($sql, [$UserId]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($user);
    }

    public function getUsers()
    {
        $sql = 'SELECT user.id, user.email, user.email, user.pseudo, user.created_at, user.status, user.avatar, user.role_id, user.password, role.name  FROM user INNER JOIN role ON role.id = user.role_id ORDER BY user.status ASC, user.id DESC';
        $result = $this->createQuery($sql);
        $users = [];
        foreach ($result as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $users;
    }

    public function setRole($userId, $roleID)
    {
        $sql = 'UPDATE user SET role_id=:role WHERE id=:id';
        $this->createQuery($sql, [
            'role' => $roleID,
            'id' => $userId
        ]);
    }

    public function banUser($userId)
    {
        $sql = 'UPDATE user SET status=:status WHERE id=:id';
        $this->createQuery($sql, [
            'status' => 3,
            'id' => $userId
        ]);
    }

    public function unbanUser($userId)
    {
        $sql = 'UPDATE user SET status=:status WHERE id=:id';
        $this->createQuery($sql, [
            'status' => 0,
            'id' => $userId
        ]);
    }

    /*
    public function deleteUser($userId)
    {
        $sql = 'UPDATE comment SET user_id = ? WHERE user_id= ? ';
        $this->createQuery($sql, [0,  $userId]);
        $sql = 'DELETE FROM comment WHERE user_id = ?';
        $this->createQuery($sql, [$userId]);
        $sql = 'DELETE FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
        return true;
    }
*/


}