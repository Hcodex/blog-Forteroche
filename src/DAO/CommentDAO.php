<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setUser($row['user_id']);
        $comment->setPseudo($row['pseudo']);
        $comment->setAvatar($row['avatar']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setReported($row['reported']);
        return $comment;
    }

    public function addComment(Parameter $post, $articleId, $userId)
    {
        $sql = 'INSERT INTO comment (user_id, content, created_at, reported, article_id) VALUES (?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$userId, $post->get('content'), 0, $articleId]);
    }

    public function getCommentsFromArticle($articleId)
    {

        $sql = 'SELECT comment.id, user_id, comment.content, comment.created_at, comment.reported, user.pseudo, user.avatar FROM comment INNER JOIN user ON user.id=comment.user_id WHERE article_id = ? ORDER BY created_at DESC';
        /*$sql = 'SELECT id, user_id, content, created_at, reported FROM comment WHERE article_id = ? ORDER BY created_at DESC';*/
        $result = $this->createQuery($sql, [$articleId]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $userId = $row['user_id'];
            $picture = $row['avatar'];
            if (file_exists(AVATAR_IMG_DIR. $userId.'/thumb/' . $picture) && $picture != NULL) {
                $row['avatar'] =  AVATAR_IMG_DIR. $userId.'/thumb/' . $picture;
            } else {
                $row['avatar'] = DEFAULT_ARTICLE_IMG;
            }
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }
}
