<h2>Mailing</h2>

<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>


<?php if ($sf_user->hasFlash('notice')): ?>
<p class="notice"><?php echo $sf_user->getFlash('notice') ?></p>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
<p class="error"><?php echo image_tag('error', array('align' => 'top', 'alt' => 'Erreur')) ?> <strong>ERREUR</strong>
: <?php echo $sf_user->getFlash('error') ?></p>
<?php endif; ?>

<?php  if (isset($content)): ?>
<div class="mailPreview">
<p><strong>Votre message :</strong>


<hr />
<?php echo html_entity_decode($content) ?></div>
<?php else: ?>

<form action="<?php echo url_for('association/mailing') ?>" method="post">
<table class="formArray">
    <tr>
        <td colspan="2"><?php
        if ($form->hasErrors())
        {
            echo '<div class="error">ERREUR : Vous devez entrer un sujet et un message</div>';
        }
        ?></td>
    </tr>
    <tr>
        <th>Objet</th>
        <td><?php echo $form['subject'] ?></td>
    </tr>
    <tr>
        <th>Destinataires</th>
        <td>Tout le monde</td>
    </tr>
    <tr>
        <th valign="top">Message</th>
        <td><?php echo $form['mail_content'] ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" class="button" value="envoyer" /></td>
    </tr>
</table>
</form>

<?php endif; ?>