<?php use_helper('Membre') ?>
<?php use_helper('Date') ?>

<h2>Détails du compte <?php echo $compte->getReference() ?></h2>

<table class="tableauDetails" summary="Details of an account">
    <tbody>
        <tr>
            <th>Libellé :</th>
            <td><?php echo $compte->getLibelle() ?></td>
        </tr>
        <tr>
            <th>Référence :</th>
            <td><?php echo $compte->getReference() ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
            Enregistré le :</th>
            <td><?php echo format_datetime($compte->getCreatedAt(), 'dd/MM/yyyy HH:mm') ?>
            par <?php echo format_membre($compte->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th>
                <?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
                Mise à jour le :
            </th>
            <td>
                <?php if ($compte->getMisAJourPar()):?>
                    <?php echo format_datetime($compte->getUpdatedAt(), 'dd/MM/yyyy HH:mm') ?>
                    par <?php echo format_membre($compte->getMembreRelatedByMisAJourPar()) ?>
                <?php else: ?>
                    <i>Aucune mise à jour pour le moment</i>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('compte/edit?id='.$compte->getId()) ?>">Editer</a>
&bull;
<a href="<?php echo url_for('compte/index') ?>">Retour &agrave; la liste</a>
