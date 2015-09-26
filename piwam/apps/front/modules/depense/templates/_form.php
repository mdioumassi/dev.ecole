<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('depense/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Annuler', 'depense/index', array(
            	'class'	=> 'formLinkButton'
            	)) ?> <?php if (!$form->getObject()->isNew()): ?> <?php echo link_to('Supprimer', 'depense/delete?id=' . $form->getObject()->getId(), array(
                	'class'		=> 'formLinkButton',
                	'method' 	=> 'delete', 'confirm' => 'Êtes vous sûr ?'
                	)) ?> <?php endif; ?> <input type="submit" value="Sauvegarder"
                class="button" /></td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th>Libellé</th>
            <td><?php echo $form['libelle'] ?> <?php echo $form['libelle']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['montant']->renderLabel() ?></th>
            <td><?php echo $form['montant'] ?> &euro; <?php echo $form['montant']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Compte affecté</th>
            <td><?php echo $form['compte_id'] ?> <?php echo $form['compte_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Activité liée</th>
            <td><?php echo $form['activite_id'] ?> <?php echo $form['activite_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['date']->renderLabel() ?></th>
            <td><?php echo $form['date'] ?> <?php echo $form['date']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Payée</th>
            <td><?php echo $form['payee'] ?></td>
        </tr>
    </tbody>
</table>
</form>
