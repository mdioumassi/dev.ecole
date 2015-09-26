<?php

/**
 * Depense form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class DepenseForm extends BaseDepenseForm
{
    /**
     * Customizes the Recette form. There is a lot of fields to unset in order
     * to re-create them from scratch with custom behaviour, especially the
     * hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        unset($this['created_at'], 		$this['updated_at']);
        unset($this['enregistre_par'], 	$this['mis_a_jour_par']);
        unset($this['actif'], 			$this['association_id']);

        if ($this->getObject()->isNew()) {
            $this->widgetSchema['enregistre_par'] = new sfWidgetFormInputHidden();
            $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
            $this->setDefault('enregistre_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
            $this->setDefault('association_id', sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user'));
            $this->validatorSchema['association_id'] = new sfValidatorInteger();
            $this->validatorSchema['enregistre_par'] = new sfValidatorInteger();
        }

        $this->widgetSchema['mis_a_jour_par'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['actif'] = new sfWidgetFormInputHidden();
        $this->setDefault('actif', 1);

        $this->validatorSchema['mis_a_jour_par'] = new sfValidatorInteger();
        $this->validatorSchema['actif'] = new sfValidatorBoolean();
        $this->validatorSchema['montant'] = new sfValidatorAmount(array('min' => 0), array('min' => 'ne peut être négatif'));

        // select only Membre, CotisationType and Compte which
        // belong to the association id

        $id = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
        $this->widgetSchema['compte_id']->setOption('criteria', ComptePeer::getCriteriaForAssociationId($id));
        $this->widgetSchema['activite_id']->setOption('criteria', ActivitePeer::getCriteriaForAssociationId($id));

        // r19 : customize the appearance
        $this->widgetSchema['libelle']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['montant']->setAttribute('class', 'formInputShort');

        sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
        $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array(
			'image'		=> image_path('calendar.gif'),
  			'config' 	=> '{}',
			'culture'	=> 'fr_FR',
			'format'	=> '%day%.%month%.%year%',
        ));
        $this->setDefault('date', date('y-m-d'));
        $this->widgetSchema['compte_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['activite_id']->setAttribute('class', 'formInputLarge');
    }
}
