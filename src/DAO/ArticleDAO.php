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
        $article->setStatus($row['status']);
        $article->setPictureFileName($row['picture_file_name']);
        $article->setPicture($row['picture']);
        $article->setThumbail($row['thumbail']);
        return $article;
    }

    public function addArticle(Parameter $post, $userId)
    {
        $sql = 'INSERT INTO article (title, content, picture, created_at, user_id) VALUES (?, ?, ?, NOW(), ?)';
        $this->createQuery($sql, [$post->get('title'), $post->get('content'), $post->get('picture_file_name'), $userId]);
    }

    public function editArticle(Parameter $post, $articleId, $userId, $status)
    {
        $sql = 'UPDATE article SET title=:title, content=:content, picture=:picture, updated_at=NOW(), status=:status, user_id=:user_id WHERE id=:articleId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'picture' => $post->get('picture_file_name'),
            'status' => $status,
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
        $sql = 'SELECT article.id, article.title, article.content, article.picture, user.pseudo, article.created_at, article.updated_at, article.status FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.id DESC';
        $result = $this->createQuery($sql);
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $picture = $row['picture'];
            $row['picture_file_name'] = $picture;
            if (file_exists(ARTICLE_THUMB_DIR.$picture) && $picture != NULL){
                $row['thumbail'] =  ARTICLE_THUMB_DIR.$picture;
                $row['picture'] =  ARTICLE_IMG_DIR.$picture;
            }
            else{
                $row['thumbail'] = DEFAULT_ARTICLE_IMG;
                $row['picture'] =  DEFAULT_ARTICLE_IMG;
            }
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getPublishedArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, article.picture, user.pseudo, article.created_at, article.updated_at FROM article INNER JOIN user ON article.user_id = user.id WHERE article.status = 1 ORDER BY article.id DESC ';
        $result = $this->createQuery($sql);
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $picture = $row['picture'];
            $row['picture_file_name'] = $picture;
            if (file_exists(ARTICLE_THUMB_DIR.$picture) && $picture != NULL){
                $row['thumbail'] =  ARTICLE_THUMB_DIR.$picture;
                $row['picture'] =  ARTICLE_IMG_DIR.$picture;
            }
            else{
                $row['thumbail'] = DEFAULT_ARTICLE_IMG;
                $row['picture'] =  DEFAULT_ARTICLE_IMG;
            }
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
        $picture = $article['picture'];
        $article['picture_file_name'] = $picture;
        if (file_exists(ARTICLE_THUMB_DIR.$picture) && $picture != NULL){
            $article['thumbail'] =  ARTICLE_THUMB_DIR.$picture;
            $article['picture'] =  ARTICLE_IMG_DIR.$picture;
        }
        else{
            $article['thumbail'] = DEFAULT_ARTICLE_IMG;
            $article['picture'] =  DEFAULT_ARTICLE_IMG;
        }
        return $this->buildObject($article);
    }

    public function deleteArticle($articleId)
    {
        $sql = 'DELETE FROM article WHERE id = ?';
        $this->createQuery($sql, [$articleId]);
    }

}