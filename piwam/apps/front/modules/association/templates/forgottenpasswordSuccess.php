<h2>Mot de passe oublié</h2>

<?php if ($sf_user->hasFlash('error')): ?>
    <p class="error">
        <?php echo image_tag('error', array('alt' => '[erreur]', 'align' => 'top')) ?>
        <?php echo $sf_user->getFlash('error') ?>
    </p>
<?php endif; ?>

<?php if ($sf_user->hasFlash('notice')): ?>
    <p class="notice">
        <?php echo $sf_user->getFlash('notice') ?>
    </p>
<?php endif; ?>


<form action="<?php echo url_for('association/forgottenpassword') ?>" method="post">
<table class="formArray">
    <tr>
        <td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
    </tr>
    <tr>
        <th>Votre nom d'utilisateur :</th>
        <td><?php echo $form['username'] . $form['username']->renderError() ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="submit" value="Valider" class="button" name="Valider" />
        </td>
    </tr>
</table>
</form>