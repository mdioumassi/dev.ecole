<?php

/**
 * PiwamData form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePiwamDataForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'key'   => new sfWidgetFormInput(),
      'value' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
      'id'    => new sfValidatorPropelChoice(array('model' => 'PiwamData', 'column' => 'id', 'required' => false)),
      'key'   => new sfValidatorString(array('max_length' => 255)),
      'value' => new sfValidatorString(array('max_length' => 255)),
        ));

        $this->validatorSchema->setPostValidator(
        new sfValidatorPropelUnique(array('model' => 'PiwamData', 'column' => array('key')))
        );

        $this->widgetSchema->setNameFormat('piwam_data[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'PiwamData';
    }


}
