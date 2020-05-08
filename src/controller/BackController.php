<?php

namespace App\src\controller;

use App\config\Parameter;
use App\src\services\PictureManager;

class BackController extends Controller
{

    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('role') === 'admin')) {
            $this->session->set('error_message', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: index.php?route=profile');
            exit();
        } else {
            return true;
        }
    }

    public function administration()
    {
        $this->checkAdmin();
        $articles = $this->articleDAO->getArticles();
        PictureManager::findArticlesPictures($articles);
        $comments = $this->commentDAO->getReportedComments();

        $commentsReported = array();
        $commentsApproved = array();
        $commentsHided = array();

        foreach ($comments as $comment) {
            if ($comment->isReported() == 1) {
                $commentsReported[] = $comment;
            } elseif ($comment->isReported() == 2) {
                $commentsApproved[] = $comment;
            } elseif ($comment->isReported() == 3 || $comment->isReported() == 4) {
                $commentsHided[] = $comment;
            }
        }

        /*
            echo '<pre>';
            print_r($commentsReported);
            print_r($commentsApproved);
            print_r($commentsHided);
            die();
            */
        return $this->view->render('administration', [
            'articles' => $articles,
            'commentsReported' => $commentsReported,
            'commentsApproved' => $commentsApproved,
            'commentsHided' => $commentsHided
        ]);
    }


    public function addArticle(Parameter $post)
    {
        $this->checkAdmin();
        if ($post->get('publish') || $post->get('draft') || $post->get('toCorrect')) {
            $errors = $this->validation->validate($post, 'Article');
            if ($this->articleDAO->checkArticleTitle($post)) {
                $errors['unique'] = $this->articleDAO->checkArticleTitle($post);
            }
            if (!$errors) {
                if ($post->get('publish')) {
                    $status = 1;
                }
                if ($post->get('toCorrect')) {
                    $status = 2;
                }
                if ($post->get('draft')) {
                    $status = 0;
                }
                $this->articleDAO->addArticle($post, $this->session->get('id'), $status);
                /* $this->session->set('add_article', 'Le nouvel article a bien été ajouté');*/
                $this->session->set('success_message', '<Strong>Articlé créé avec succès !</strong>');
                header('Location: index.php?route=administration');
                exit();
            } else {
                $this->session->set('error_message', '<Strong>L\'article n\'a pas été créé : </strong> ' . $errors['unique'] . $errors['title'] . $errors['content']);
                return $this->view->render('add_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
        } else {
            return $this->view->render('add_article');
        }
    }

    public function editArticle(Parameter $post, $articleId)
    {
        $this->checkAdmin();
        $article = $this->articleDAO->getArticle($articleId);
        PictureManager::findArticlePictures($article);
        if ($post->get('publish') || $post->get('draft') || $post->get('toCorrect')) {
            $errors = $this->validation->validate($post, 'Article');

            if ($article->getTitle() !== $post->get('title')) {
                if ($this->articleDAO->checkArticleTitle($post)) {
                    $errors['unique'] = $this->articleDAO->checkArticleTitle($post);
                }
            }
            if (!$errors) {
                if ($post->get('publish')) {
                    $status = 1;
                }
                if ($post->get('toCorrect')) {
                    $status = 2;
                }
                if ($post->get('draft')) {
                    $status = 0;
                }

                $this->articleDAO->editArticle($post, $articleId, $this->session->get('id'), $status);
                $this->session->set('success_message', '<strong>L\' article a bien été modifié</strong>');
                header('Location: index.php?route=administration');
                exit();
            } else {
                $this->session->set('error_message', '<strong>L\' article n\'a pas été modifié</strong> ' . $errors['unique'] . $errors['title'] . $errors['content']);
                return $this->view->render('edit_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
        } else {
            $post->set('id', $article->getId());
            $post->set('title', $article->getTitle());
            $post->set('picture_file_name', $article->getPictureFileName());
            $post->set('picture', $article->getPicture());
            $post->set('thumbail', $article->getThumbail());
            $post->set('content', $article->getContent());
            $post->set('author', $article->getAuthor());

            return $this->view->render('edit_article', [
                'post' => $post,
            ]);
        }
    }

    public function deleteArticle($articleId)
    {
        $this->checkAdmin();
        $this->articleDAO->deleteArticle($articleId);
        $this->session->set('success_message', '<strong>L\'article a bien été supprimé</strong>');
        header('Location: index.php?route=administration');
        exit();
    }

    public function profile()
    {
        $this->checkLoggedIn();
        $userId = $this->session->get('id');
        $user = $this->userDAO->getUser($userId);
        PictureManager::findAvatar($user);
        return $this->view->render('profile',[
            'user' => $user
        ]);
    }

    public function logout()
    {
        $this->checkLoggedIn();
        $this->logoutOrDelete('logout');
    }

    private function logoutOrDelete($param)
    {
        $this->session->stop();
        $this->session->start();
        if ($param === 'logout') {
            $this->session->set($param, 'Vous avez été correctement déconnecté, a bientôt.');
            $this->session->set('success_message', 'Vous avez été correctement déconnecté, a bientôt.');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location: index.php');
        exit();
    }


    public function editProfile(Parameter $post)
    {
        $this->checkLoggedIn();
        if ($post->get('submit')) {
            $userId = $this->session->get('id');
            $user = $this->userDAO->getUser($userId);
            $this->userDAO->editUser($post,  $userId);
            $this->session->set('avatar', $user->getAvatar());
            $this->session->set('success_message', '<strong>Profil mis à jour</strong>');
            header('Location: index.php?route=profile');
            exit();
        }
    }

    public function approveComment($commentId)
    {
        $this->checkAdmin();
        $this->commentDAO->approveComment($commentId);
        $this->session->set('success_message', '<strong>Commentaire approuvé</strong>');
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    public function deleteComment($commentId)
    {
        $this->checkAdmin();
        $this->commentDAO->deleteComment($commentId);
        $this->session->set('success_message', '<strong>Commentaire supprimé</strong>');
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    public function archiveComment($commentId)
    {
        $this->checkAdmin();
        $this->commentDAO->archiveComment($commentId);
        $this->session->set('success_message', '<strong>Commentaire archivé</strong>');
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    public function hideComment($commentId)
    {
        $this->checkAdmin();
        $this->commentDAO->hideComment($commentId);
        $this->session->set('success_message', '<strong>Commentaire masqué</strong>');
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    }
}
