<?php

/**
 * CotisationType form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CotisationTypeForm extends BaseCotisationTypeForm
{
    public function configure()
    {
        unset($this['created_at'], $this['updated_at']);
        unset($this['enregistre_par'], 	$this['mis_a_jour_par']);
        unset($this['actif'], 			$this['association_id']);

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

        $this->setDefault('valide', 12);
        $this->widgetSchema['montant']->setAttribute('class', 'formInputShort');
        $this->widgetSchema['valide']->setAttribute('class', 'formInputShort');
        $this->widgetSchema['libelle']->setAttribute('class', 'formInputLarge');

        // We do not allow negative values
        $this->validatorSchema['montant'] = new sfValidatorNumber(array('min' => 0), array('min' => 'ne peut être négatif'));
        $this->validatorSchema['valide'] = new sfValidatorInteger(array('min' => 0), array('min' => 'ne peut être négatif'));

        $this->setLabels();
    }

    /**
     * Set labels for each widgets
     */
    protected function setLabels()
    {
        $this->widgetSchema->setLabels(array(
            'montant'   => 'Montant',
            'Valide'    => 'Valide',
            'libelle'   => 'Libellé',
        ));
    }
}
