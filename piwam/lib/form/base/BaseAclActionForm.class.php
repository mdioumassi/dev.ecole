<?php

/**
 * AclAction form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAclActionForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'acl_module_id' => new sfWidgetFormPropelChoice(array('model' => 'AclModule', 'add_empty' => false)),
      'libelle'       => new sfWidgetFormInput(),
      'code'          => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'AclAction', 'column' => 'id', 'required' => false)),
      'acl_module_id' => new sfValidatorPropelChoice(array('model' => 'AclModule', 'column' => 'id')),
      'libelle'       => new sfValidatorString(array('max_length' => 255)),
      'code'          => new sfValidatorString(array('max_length' => 100)),
        ));

        $this->widgetSchema->setNameFormat('acl_action[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'AclAction';
    }


}
