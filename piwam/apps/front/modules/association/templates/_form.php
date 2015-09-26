<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('association/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<table class="formArray">

    <!-- Form footer : buttons -->

    <tfoot>
        <tr>
            <td colspan="2">
                <?php echo $form->renderHiddenFields() ?>
                <?php echo link_to('Annuler', 'membre/index', array('class'	=> 'formLinkButton')) ?>

                <!-- Display "next step" or "cancel" and "delete" buttons-->

                <?php if ($form->getObject()->isNew()): ?>
                    <input type="submit" value="Étape suivante >" class="button" />
                <?php else: ?>
                    <?php echo link_to('Supprimer', 'association/delete?id=' . $form->getObject()->getId(), array('class' => 'formLinkButton', 'method' => 'delete', 'confirm' => 'Êtes vous sûr ?')) ?>
                    <input type="submit" value="Sauvegarder" class="button" name="Sauvegarder" />
                <?php endif; ?>

            </td>
        </tr>
    </tfoot>


    <!-- Form widgets -->

    <tbody>
        <tr>
            <td colspan="2">
                <?php if ($form->hasGlobalErrors()): ?>
                    <div class="error"><?php $form->renderGlobalErrors() ?></div>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <th>Nom de l'association :</th>
            <td><?php echo $form['nom'] ?> <?php echo $form['nom']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['description']->renderLabel() ?></th>
            <td><?php echo $form['description'] ?> <?php echo $form['description']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['site_web']->renderLabel() ?></th>
            <td><?php echo $form['site_web'] ?> <?php echo $form['site_web']->renderError() ?>
            </td>
        </tr>


        <!-- Display a checkbox to warn Piwam's author -->

        <?php if ($form->getObject()->isNew()): ?>
            <tr>
                <th>Ping</th>
                <td><?php echo $form['ping_piwam'] ?> Dire à l'auteur que mon association utilise Piwam</td>
            </tr>
        <?php endif ?>

    </tbody>
</table>
</form>
