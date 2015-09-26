<?php use_helper('Date') ?>
<?php use_helper('Membre') ?>
<?php use_helper('Number') ?>

<h2>Détails pour "<?php echo $activite->getLibelle() ?>"</h2>

<table class="tableauDetails">
    <tbody>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
            Enregistrée le :</th>
            <td><?php echo format_datetime($activite->getCreatedAt(), 'dd/MM/yyyy HH:mm') ?>
            par <?php echo format_membre($activite->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
            Mise à jour le :</th>
            <td>
            	<?php if ($activite->getMisAJourPar()):?>
	                <?php echo format_datetime($activite->getUpdatedAt(), 'dd/MM/yyyy HH:mm') ?>
            		par <?php echo format_membre($activite->getMembreRelatedByMisAJourPar())?>
                <?php else: ?>
                    <i>Aucune mise à jour pour le moment</i>
                <?php endif; ?>
        	</td>
        </tr>
    </tbody>
</table>


<h3>Recettes et dépenses</h3>

<?php
$totalRecettes = 0;
$totalDepenses = 0;
?>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th>Libellé</th>
            <th>Débit</th>
            <th>Crédit</th>
            <th>Compte</th>
            <th>Date</th>
        </tr>
    </thead>

    <?php foreach ($data as $entry): ?>
    <tr>
        <td><?php echo $entry->getLibelle() ?></td>
        <?php if ($entry->getRawValue() instanceof Depense):?>
        <td class="compteNegatif"><?php echo format_currency($entry->getMontant()); $totalDepenses += $entry->getMontant() ?></td>
        <td>&nbsp;</td>
        <?php else: ?>
        <td>&nbsp;</td>
        <td class="comptePositif"><?php echo format_currency($entry->getMontant()); $totalRecettes += $entry->getMontant() ?></td>
        <?php endif; ?>
        <td><?php echo $entry->getCompte()->getReference() ?></td>
        <td><?php echo format_date($entry->getDate()) ?></td>
    </tr>
    <?php endforeach; ?>

    <tr
        class="<?php echo ($totalRecettes - $totalDepenses < 0) ? 'compteNegatif' : 'comptePositif'; ?>">
        <td><strong>Total</strong></td>
        <td><?php echo format_currency($totalDepenses); ?></td>
        <td><?php echo format_currency($totalRecettes); ?></td>
        <td>&nbsp;</td>
        <td><?php echo format_currency($totalRecettes - $totalDepenses) ?></td>
    </tr>
</table>

<h3>Créances et dettes</h3>

<table class="tableauDonnees">
    <tr class="comptePositif">
        <td width="60%">Créances</td>
        <td width="10%">-</td>
        <td width="10%"><?php echo format_currency($creances) ?></td>
        <td width="10%">-</td>
    </tr>
    <tr class="<?php echo ($dettes == 0) ? "comptePositif" : "compteNegatif" ?>">
        <td>Dettes</td>
        <td><?php echo format_currency($dettes) ?></td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr
        class="<?php echo ($totalPrevu < 0) ? "compteNegatif" : "comptePositif" ?>">
        <td><strong>TOTAL</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo format_currency($totalPrevu, '&euro;') ?></td>
    </tr>
</table>
