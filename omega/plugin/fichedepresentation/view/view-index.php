<?php echo $this->partialView('menu') ?>
<table class="table">
    <tr>
        <th>Reference Article</th>
        <th>Designation</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php foreach($localArticles as $article): ?>
        <tr>
            <td><?php echo $article->ref ?></td>
            <td><?php echo $article->name ?></td>
            <td>
                <i class="fa fa-picture-o" style="<?php echo $article->fkMediaImage == null ? 'opacity:.5;' : '' ?>"></i>
                <i class="fa fa-info-circle" style="<?php echo $article->fkMediaPanel == null ? 'opacity:.5' : '' ?>"></i>
                <i class="fa fa-cogs" style="<?php echo $article->fkMediaPres == null ? 'opacity:.5' : '' ?>"></i>

            </td>
            <td>
                <a href="<?php echo $this->getAdminLink('editLocale', array('id' => $article->id)) ?>">Modifier</a> |
                <a href="#" class="delete" data-url="<?php echo $this->getAdminLink('deleteLocale', array('id' => $article->id)) ?>">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>