<?php
use_helper('Date');
?>

<h2>Liste des comptes</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th>Libellé</th>
            <th>Référence</th>
            <th>Enregistré le</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($compte_list as $compte): ?>
        <tr>
            <td><?php echo $compte->getLibelle() ?></td>
            <td><?php echo $compte->getReference() ?></td>
            <td><?php echo format_date($compte->getCreatedAt()) ?></td>
            <td><a
                href="<?php echo url_for('compte/show?id='.$compte->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[details]')); ?></a>
            <a href="<?php echo url_for('compte/edit?id='.$compte->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')); ?></a>
            <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')),
            			 	'compte/delete?id=' . $compte->getId(),
            array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?'));
            ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew"><?php echo link_to(image_tag('add', array('align'=>'top', 'alt' => '[ajouter]')). ' Enregistrer un compte', 'compte/new') ?>
</div>
