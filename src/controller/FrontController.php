<?php

namespace App\src\controller;

use App\config\Parameter;
use App\src\services\PictureManager;

class FrontController extends Controller
{
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
                    $token = md5(session_id() . microtime());
                    $success = $this->userDAO->register($post, $token);
                    $this->session->set('success_message', '<strong>Votre compte a été créé avec succès, vous allez recevoir un mail pour l\'activer</strong>');
                    $this->sendMail($post->get('email'), $token, "accountCreation");
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
        header('Location: index.php?route=profile');
        exit();
    }

    public function login(Parameter $post)
    {
        if ($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if ($result && $result['isPasswordValid']) {
                switch ($result['result']['status']) {
                    case "0":
                        $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Votre compte n\'est pas activé.<br> Pour activer votre compte, utilisez le lien qui vous a été communiqué par e-mail lors de la création de votre compte, ou demandez en un nouveau.');
                        return $this->view->render('requestToken', [
                            'post' => $post,
                        ]);
                        break;
                    case "1":
                        $this->session->set('login', 'Bonne lecture');
                        $this->session->set('id', $result['result']['id']);
                        $this->session->set('role', $result['result']['name']);
                        $this->session->set('email', $post->get('email'));
                        $this->session->set('pseudo', $result['result']['pseudo']);
                        $this->session->set('avatar', $result['result']['avatar']);
                        $this->session->set('last_article_id', $result['result']['last_article_id']);
                        $this->session->set('success_message', '<Strong>Connexion réussie ! </strong> Bonne lecture');
                        $this->userDAO->purgeToken($this->session->get('id'));
                        header('Location: index.php?route=profile');
                        exit();
                        break;
                    case "3":
                        $this->session->set('error_login', 'Votre compte est banni');
                        $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Votre compte est banni');
                        break;
                }
            } else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Le pseudo et/ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'post' => $post,
                ]);
            }
        }
        return $this->view->render('login');
    }

    public function roman()
    {
        $articles = $this->articleDAO->getPublishedArticles();
        PictureManager::findArticlesPictures($articles);
        return $this->view->render('roman', [
            'articles' => $articles
        ]);
    }

    public function article($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        if ($this->articleDAO->checkArticle($articleId)) {
            PictureManager::findArticlePictures($article);
            $articlesIndex = $this->articleDAO->getArticlesIndex();
            $previousArticleIndex = $this->articleDAO->getPreviousArticleIndex($articleId);
            $nextArticleIndex = $this->articleDAO->getNextArticleIndex($articleId);
            $comments = $this->commentDAO->getCommentsFromArticle($articleId);
            PictureManager::findCommentsPictures($comments);
            return $this->view->render('single', [
                'article' => $article,
                'articlesIndex' => $articlesIndex,
                'comments' => $comments,
                'nextArticleIndex' => $nextArticleIndex,
                'previousArticleIndex' => $previousArticleIndex
            ]);
        }
        header('Location: index.php?route=roman');
        exit();
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
        PictureManager::findArticlePictures($article);
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

        $this->checkLoggedIn();
        if ($this->articleDAO->checkArticle($articleId)) {
            $article = $this->articleDAO->getArticle($articleId);
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Comment');
                if (!$errors) {
                    $userId = $this->session->get('id');
                    if ($this->commentDAO->editComment($post, $articleId, $userId)) {
                        $this->session->set('success_message', '<strong>Votre commentaire a bien été modifié</strong>');
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                        exit();
                    }
                    $this->session->set('error_message', '<strong>Ce commentaire n\'existe pas</strong>');
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                    exit();
                }
                $this->session->set('error_message', '<Strong>Echec !</strong> Votre commentaire n\'a pas été mise à jour');
            }
            $articles = $this->articleDAO->getPublishedArticles();
            $article = $this->articleDAO->getArticle($articleId);
            PictureManager::findArticlePictures($article);
            $comments = $this->commentDAO->getCommentsFromArticle($articleId);
            PictureManager::findCommentsPictures($comments);
            return $this->view->render('single', [
                'article' => $article,
                'articles' => $articles,
                'post' => $post,
                'errors' => $errors,
                'comments' => $comments
            ]);
        }
        $this->session->set('error_message', '<strong>Edition impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function reportComment($commentId)
    {
        if ($this->commentDAO->checkComment($commentId)) {
            $this->commentDAO->reportComment($commentId);
            $this->session->set('success_message', '<strong>Commentaire signalé</strong>');
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
        $this->session->set('error_message', '<strong>Signalement impossible</strong>');
        header('Location: index.php?route=roman');
        exit();
    }

    public function confirmAccount(Parameter $get)
    {
        $result = $this->userDAO->checkToken($get);
        if ($result['isTokenValid']) {
            $this->userDAO->confirmAccount($get);
            $this->session->set('success_message', '<strong>Compte activé,</strong> vous pouvez maintenant vous connecter');
            return $this->view->render('login');
            exit();
        }
        $this->session->set('error_message', 'Votre compte est déjà activé ou le lien est cassé');
        header('Location: index.php?route=login');
        exit();
    }

    public function requestToken(Parameter $post)
    {
        if ($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if ($result && $result['isPasswordValid']) {
                if ($result['result']['status'] === "0") {
                    $token = md5(session_id() . microtime());
                    $this->userDAO->setToken($post, $token);
                    $this->sendMail($post->get('email'), $token, "tokenRequest");
                    $this->session->set('success_message', '<Strong>E-mail envoyé.</strong> Consultez votre boite mail pour récupérer votre lien d\'activation.');
                } else {
                    $this->session->set('error_message', 'Ce compte est déjà activé');
                }
                header('Location: index.php?route=home');
                exit();
            } else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                $this->session->set('error_message', '<Strong>Echec</strong> Le pseudo et/ou le mot de passe sont incorrects');
                return $this->view->render('requestToken', [
                    'post' => $post,
                ]);
            }
        }
        return $this->view->render('requestToken');
    }

    public function requestAccountRecovery(Parameter $post)
    {
        if ($post->get('submit')) {
            if (!$this->userDAO->checkBanned($post)) {
                if ($this->userDAO->checkUserEmail($post)) {
                    $token = md5(session_id() . microtime());
                    $this->userDAO->setToken($post, $token);
                    $this->sendMail($post->get('email'), $token, "accountRecovery");
                    $this->session->set('success_message', '<Strong>E-mail envoyé.</strong> Consultez votre boite mail pour récupérer votre lien de réinitialisation de mot de passe.');
                    header('Location: index.php?route=home');
                    exit();
                }

                $this->session->set('error_message', '<Strong>Echec ! </strong> Identifiant incorrect');
            } else {
                $this->session->set('error_message', '<Strong>Opération impossible, </strong> Ce compte est banni');
            }
        }
        return $this->view->render('request_account_recovery');
    }

    public function accountRecovery(Parameter $post)
    {
        if ($post->get('submit')) {
            $errors = $this->validation->validate($post, 'User');
            if (!$errors) {
                $result = $this->userDAO->checkToken($post);
                if ($result['isTokenValid']) {
                    $this->userDAO->resetPassword($post);
                    $this->sendMail($post->get('email'), "", "passwordModify");
                    $this->session->set('success_message', '<strong>Votre mot de passe a été réinitlaisé avec succès. </strong> Vous pouvez maintenant vous connecter');
                    header('Location: index.php?route=login');
                    exit();
                } else {
                    $this->session->set('error_message', '<strong>Erreur ! </strong>Impossible de réinitialiser votre mot de passe');
                }
            } else {
                $this->session->set('error_message', '<strong>Erreur dans le formulaire. </strong>Votre mot de passe n\'a pas été réinitialisé');
            }
        }
        return $this->view->render('account_recovery', [
            'post' => $post,
            'errors' => $errors,
        ]);
    }

    public function passwordModify(Parameter $post)
    {
        $this->checkLoggedIn();
        if ($post->get('submit')) {
            $errors = $this->validation->validate($post, 'User');
            if (!$errors) {
                $userId = $this->session->get('id');
                $result = $this->userDAO->checkOldPassWord($post, $userId);
                if ($result['isPasswordValid']) {
                    $this->userDAO->setPassword($post, $userId);
                    $this->sendMail($this->session->get('email'), "", "passwordModify");
                    $this->session->set('success_message', '<strong>Votre mot de passe a été modifié avec succès. </strong>');
                    header('Location: index.php?route=profile');
                    exit();
                } else {
                    $this->session->set('error_message', '<strong>Erreur ! </strong>Ancien mot de passe incorrect');
                }
            } else {
                $this->session->set('error_message', '<strong>Erreur dans le formulaire. </strong>Votre mot de passe n\'a pas été réinitialisé');
            }
        }
        return $this->view->render('password_modify', [
            'post' => $post,
            'errors' => $errors,
        ]);
    }


    public function sendMail($to, $token, $mailtype)
    {
        switch ($mailtype) {
            case "accountCreation":
                $message = 'Bienvenue sur Un billet simple pour l\'Alaska<br><br>';
                $message .= 'Votre compte à été créé avec succès, pour l\'activer, cliquez sur le lien suivant :<br>';
                $message .= "<a href='http://192.168.2.107/blog-Forteroche/public/index.php?route=confirmAccount&email=" . $to . "&token=" . $token . "'>Activer mon compte</a><br><br>";
                $message .= "A très vite,<br>";
                $message .= "Jean Forteroche";
                $subject = 'Activer votre compte - Billet simple pour l\'Alaska';
                break;
            case "tokenRequest":
                $message = 'Bonjour<br><br>';
                $message .= 'Pour activer votre compte, cliquez sur le lien suivant :<br>';
                $message .= "<a href='http://192.168.2.107/blog-Forteroche/public/index.php?route=confirmAccount&email=" . $to . "&token=" . $token . "'>Activer mon compte</a><br><br>";
                $message .= "A très vite,<br>";
                $message .= "Jean Forteroche";
                $subject = 'Activer votre compte - Billet simple pour l\'Alaska';
                break;
            case "accountRecovery":
                $message = 'Bonjour<br><br>';
                $message .= 'Une demande de réinitialisation de mot de passe pour votre compte a été effectuée. Si vous êtes à l\'origine de cette demande et que vous souhaitez toujours remplacer votre mot de passe, cliquez sur le lien ci-dessous<br>';
                $message .= "<a href='http://192.168.2.107/blog-Forteroche/public/index.php?route=accountRecovery&token=" . $token . "'>Réinitialiser mon mot de passe</a><br><br>";
                $message .= "A très vite,<br>";
                $message .= "Jean Forteroche";
                $subject = 'Reinitialisation mot de passe - Billet simple pour l\'Alaska';
                break;
            case "passwordModify":
                $message = 'Bonjour<br><br>';
                $message .= 'Votre mot de passe a été modifié.<br><br> Si vous n\'êtes pas à l\'origine de cette action il est probable qu\'un tiers connaisse votre passe.<br> Si vous utilisez ce mot de passe sur d\'autres services il est recommandé de le changer au plus vite.<br><br>';
                $message .= "A très vite,<br>";
                $message .= "Jean Forteroche";
                $subject = 'Mot de passe modifié - Billet simple pour l\'Alaska';
                break;
            default:
                exit();
        }
        $headers = MAIL_FROM . MAIL_REPLY_TO . MAIL_CONTENT_TYPE;
        mail($to, $subject, $message, $headers);
    }

    public function setBookmark($articleId)
    {
        $this->checkLoggedIn();
        $userId = $this->session->get('id');
        $this->userDAO->setBookmark($articleId, $userId);
        $this->session->set('last_article_id', $articleId);
        $this->session->set('success_message', '<strong>Marque page positionné.</strong>');
        header('Location: index.php?route=roman');
        exit();
    }
}
