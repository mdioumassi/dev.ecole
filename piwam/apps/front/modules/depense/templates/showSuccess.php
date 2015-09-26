<?php use_helper('Date') 	?>
<?php use_helper('Membre') 	?>
<?php use_helper('Boolean')  ?>
<?php use_helper('Number') 	?>

<h2>Détails d'une dépense d'argent</h2>
<table class="tableauDetails" id="details">
    <tbody>
        <tr>
            <th>Id :</th>
            <td><?php echo $depense->getId() ?></td>
        </tr>
        <tr>
            <th>Libellé :</th>
            <td><?php echo $depense->getLibelle() ?></td>
        </tr>
        <tr>
            <th>Montant :</th>
            <td><?php echo format_currency($depense->getMontant(), '&euro;') ?></td>
        </tr>
        <tr>
            <th>Compte affecté :</th>
            <td><?php echo $depense->getCompte()->getLibelle() ?></td>
        </tr>
        <tr>
            <th>Activité :</th>
            <td><?php echo $depense->getActivite() ?></td>
        </tr>
        <?php if ($depense->getPayee() == 1): ?>
        <tr>
            <th>Effective le :</th>
            <td><?php echo format_date($depense->getDate()) ?></td>
        </tr>
        <?php else: ?>
        <tr>
            <th>Payée :</th>
            <td><?php echo boolean2icon(false) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Créée le
            :</th>
            <td><?php echo format_datetime($depense->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($depense->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Mise à
            jour le :</th>
            <td><?php echo format_datetime($depense->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($depense->getMembreRelatedByMisAJourPar()) ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('depense/edit?id='.$depense->getId()) ?>">Editer</a>
&nbsp;
<a href="<?php echo url_for('depense/index') ?>">Retour</a>
