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

}