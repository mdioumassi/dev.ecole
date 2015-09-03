<?php
/**
 * Represents the list of checkbox to edit credentials that
 * we can set/unset for an user
 *
 * @since   r60
 */
class AclCredentialForm extends sfForm
{
    protected $_user_id;
    protected $_modules = array();

    /**
     * Get the name of module linked to the ID in parameter,
     * according to the stored array which is build in configure()
     * method
     *
     * @param   integer $id
     * @return  string
     */
    public function getModuleName($id)
    {
        return $this->_modules[$id];
    }

    /**
     * Set UserID
     *
     * @param   integer $user_id
     */
    public function setUserId($user_id)
    {
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
        $this->setDefault('user_id', $user_id);
        $this->_user_id = $user_id;
    }

    /**
     * Build the form after retrieving the list of modules and actions
     * The array _modules is also filled
     */
    public function configure()
    {
        $this->widgetSchema['rights']       = new sfWidgetFormSchema();
        $this->validatorSchema              = new sfValidatorSchema();
        $this->validatorSchema['user_id']   = new sfValidatorInteger();
        $this->validatorSchema['rights']    = new sfValidatorPass();

        $modules = AclModulePeer::doSelect(new Criteria());
        foreach ($modules as $module)
        {
            $this->widgetSchema['rights'][$module->getId()] = new sfWidgetFormSchema();
            $this->_modules[$module->getId()] = $module->getLibelle();
            $actions = AclActionPeer::doSelectForModuleId($module->getId());
            foreach ($actions as $action)
            {
                $this->widgetSchema['rights'][$module->getId()][$action->getCode()] = new sfWidgetFormInputCheckbox();
                $this->widgetSchema['rights'][$module->getId()]->setLabel($action->getCode(), $action->getLibelle());
            }
        }

        $this->widgetSchema->setNameFormat('rights[%s]');
    }

    /*
     * Check the checkboxes automatically if we are editing existing
     * rights
     */
    public function automaticCheck()
    {
        $credentials = AclCredentialPeer::doSelectForMembreId($this->_user_id);

        foreach ($credentials as $credential) {
            $this->widgetSchema['rights'][$credential->getModuleId()][$credential->getCode()]->setAttribute('checked', 'checked');
        }
    }
}
?>