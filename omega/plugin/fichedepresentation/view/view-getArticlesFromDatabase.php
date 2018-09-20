<?php echo $this->partialView('menu') ?>
<div class="alert alert-info">
    Lorsque l'on <strong>sauvegarde en locale</strong> un article, sa référence et sa désignation sont copiées depuis la base de données nocturne vers la base de données du <br />
    Une fois l'article sauvé, il suffit d'éditer l'article via la "Liste des articles locales" et d'ajouter l'image, la fiche de présentation et le panel DMX. <br />
</div>
<table class="table">
    <tr>
        <th width="100">Ref Article</th>
        <th>Designation</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php foreach($articles as $article): ?>
        <?php
            $hasLocal = isset($localArticles[$article->getRef()]);
        ?>

        <tr>
            <td><?php echo $article->getRef() ?></td>
            <td><?php echo $article->getDesignation() ?></td>
            <td>
                <?php if($hasLocal) : ?>
                    <i class="fa fa-save"></i>
                <?php endif ?>
            </td>
            <td>
                <?php if(!$hasLocal) : ?>
                    <a href="<?= $this->getAdminLink('saveArticleInLocal', array('ref'=>$article->getRef())) ?>" class="btn btn-success btn-xs">Sauvegarder en locale</a>
                <?php else : ?>
                    <!--<a href="" class="btn btn-danger btn-sm">Delete in local</a>-->
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>