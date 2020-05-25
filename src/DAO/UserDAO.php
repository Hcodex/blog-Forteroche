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
        $user->setLastArticle($row['avatar']);
        return $user;
    }

    public function register(Parameter $post, $token)
    {
        $sql = 'INSERT INTO user (pseudo, email, password, created_at, role_id, token) VALUES (?, ?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$post->get('pseudo'), $post->get('email'), password_hash($post->get('password'), PASSWORD_BCRYPT), 2, password_hash($token, PASSWORD_BCRYPT)]);
        return 'Votre compte a été créé avec succès';
    }

    public function checkUserPseudo(Parameter $post)
    {
        $sql = 'SELECT COUNT(pseudo) FROM user WHERE pseudo = ?';
        $result = $this->createQuery($sql, [$post->get('pseudo')]);
        $isUnique = $result->fetchColumn();
        if ($isUnique) {
            return '<p>Ce pseudo existe déjà</p>';
        }
    }


    public function checkUserEmail(Parameter $post)
    {
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ?';
        $result = $this->createQuery($sql, [$post->get('email')]);
        $isUnique = $result->fetchColumn();
        if ($isUnique) {
            return '<p>Cet email est déjà utilisé</p>';
        }
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT user.id, user.email, user.pseudo, user.avatar, user.status, user.role_id, user.password, role.name, user.last_article_id FROM user INNER JOIN role ON role.id = user.role_id WHERE email = ?';
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
        $sql = 'UPDATE user SET status=:status, token=:token WHERE id=:id';
        $this->createQuery($sql, [
            'status' => 3,
            'token' => NULL,
            'id' => $userId
        ]);
    }

    public function unbanUser($userId)
    {
        $sql = 'UPDATE user SET status=:status, token=:token WHERE id=:id';
        $this->createQuery($sql, [
            'status' => 0,
            'token' => NULL,
            'id' => $userId
        ]);
    }

    public function checkBanned(Parameter $post)
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email = ? AND status = ?';
        $result = $this->createQuery($sql, [
            $post->get('email'),
            3
        ]);
        $exist = $result->fetchColumn();
        if ($exist) {
            return true;
        }
    }

    public function confirmAccount(Parameter $post)
    {
        $sql = 'UPDATE user SET status=:status, token=:token WHERE email=:email AND status <> 3';
        $this->createQuery($sql, [
            'status' => 1,
            'token' => NULL,
            'email' => $post->get('email')
        ]);
    }

    public function setToken(Parameter $post, $token)
    {
        $sql = 'UPDATE user SET token=:token WHERE email=:email AND status <> 3';
        $this->createQuery($sql, [
            'token' => password_hash($token, PASSWORD_BCRYPT),
            'email' => $post->get('email')
        ]);
    }

    public function checkToken(Parameter $post)
    {
        $sql = 'SELECT * FROM user WHERE email = ?';
        $data = $this->createQuery($sql, [$post->get('email')]);
        $result = $data->fetch();
        $isTokenValid = password_verify($post->get('token'), $result['token']);
        return [
            'isTokenValid' => $isTokenValid
        ];
    }

    public function purgeToken($userId)
    {
        $sql = 'UPDATE user SET token = NULL WHERE id=:id';
        $this->createQuery($sql, [
            'id' => $userId
        ]);
    }

    public function resetPassword(Parameter $post)
    {
        $sql = 'UPDATE user SET password=:password, token=NULL WHERE email=:email';
        $this->createQuery($sql, [
            'password' => password_hash($post->get('password'), PASSWORD_BCRYPT),
            'email' => $post->get('email')
        ]);
    }


    public function checkOldPassWord(Parameter $post, $userId)
    {
        $sql = 'SELECT * FROM user WHERE id = ?';
        $data = $this->createQuery($sql, [$userId]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('old_password'), $result['password']);
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid
        ];
    }

    public function setPassword(Parameter $post, $userId)
    {
        $sql = 'UPDATE user SET password=:password WHERE id=:id';
        $this->createQuery($sql, [
            'password' => password_hash($post->get('password'), PASSWORD_BCRYPT),
            'id' => $userId
        ]);
    }

    public function setBookmark($articleId, $userId)
    {
        $sql = 'UPDATE user SET last_article_id=:last_article_id WHERE id=:id';
        $this->createQuery($sql, [
            'last_article_id' => $articleId,
            'id' => $userId
        ]);
    }



    public function deleteUser($userId)
    {
        $sql = 'UPDATE comment SET user_id = ? WHERE user_id= ? ';
        $this->createQuery($sql, [0,  $userId]);
        $sql = 'DELETE FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
        return true;
    }
}
