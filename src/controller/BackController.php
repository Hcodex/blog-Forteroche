<?php

namespace App\src\controller;

use App\config\Parameter;

class BackController extends Controller
{

    private function checkLoggedIn()
    {
        if (!$this->session->get('pseudo')) {
            $this->session->set('error_message', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: ../public/index.php?route=login');
            exit();
        } else {
            return true;
        }
    }


    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('role') === 'admin')) {
            $this->session->set('error_message', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: ../public/index.php?route=profile');
            exit();
        } else {
            return true;
        }
    }

    public function administration()
    {
        if ($this->checkAdmin()) {
            $articles = $this->articleDAO->getArticles();
            return $this->view->render('administration', [
                'articles' => $articles,
            ]);
        }
    }

    public function addArticle(Parameter $post)
    {
        if ($this->checkAdmin()) {
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
                    header('Location: ../public/index.php?route=administration');
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
    }

    public function editArticle(Parameter $post, $articleId)
    {
        if ($this->checkAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
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
                    header('Location: ../public/index.php?route=administration');
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
    }

    public function deleteArticle($articleId)
    {
        if ($this->checkAdmin()) {
            $this->articleDAO->deleteArticle($articleId);
            $this->session->set('success_message', '<strong>L\'article a bien été supprimé</strong>');
            header('Location: ../public/index.php?route=administration');
        }
    }

    public function profile()
    {
        if ($this->checkLoggedIn()) {
            return $this->view->render('profile');
        }
    }

    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->logoutOrDelete('logout');
        }
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
        header('Location: ../public/index.php');
        exit();
    }


    public function editProfile(Parameter $post)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submit')) {
                $userId = $this->session->get('id');
                $this->userDAO->editUser($post,  $userId);
                $user = $this->userDAO->getUser($userId);
                $this->session->set('avatar', $user->getAvatar());
                $this->session->set('avatar_file_name', $user->getAvatarFileName());
                $this->session->set('avatar_thumbail', $user->getThumbail());
                $this->session->set('success_message', '<strong>Profil mis à jour</strong>');
                header('Location: ../public/index.php?route=profile');
                exit();
            }
        }
    }
}
