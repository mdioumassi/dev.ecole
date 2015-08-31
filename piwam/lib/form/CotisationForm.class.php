<?php

/**
 * Cotisation form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CotisationForm extends BaseCotisationForm
{
    /**
     * Customizes the Cotisation form. There is a lot of fields to unset in
     * order to re-create them from scratch with custom behaviour, especially
     * the hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        unset($this['created_at'], $this['updated_at']);
        unset($this['enregistre_par'], $this['mis_a_jour_par']);
        unset($this['actif'], $this['association_id']);
        unset($this['date']);

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

        // select only Membre, CotisationType and Compte which
        // belong to the association id

        $id = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
        $this->widgetSchema['membre_id']->setOption('criteria', MembrePeer::getCriteriaForAssociationId($id));
        $this->widgetSchema['cotisation_type_id']->setOption('criteria', CotisationTypePeer::getCriteriaForAssociationId($id));
        $this->widgetSchema['cotisation_type_id']->setOption('add_empty', true);
        $this->widgetSchema['compte_id']->setOption('criteria', ComptePeer::getCriteriaForAssociationId($id));

        $this->widgetSchema['compte_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['cotisation_type_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['membre_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['montant']->setAttribute('class', 'formInputShort');

        $this->validatorSchema['actif'] = new sfValidatorBoolean();
        $this->validatorSchema['montant'] = new sfValidatorAmount(array('min' => 0), array('min' => 'ne peut être négatif'));

        sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
        $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array(
			'image'		=> image_path('calendar.gif'),
  			'config' 	=> '{}',
			'culture'	=> 'fr_FR',
			'format'	=> '%day%.%month%.%year%',
        ));

        $this->setDefault('date', date('y-m-d'));
        $this->validatorSchema['date'] = new sfValidatorDate();
    }
}
