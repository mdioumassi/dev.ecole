<?php

/**
 * Association form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AssociationForm extends BaseAssociationForm
{
    public function configure()
    {
        unset($this['created_at'], $this['updated_at']);
        unset($this['enregistre_par'], $this['mis_a_jour_par']);
        unset($this['actif'], $this['association_id']);
        unset($this['description']);

        if (! $this->getObject()->isNew())
        {
            $this->widgetSchema['mis_a_jour_par'] = new sfWidgetFormInputHidden();
            $this->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
            $this->validatorSchema['mis_a_jour_par'] = new sfValidatorInteger(array('required' => false));
        }
        else
        {
            $this->widgetSchema['ping_piwam'] = new sfWidgetFormInputCheckbox();
            $this->setDefault('ping_piwam', true);
            $this->validatorSchema['ping_piwam'] = new sfValidatorBoolean();
        }

        $this->widgetSchema['description'] = new sfWidgetFormTextarea();
        $this->validatorSchema['description'] = new sfValidatorString(array('required' => false));

        $this->widgetSchema['actif'] = new sfWidgetFormInputHidden();
        $this->setDefault('actif', 1);

        $this->validatorSchema['site_web'] = new sfValidatorUrl(array('required' => false));
        $this->validatorSchema['actif'] = new sfValidatorBoolean();

        // r15 : set length of fields
        $this->widgetSchema['nom']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['description']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['site_web']->setAttribute('class', 'formInputLarge');
    }
}
