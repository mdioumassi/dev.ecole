<?php

/**
 * CotisationType form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCotisationTypeForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'libelle'        => new sfWidgetFormInput(),
      'association_id' => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => false)),
      'valide'         => new sfWidgetFormInput(),
      'montant'        => new sfWidgetFormInput(),
      'actif'          => new sfWidgetFormInputCheckbox(),
      'enregistre_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'mis_a_jour_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
        ));

        $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'CotisationType', 'column' => 'id', 'required' => false)),
      'libelle'        => new sfValidatorString(array('max_length' => 255)),
      'association_id' => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id')),
      'valide'         => new sfValidatorInteger(),
      'montant'        => new sfValidatorNumber(),
      'actif'          => new sfValidatorBoolean(array('required' => false)),
      'enregistre_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'mis_a_jour_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('cotisation_type[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'CotisationType';
    }


}
