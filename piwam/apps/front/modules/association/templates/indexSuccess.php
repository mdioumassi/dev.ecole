<?php use_helper('website') ?>

<h2>Associations enregistrées</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th style="width: 25%">Nom</th>
            <th style="width: 40%">Description</th>
            <th style="width: 20%">Site web</th>
            <th style="width: 15%">Enregistrée par</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($associationsPager->getResults() as $association): ?>
        <tr>
            <td><?php echo $association->getNom() ?></td>
            <td><?php echo $association->getDescription() ?></td>
            <td>
                <?php if ($association->getSiteWeb()): ?>
                    <?php echo link_to(short_website_url($association->getSiteWeb()),  $association->getSiteWeb()) ?>
                <?php endif ?>
            </td>
            <td><?php echo $association->getMembreRelatedByEnregistrePar() ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew"
    style="width: 214px; background-color: #EAEAEA; border: 3px solid #EAEAEA;">
        <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Enregistrer une association', 'association/new') ?>
</div>

<?php include_partial('global/pager', array('pager' => $associationsPager, 'module' => 'association', 'action' => 'index', 'params' => array())) ?>