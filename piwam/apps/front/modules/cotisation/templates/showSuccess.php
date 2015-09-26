<table>
    <tbody>
        <tr>
            <th>Id:</th>
            <td><?php echo $cotisation->getId() ?></td>
        </tr>
        <tr>
            <th>Compte:</th>
            <td><?php echo $cotisation->getCompteId() ?></td>
        </tr>
        <tr>
            <th>Cotisation type:</th>
            <td><?php echo $cotisation->getCotisationTypeId() ?></td>
        </tr>
        <tr>
            <th>Membre:</th>
            <td><?php echo $cotisation->getMembreId() ?></td>
        </tr>
        <tr>
            <th>Date:</th>
            <td><?php echo $cotisation->getDate() ?></td>
        </tr>
        <tr>
            <th>Created at:</th>
            <td><?php echo $cotisation->getCreatedAt() ?></td>
        </tr>
        <tr>
            <th>Updated at:</th>
            <td><?php echo $cotisation->getUpdatedAt() ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('cotisation/edit?id='.$cotisation->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cotisation/index') ?>">List</a>
