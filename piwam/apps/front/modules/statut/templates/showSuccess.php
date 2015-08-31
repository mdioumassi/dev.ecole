<?php use_helper('Boolean') ?>
<?php use_helper('Date') ?>
<?php use_helper('Membre') ?>

<h2>Détails du Statut</h2>

<table class="tableauDetails">
    <tbody>
        <tr>
            <th>Id :</th>
            <td><?php echo $statut->getId() ?></td>
        </tr>
        <tr>
            <th>Nom :</th>
            <td><?php echo $statut->getNom() ?></td>
        </tr>
        <tr>
            <th>Actif :</th>
            <td><?php echo boolean2icon($statut->getActif()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
            Créé le :</th>
            <td><?php echo format_datetime($statut->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($statut->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
            Dernière mise à jour le :</th>
            <td><?php echo format_datetime($statut->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($statut->getMembreRelatedByMisAJourPar()) ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('statut/edit?id='.$statut->getId()) ?>">Éditer</a>
&nbsp;&bull;&nbsp;
<a href="<?php echo url_for('statut/index') ?>">Retour à la liste</a>
