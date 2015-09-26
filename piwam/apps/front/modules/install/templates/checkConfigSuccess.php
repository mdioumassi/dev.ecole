<h2>Vérification de la configuration</h2>

<ul>
<?php foreach ($messages as $message): ?>
    <li class="<?php echo $message['cssClass'] ?>"><?php include_partial($message['partial'], array('error' => $message['error'])) ?>
    </li>
    <?php endforeach; ?>
</ul>


<!-- If no error occured, we display the button -->

    <?php if ($displayButton): ?>
<br />
    <?php echo link_to('Suivant', 'install/configDatabase', array('class' => 'formLinkButton')) ?>
    <?php endif; ?>