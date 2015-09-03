<?php use_helper('Tooltip') ?>

<form action="<?php echo url_for('association/config') ?>" method="post">
<table class="formArray">
    <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="button" value="Sauvegarder" />
        
        </tr>
    </tfoot>

    <?php foreach ($form->getFormFieldSchema() as $widget): ?>
    <tr>
        <th><?php echo $widget->renderLabel() ?></th>
        <td><?php echo $widget ?> <?php if ($help = $form->getDescription($widget->getName())): ?>
        <?php echo tooltip_tag('', $help); ?> <?php endif; ?> <?php echo $widget->renderError() ?>
        </td>
        <?php endforeach; ?>

</table>
</form>
