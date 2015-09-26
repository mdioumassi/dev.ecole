<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('statut/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Annuler', 'statut/index', array(
                	'class'	=> 'formLinkButton'
                	)) ?> <?php if (!$form->getObject()->isNew()): ?> <?php echo link_to('Supprimer', 'statut/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?', 'class' => 'formLinkButton')) ?>
                	<?php endif; ?> <input class="button" type="submit"
                value="Enregistrer" /></td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th>Libellé du statut :</th>
            <td><?php echo $form['nom'] ?> <?php echo $form['nom']->renderError() ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
