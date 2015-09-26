<?php use_helper('Number') ?>

<h2>Bilan</h2>

<?php
// Even if it's not really MVC compliant, we compute the total
// amount of Recette / Depense line by line directly within
// this view
$totalDepenses  = 0;
$totalRecettes  = 0;
$total          = 0;
?>


<h3>Par compte</h3>
<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th width="60%">Compte</th>
            <th width="10%">Dépenses</th>
            <th width="10%">Recettes</th>
            <th width="10%">Bilan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($comptes as $compte): ?>

        <tr class="<?php echo ($compte->isNegative()) ? 'compteNegatif' : 'comptePositif' ?>">
            <td><?php echo link_to($compte->getReference(), 'compte/show?id=' . $compte->getId(), array('class' => 'block')) ?></td>
            <td><?php echo format_currency($compte->getTotalDepenses()); $totalDepenses += $compte->getTotalDepenses() ?></td>
            <td><?php echo format_currency($compte->getTotalRecettes()); $totalRecettes += $compte->getTotalRecettes() ?></td>
            <td><?php echo format_currency($compte->getTotal()); $total += $compte->getTotal() ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="<?php echo ($total < 0) ? 'compteNegatif' : 'comptePositif' ?>">
            <td><strong>TOTAL</strong></td>
            <td><?php echo format_currency($totalDepenses, '&euro;') ?></td>
            <td><?php echo format_currency($totalRecettes, '&euro;') ?></td>
            <td><?php echo format_currency($total, '&euro;') ?></td>
        </tr>
    </tbody>
</table>



<h3>Par activité</h3>

<?php
// We re-initialize our counters
$totalDepenses  = 0;
$totalRecettes  = 0;
$total          = 0;
?>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th width="60%">Activité</th>
            <th width="10%">Dépenses</th>
            <th width="10%">Recettes</th>
            <th width="10%">Bilan</th>
        </tr>
    </thead>
    <tbody>
        <tr class="comptePositif">
            <td><?php echo link_to('Cotisations', 'cotisation/index', array('class' => 'block')) ?></td>
            <td><?php echo format_currency(0) ?></td>
            <td><?php echo format_currency($totalCotisations); $totalRecettes += $totalCotisations ?></td>
            <td><?php echo format_currency($totalCotisations); $total += $totalCotisations ?></td>
        </tr>

        <?php foreach ($activites as $activite): ?>
        <tr class="<?php echo ($activite->getTotal() < 0) ? 'compteNegatif' : 'comptePositif' ?>">
            <td><?php echo link_to($activite->getLibelle(), 'activite/show?id=' . $activite->getId(), array('class' => 'block')) ?></td>
            <td><?php echo format_currency($activite->getTotalDepenses()); $totalDepenses += $activite->getTotalDepenses() ?></td>
            <td><?php echo format_currency($activite->getTotalRecettes()); $totalRecettes += $activite->getTotalRecettes() ?></td>
            <td><?php echo format_currency($activite->getTotal()); $total += $activite->getTotal() ?></td>
        </tr>
        <?php endforeach; ?>

        <tr class="<?php echo ($total < 0) ? 'compteNegatif' : 'comptePositif' ?>">
            <td><strong>TOTAL</strong></td>
            <td><?php echo format_currency($totalDepenses, '&euro;') ?></td>
            <td><?php echo format_currency($totalRecettes, '&euro;') ?></td>
            <td><?php echo format_currency($total, '&euro;') ?></td>
        </tr>
    </tbody>
</table>

<h3>Créances et dettes</h3>
<table class="tableauDonnees">
    <tr class="comptePositif">
        <td width="60%">Créances</td>
        <td width="10%">-</td>
        <td width="10%"><?php echo format_currency($totalCreances) ?></td>
        <td width="10%">-</td>
    </tr>
    <tr class="<?php echo ($totalDettes == 0) ? "comptePositif" : "compteNegatif" ?>">
        <td>Dettes</td>
        <td><?php echo format_currency($totalDettes) ?></td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr class="<?php echo ($totalPrevu < 0) ? "compteNegatif" : "comptePositif" ?>">
        <td><strong>TOTAL</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo format_currency($totalPrevu, '&euro;') ?></td>
    </tr>
</table>

<p style="padding: 10px; background-color: #eee; width: 88%">
    Une discussion est actuellement en cours afin d'améliorer ce "bilan" (export
    PDF, formalisme comptable..)<br />
    N'hésitez pas à <a href="http://code.google.com/p/piwam/wiki/ReflexionCompta">
    donner votre avis</a>.
</p>
