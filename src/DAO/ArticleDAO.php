<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Article;

class ArticleDAO extends DAO
{
    private function buildObject($row)
    {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setContent($row['content']);
        $article->setAuthor($row['pseudo']);
        $article->setCreatedAt($row['created_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setPicture($row['picture']);
        return $article;
    }

    public function addArticle(Parameter $post, $userId)
    {
        $sql = 'INSERT INTO article (title, content, picture, created_at, user_id) VALUES (?, ?, ?, NOW(), ?)';
        $this->createQuery($sql, [$post->get('title'), $post->get('content'), $post->get('picture'), $userId]);
    }

    public function editArticle(Parameter $post, $articleId, $userId)
    {
        $sql = 'UPDATE article SET title=:title, content=:content, picture=:picture, updated_at=NOW(), user_id=:user_id WHERE id=:articleId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'picture' => $post->get('picture'),
            'user_id' => $userId,
            'articleId' => $articleId
        ]);
    }

    public function checkArticleTitle(Parameter $post)
    {
        $sql = 'SELECT COUNT(title) FROM article WHERE title = ?';
        $result = $this->createQuery($sql, [$post->get('title')]);
        $isUnique = $result->fetchColumn();
        if($isUnique) {
            return 'Ce titre est déjà utilisé<br>';
        }
    }

    public function getArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, article.picture, user.pseudo, article.created_at, article.updated_at FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.id DESC';
        $result = $this->createQuery($sql);
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticle($articleId)
    {
        $sql = 'SELECT article.id, article.title, article.content, article.picture, user.pseudo, article.created_at, article.updated_at FROM article INNER JOIN user ON article.user_id = user.id WHERE article.id = ?';
        $result = $this->createQuery($sql, [$articleId]);
        $article = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($article);
    }  
}