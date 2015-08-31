<form action="<?php echo url_for('install/configDatabase') ?>" method="post">
<table class="formArray">
    <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="button" value="Valider" /></td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <th>Serveur</th>
            <td><?php echo $form['mysql_server'] . $form['mysql_server']->renderError() ?></td>
        </tr>
        <tr>
            <th>Nom d'utilisateur</th>
            <td><?php echo $form['mysql_username'] . $form['mysql_username']->renderError() ?></td>
        </tr>
        <tr>
            <th>Mot de passe</th>
            <td><?php echo $form['mysql_password'] . $form['mysql_password']->renderError() ?></td>
        </tr>
        <tr>
            <th>Base de donnée</th>
            <td><?php echo $form['mysql_dbname'] . $form['mysql_dbname']->renderError() ?></td>
        </tr>
    </tbody>
</table>
</form>
