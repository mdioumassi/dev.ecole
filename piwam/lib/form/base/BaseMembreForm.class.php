<?php

/**
 * Membre form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMembreForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'nom'                => new sfWidgetFormInput(),
      'prenom'             => new sfWidgetFormInput(),
      'pseudo'             => new sfWidgetFormInput(),
      'password'           => new sfWidgetFormInput(),
      'statut_id'          => new sfWidgetFormPropelChoice(array('model' => 'Statut', 'add_empty' => false)),
      'date_inscription'   => new sfWidgetFormDate(),
      'exempte_cotisation' => new sfWidgetFormInputCheckbox(),
      'rue'                => new sfWidgetFormInput(),
      'cp'                 => new sfWidgetFormInput(),
      'ville'              => new sfWidgetFormInput(),
      'pays'               => new sfWidgetFormInput(),
      'email'              => new sfWidgetFormInput(),
      'website'            => new sfWidgetFormInput(),
      'tel_fixe'           => new sfWidgetFormInput(),
      'tel_portable'       => new sfWidgetFormInput(),
      'actif'              => new sfWidgetFormInputCheckbox(),
      'association_id'     => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => false)),
      'enregistre_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
        ));

        $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'nom'                => new sfValidatorString(array('max_length' => 255)),
      'prenom'             => new sfValidatorString(array('max_length' => 255)),
      'pseudo'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'password'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'statut_id'          => new sfValidatorPropelChoice(array('model' => 'Statut', 'column' => 'id')),
      'date_inscription'   => new sfValidatorDate(),
      'exempte_cotisation' => new sfValidatorBoolean(),
      'rue'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cp'                 => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'ville'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pays'               => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tel_fixe'           => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'tel_portable'       => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'actif'              => new sfValidatorBoolean(array('required' => false)),
      'association_id'     => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id')),
      'enregistre_par'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'mis_a_jour_par'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
        ));

        $this->validatorSchema->setPostValidator(
        new sfValidatorPropelUnique(array('model' => 'Membre', 'column' => array('pseudo')))
        );

        $this->widgetSchema->setNameFormat('membre[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'Membre';
    }


}
