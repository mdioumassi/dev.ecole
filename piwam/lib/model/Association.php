<?php

class Association extends BaseAssociation
{
    /**
     * Display the name of the association if we want to display the
     * object.
     *
     * @return 	string
     * @since	r7
     */
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * Add all the default linked entities (Status, Activite...). This method
     * should be called when we register a new Association.
     *
     * @since	r16
     */
    public function initialize()
    {
        $statutPresident = new Statut();
        $statutPresident->setActif(ENABLED);
        $statutPresident->setAssociationId($this->getId());
        $statutPresident->setNom('Président');
        $statutPresident->save();

        $statutTresorier = new Statut();
        $statutTresorier->setActif(ENABLED);
        $statutTresorier->setAssociationId($this->getId());
        $statutTresorier->setNom('Trésorier');
        $statutTresorier->save();

        $statutSecretaire = new Statut();
        $statutSecretaire->setActif(ENABLED);
        $statutSecretaire->setAssociationId($this->getId());
        $statutSecretaire->setNom('Secrétaire');
        $statutSecretaire->save();

        $statutMembreActif = new Statut();
        $statutMembreActif->setActif(ENABLED);
        $statutMembreActif->setAssociationId($this->getId());
        $statutMembreActif->setNom('Membre actif');
        $statutMembreActif->save();

        $statutMembreDhonneur = new Statut();
        $statutMembreDhonneur->setActif(ENABLED);
        $statutMembreDhonneur->setAssociationId($this->getId());
        $statutMembreDhonneur->setNom('Membre d\'honneur');
        $statutMembreDhonneur->save();

        $activiteGeneral = new Activite();
        $activiteGeneral->setActif(ENABLED);
        $activiteGeneral->setLibelle("Fonctionnement général de l'association");
        $activiteGeneral->setAssociationId($this->getId());
        $activiteGeneral->save();

        $compteMonnaie = new Compte();
        $compteMonnaie->setAssociationId($this->getId());
        $compteMonnaie->setLibelle("Caisse de monnaie");
        $compteMonnaie->setReference("CAISSE_MONNAIE");
        $compteMonnaie->setActif(ENABLED);
        $compteMonnaie->save();
    }
}
