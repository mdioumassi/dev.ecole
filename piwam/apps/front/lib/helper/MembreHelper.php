<?php
/**
 * Format a Membre object to display it correctly with a link
 * to it.
 *
 * @param 	Membre 	$membre
 * @param	boolean	$pseudo : display only the pseudo
 * @return 	string
 * @since	r8
 */
function format_membre($membre, $pseudo = false)
{
    if ((is_null($membre)) || (! $membre->getRawValue() instanceof  Membre))
    {
        $str = '<i>Système</i>';
    }
    else
    {
        $str = '<a href="' . url_for('membre/show?id=' . $membre->getId()) . '">';

        if ($pseudo)
        {
            $str .= $membre->getPseudo();
        }
        else
        {
            $str .= $membre->getPrenom() . ' ' .$membre->getNom();
        }
        $str .= '</a>';
    }

    return $str;
}
?>