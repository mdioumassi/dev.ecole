<?php

/**
 * AclCredential form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAclCredentialForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'membre_id'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'acl_action_id' => new sfWidgetFormPropelChoice(array('model' => 'AclAction', 'add_empty' => false)),
        ));

        $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'AclCredential', 'column' => 'id', 'required' => false)),
      'membre_id'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'acl_action_id' => new sfValidatorPropelChoice(array('model' => 'AclAction', 'column' => 'id')),
        ));

        $this->widgetSchema->setNameFormat('acl_credential[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'AclCredential';
    }


}
