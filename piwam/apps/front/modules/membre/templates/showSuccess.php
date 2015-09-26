<?php use_helper('Date') 	?>
<?php use_helper('Membre') 	?>
<?php use_helper('Phone')  ?>
<?php use_helper('Boolean') ?>
<?php use_helper('JavascriptBase') ?>
<?php use_javascript('domtab/domtab.js') ?>
<?php use_stylesheet('domtab.css') ?>

<div class="domtab">
<ul class="domtabs">
    <li><a href="#t1">Profil</a></li>
    <li><a href="#t2">Cotisations</a></li>
    <li><a href="#t3">Droits</a></li>
</ul>

<!-- New  tab : user profile-->
<div>
    <h2><a name="t1" id="t1">Informations détaillées</a> &nbsp; <?php echo link_to(image_tag('edit', array('alt' => '[modifier]')), 'membre/edit?id='.$membre->getId() . '#profil') ?></h2>

    <table class="tableauDetails" id="details">

        <tfoot>
            <tr>
                <td colspan="2">
                    <?php echo link_to('Éditer', 'membre/edit?id=' . $membre->getId() . '#profil', array('class'  => 'formLinkButton')) ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <th>Photo :</th>
                <td><?php echo image_tag($membre->getPictureURI()) ?></td>
            </tr>
            <tr>
                <th>Nom :</th>
                <td><?php echo $membre->getNom() ?></td>
            </tr>
            <tr>
                <th>Prénom :</th>
                <td><?php echo $membre->getPrenom() ?></td>
            </tr>
            <tr>
                <th>Pseudo :</th>
                <td><?php echo $membre->getPseudo() ?></td>
            </tr>
            <tr>
                <th>Statut :</th>
                <td><?php echo $membre->getStatut() ?></td>
            </tr>
            <tr>
                <th>Date d'inscription :</th>
                <td><?php echo format_date($membre->getDateInscription()) ?></td>
            </tr>
            <tr>
                <th>Exempté de cotisation :</th>
                <td><?php echo boolean2icon($membre->getExempteCotisation()) ?></td>
            </tr>
            <tr>
                <th>Adresse :</th>
                <td><?php echo $membre->getRue() . '<br />' . $membre->getCp() . ' ' . $membre->getVille() ?></td>
            </tr>
            <tr>
                <th>Pays :</th>
                <td><?php echo image_tag('flags/' . strtolower($membre->getPays()), array('alt' => $membre->getPays(), 'title' => $membre->getPays())) ?></td>
            </tr>
            <tr>
                <th>Email :</th>
                <td><?php echo mail_to($membre->getEmail()) ?></td>
            </tr>
            <tr>
                <th>Site Internet :</th>
                <td><?php echo '<a href="' . $membre->getWebsite() . '">' . $membre->getWebsite() . '</a>' ?></td>
            </tr>
            <tr>
                <th>Téléphone fixe :</th>
                <td><?php echo format_phonenumber($membre->getTelfixe()) ?></td>
            </tr>
            <tr>
                <th>Téléphone portable :</th>
                <td><?php echo format_phonenumber($membre->getTelportable()) ?></td>
            </tr>
            <tr>
                <th>Actif :</th>
                <td><?php echo boolean2icon($membre->getActif()) ?></td>
            </tr>
            <tr>
                <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
                Enregistré le :</th>
                <td><?php echo format_datetime($membre->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByEnregistrePar()) ?></td>
            </tr>
            <tr>
                <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?>
                Dernière édition :</th>
                <td><?php echo format_datetime($membre->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByMisAJourPar()) ?></td>
            </tr>
        </tbody>
    </table>
</div>


<!-- New tab : fees -->

<div>
    <h2><a name="t2" id="t2">Liste des cotisations</a></h2>
    <div id="listOfCotisation" class="info">
        <ul>
            <?php if (count($cotisations) == 0): ?>
                <li><i>Aucune cotisation versée par ce membre.</i></li>
            <?php endif; ?>

            <?php foreach ($cotisations as $cotisation): ?>
                <li><?php echo $cotisation->getCotisationType() ?> versée le <?php echo $cotisation->getDate() ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


<!-- New tab -->
<div>
<h2><a name="t3" id="t3">Droits de l'utilisateur</a> &nbsp; <?php echo link_to(image_tag('edit', array('alt' => '[modifier]')), 'membre/edit?id='.$membre->getId() . '#credentials') ?></h2>
<div>
<ul>
<?php if (count($credentials) == 0): ?>
    <li><i>Ce membre n'a aucun droit pour le moment.</i></li>
    <?php endif; ?>

    <?php foreach ($credentials as $credential): ?>
    <li>&bull; <?php echo $credential->getAclAction()->getLibelle() ?></li>
    <?php endforeach; ?>
</ul>
</div>
</div>


</div>
<!-- domtab -->
