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

    private function checkCorrector()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('role') === 'corrector' || $this->session->get('role') === 'admin')) {
            $this->session->set('error_message', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: index.php?route=profile');
            exit();
        } else {
            return true;
        }
    }

    public function administration()
    {
        $this->checkCorrector();
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

        if ($this->session->get('role') === 'admin') {
            $users = $this->userDAO->getUsers();
            PictureManager::findAvatars($users);

            foreach ($users as $user) {
                if ($user->getStatus() == 3) {
                    $usersBanned[] = $user;
                } elseif ($user->getStatus() === "0" || $user->getStatus() === "1") {
                    $usersRegistered[] = $user;
                }
            }
        }
        return $this->view->render('administration', [
            'articles' => $articles,
            'commentsReported' => $commentsReported,
            'commentsApproved' => $commentsApproved,
            'commentsHided' => $commentsHided,
            'usersRegistered' => $usersRegistered,
            'usersBanned' => $usersBanned
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
        $this->checkCorrector();
        if ($this->articleDAO->checkArticle($articleId)) {
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

                return $this->view->render('edit_article', [
                    'post' => $post,
                ]);
            }
        }
        header('Location: index.php?route=administration');
        exit();
    }

    public function deleteArticle($articleId)
    {
        $this->checkAdmin();
        if ($this->articleDAO->checkArticle($articleId)) {
            $this->articleDAO->deleteArticle($articleId);
            $this->session->set('success_message', '<strong>L\'article a bien été supprimé</strong>');
        } else {
            $this->session->set('error_message', '<strong>Supression impossible</strong>');
        }
        header('Location: index.php?route=administration');
        exit();
    }

    public function profile()
    {
        $this->checkLoggedIn();
        $userId = $this->session->get('id');
        $user = $this->userDAO->getUser($userId);
        PictureManager::findAvatar($user);
        return $this->view->render('profile', [
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
            $this->userDAO->editUser($post,  $userId);
            $user = $this->userDAO->getUser($userId);
            $this->session->set('avatar', $user->getAvatar());
            $this->session->set('success_message', '<strong>Profil mis à jour</strong>');
            header('Location: index.php?route=profile');
            exit();
        }
    }

    public function approveComment($commentId)
    {
        $this->checkCorrector();
        if ($this->commentDAO->checkComment($commentId)) {
            $this->commentDAO->approveComment($commentId);
            $this->session->set('success_message', '<strong>Commentaire approuvé</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Approbation impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function deleteComment($commentId)
    {
        $this->checkCorrector();
        if ($this->commentDAO->checkComment($commentId)) {
            $this->commentDAO->deleteComment($commentId);
            $this->session->set('success_message', '<strong>Commentaire supprimé</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Suppression impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function archiveComment($commentId)
    {
        $this->checkCorrector();
        if ($this->commentDAO->checkComment($commentId)) {
            $this->commentDAO->archiveComment($commentId);
            $this->session->set('success_message', '<strong>Commentaire archivé</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Archivage impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function hideComment($commentId)
    {
        $this->checkCorrector();
        if ($this->commentDAO->checkComment($commentId)) {
            $this->commentDAO->hideComment($commentId);
            $this->session->set('success_message', '<strong>Commentaire masqué</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Masquage impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function setRole($userId, $role)
    {
        $this->checkAdmin();
        if ($this->userDAO->checkUser($userId)) {
            $this->userDAO->setRole($userId, $role);
            $this->session->set('success_message', '<strong>Les permisions de l\'utilisateur on été mises à jour</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Action impossible</strong>');
        header('Location: index.php?route=administration');
        exit();
    }

    public function banUser($userId)
    {
        $this->checkAdmin();
        if ($userId !== $this->session->get('id')) {
            if ($this->userDAO->checkUser($userId)) {
                $this->userDAO->banUser($userId);
                $this->session->set('success_message', '<strong>L\'utilsateur est désomais bani</strong>');
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                exit();
            }
        }
        $this->session->set('error_message', '<strong>Action impossible</strong>');
        header('Location: index.php?route=administration');
        exit();
    }

    public function unbanUser($userId)
    {
        $this->checkAdmin();
        if ($this->userDAO->checkUser($userId)) {
            $this->userDAO->unbanUser($userId);
            $this->session->set('success_message', '<strong>Le compte de l\'utilisateur est réactivé</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Action impossible</strong>');
        header('Location: index.php?route=administration');
        exit();
    }
    /*
    public function deleteUser($userId)
    {
        $this->checkAdmin();
        if ($this->userDAO->checkUser($userId)) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('success_message', '<strong>L\'utilisateur a bien été supprimé</strong>');
        } else {
            $this->session->set('error_message', '<strong>Supression impossible</strong>');
        }
        header('Location: index.php?route=administration');
        exit();
    }*/
}
