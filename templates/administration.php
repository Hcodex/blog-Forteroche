<?php $this->title = "Billet simple pour l'Alaska - L'auteur"; ?>
	
<main role="main">
	
	<div class="page-header">
		<h1 class="text-center">Administration</h1>
    </div>
    <section id="page-content">	
            <div class="container pb-5">	
                <a class="nav-link btn btn-warning text-dark" type="button" href="index.php?route=addArticle">Ajouter un article</a>
                <?php
                    include('form_upload.php');
                ?>

            <table>
                <tr>
                    <td>Id</td>
                    <td>Titre</td>
                    <td>Contenu</td>
                    <td>Auteur</td>
                    <td>Image</td>
                    <td>Date</td>
                    <td>Actions</td>
                </tr>
                <?php
                foreach ($articles as $article)
                {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($article->getId());?></td>
                        <td><a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId());?>"><?= htmlspecialchars($article->getTitle());?></a></td>
                        <td><?= substr(htmlspecialchars($article->getContent()), 0, 150);?></td>
                        <td><?= htmlspecialchars($article->getAuthor());?></td>
                        <td><?= htmlspecialchars($article->getPicture());?></td>
                        <td>Créé le : <?= htmlspecialchars($article->getCreatedAt('FR'));?></td>
                        <td>
                            <a href="../public/index.php?route=editArticle&articleId=<?= $article->getId(); ?>">Modifier</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>












            </div>	
    </section>
</main>
