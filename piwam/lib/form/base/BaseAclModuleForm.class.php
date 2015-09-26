<?php

/**
 * AclModule form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAclModuleForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'libelle' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'AclModule', 'column' => 'id', 'required' => false)),
      'libelle' => new sfValidatorString(array('max_length' => 255)),
        ));

        $this->widgetSchema->setNameFormat('acl_module[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'AclModule';
    }


}
