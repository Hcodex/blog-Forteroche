<?php

namespace App\src\controller;

use App\config\Parameter;

class FrontController extends Controller
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


    public function home()
    {
        return $this->view->render('home');
    }

    public function auteur()
    {
        return $this->view->render('auteur');
    }

    public function register(Parameter $post)
    {
        if (!$this->session->get('pseudo')) {
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'User');
                if ($this->userDAO->checkUserPseudo($post)) {
                    $errors['pseudo'] = $this->userDAO->checkUserPseudo($post);
                }
                if ($this->userDAO->checkUserEmail($post)) {
                    $errors['email'] = $this->userDAO->checkUserEmail($post);
                }
                if (!$errors) {
                    $this->session->set('success_message', '<strong>Cotre compte a été créé avec succès</strong>');
                    $success = $this->userDAO->register($post);
                } else {
                    $this->session->set('error_message', '<strong>Erreur dans le formulaire. </strong>Votre compte n\'a pas été crée');
                }
                return $this->view->render('register', [
                    'post' => $post,
                    'errors' => $errors,
                    'success' => $success
                ]);
            }
            return $this->view->render('register');
        }
        header('Location: ../public/index.php?route=profile');
        exit();
    }

    public function login(Parameter $post)
    {
        if ($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if ($result && $result['isPasswordValid']) {
                $this->session->set('login', 'Bonne lecture');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('email', $post->get('email'));
                $this->session->set('pseudo', $result['result']['pseudo']);
                $this->session->set('avatar_file_name', $result['result']['avatar_file_name']);
                $this->session->set('avatar', $result['result']['avatar']);
                $this->session->set('avatar_thumbail', $result['result']['avatar_thumbail']);
                $this->session->set('success_message', '<Strong>Connexion réussie ! </strong> Bonne lecture');
                header('Location: ../public/index.php?route=profile');
                exit();
            } else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Le pseudo et/ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'post' => $post,
                ]);
            }
        } else {
            return $this->view->render('login');
        }
    }

    public function roman()
    {
        $articles = $this->articleDAO->getPublishedArticles();
        return $this->view->render('roman', [
            'articles' => $articles
        ]);
    }

    public function article($articleId)
    {
        $articles = $this->articleDAO->getPublishedArticles();
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId);
        return $this->view->render('single', [
            'article' => $article,
            'articles' => $articles,
            'comments' => $comments,
        ]);
    }

    public function addComment(Parameter $post, $articleId)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Comment');
                if (!$errors) {
                    $userId = $this->session->get('id');
                    $this->commentDAO->addComment($post, $articleId, $userId);
                    $this->session->set('success_message', '<Strong>Votre commentaire a été ajouté</strong>');
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                    exit();
                }
                $this->session->set('error_message', '<Strong>Echec !</strong> Votre commentaire n\'a pas été ajouté');
            }
        }
        $articles = $this->articleDAO->getPublishedArticles();
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId);

        return $this->view->render('single', [
            'article' => $article,
            'articles' => $articles,
            'post' => $post,
            'errors' => $errors,
            'comments' => $comments
        ]);
    }


    public function editComment(Parameter $post, $articleId)
    {
        if ($this->checkLoggedIn()) {
            $article = $this->articleDAO->getArticle($articleId);
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Comment');
                if (!$errors) {
                    $userId = $this->session->get('id');
                    $this->commentDAO->editComment($post, $articleId, $userId);
                    $this->session->set('success_message', '<strong>Votre commentaire a bien été modifié</strong>');
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                    exit();
                }
                $this->session->set('error_message', '<Strong>Echec !</strong> Votre commentaire n\'a pas été mise à jour');
            }
        }
        $articles = $this->articleDAO->getPublishedArticles();
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId);
        return $this->view->render('single', [
            'article' => $article,
            'articles' => $articles,
            'post' => $post,
            'errors' => $errors,
            'comments' => $comments
        ]);
    }

    public function reportComment($commentId)
    {
        $this->commentDAO->reportComment($commentId);
        $this->session->set('success_message', '<strong>Commentaire signalé</strong>');
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
