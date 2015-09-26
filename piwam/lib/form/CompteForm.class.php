<?php

/**
 * Compte form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CompteForm extends BaseCompteForm
{
    /**
     * Customizes the Compte form. There is a lot of fields to unset in order
     * to re-create them from scratch with custom behaviour, especially the
     * hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        $associationId = $this->getOption('associationId');
        unset($this['created_at'], $this['updated_at']);
        unset($this['enregistre_par'], $this['mis_a_jour_par']);
        unset($this['actif'], $this['association_id']);

        if ($this->getObject()->isNew())
        {
            $this->widgetSchema['enregistre_par'] = new sfWidgetFormInputHidden();
            $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
            $this->validatorSchema['association_id'] = new sfValidatorInteger();
            $this->validatorSchema['enregistre_par'] = new sfValidatorInteger();
        }
        else
        {
            $this->widgetSchema['mis_a_jour_par'] = new sfWidgetFormInputHidden();
            $this->validatorSchema['mis_a_jour_par'] = new sfValidatorInteger();
        }

        $this->widgetSchema['actif'] = new sfWidgetFormInputHidden();
        $this->setDefault('actif', 1);

        $this->validatorSchema['actif'] = new sfValidatorBoolean();
        $this->validatorSchema['reference'] = new sfValidatorCustomUnique(array('class' => 'Compte', 'fields' => array('reference' => null, 'association_id' => $associationId)));
        $this->validatorSchema['libelle'] = new sfValidatorCustomUnique(array('class' => 'Compte', 'fields' => array('libelle' => null, 'association_id' => $associationId)));

        $this->widgetSchema['libelle']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['reference']->setAttribute('class', 'formInputNormal');
        $this->setLabels();
    }

    /**
     * Set the label of the different fields
     */
    protected function setLabels()
    {
        $this->widgetSchema->setLabels(array(
            'libelle'   => 'Libellé',
            'reference' => 'Référence',
        ));
    }
}
