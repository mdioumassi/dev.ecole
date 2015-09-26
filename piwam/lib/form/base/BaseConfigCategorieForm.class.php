<?php

/**
 * ConfigCategorie form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseConfigCategorieForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'code'    => new sfWidgetFormInputHidden(),
      'libelle' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
      'code'    => new sfValidatorPropelChoice(array('model' => 'ConfigCategorie', 'column' => 'code', 'required' => false)),
      'libelle' => new sfValidatorString(array('max_length' => 255)),
        ));

        $this->widgetSchema->setNameFormat('config_categorie[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'ConfigCategorie';
    }


}
