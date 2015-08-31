<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>


<form
    action="<?php echo url_for('cotisation/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Liste', 'cotisation/index', array(
            'class' => 'formLinkButton'
            )) ?> <?php echo link_to('Annuler', 'cotisation/index', array(
          	'class'	=> 'formLinkButton'
          	)) ?> <?php if (!$form->getObject()->isNew()): ?> <?php echo link_to('Supprimer',
          	  					 'cotisation/delete?id=' . $form->getObject()->getId(),
          	array('method'  => 'delete',
          	   					 	   'confirm' => 'Ètes vous sûr ?',
          	   					 	   'class'   => 'formLinkButton'));
          	?> <?php endif; ?> <input type="submit" value="Sauvegarder"
                class="button" /></td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th>Compte bénéficiaire :</th>
            <td><?php echo $form['compte_id'] ?> <?php echo $form['compte_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Type de cotisation</th>
            <td><?php echo $form['cotisation_type_id'] ?> <?php echo $form['cotisation_type_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Montant</th>
            <td><?php echo $form['montant'] ?> &euro; <?php echo $form['montant']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Membre :</th>
            <td><?php echo $form['membre_id'] ?> <?php echo $form['membre_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Date de versement :</th>
            <td><?php echo $form['date'] ?> <?php echo $form['date']->renderError() ?>
            </td>
        </tr>
    </tbody>
</table>
</form>

<!--
    Ajax updater can't update input form directly,
    so we update the following hidden <div>
-->
<div id="hiddenMontantValue"
    style="display: none"></div>

<!--
    The following AJAX behaviour update the hidden field
    with the requested amount, and then (onComplete)
    update the text input field
-->

<script type="text/javascript">
<!--
new Form.Element.EventObserver('cotisation_cotisation_type_id',
   function( element, value ) {
      new Ajax.Updater( 'hiddenMontantValue',  '<?php echo url_for("cotisationtype/ajaxgetamountfor") ?>?id=' + value, { onComplete: function () { updateAmont(value) }, parameters: id=value });
   }
);

function updateAmont(v) {
      document.getElementById('cotisation_montant').value = document.getElementById('hiddenMontantValue').innerHTML;
    }
//-->
</script>
