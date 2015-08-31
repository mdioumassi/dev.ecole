<?php
/**
 * Represents the search form to search members
 *
 * @author adrien
 */
class SearchUserForm extends sfForm
{
    /**
     * Set fields to search a member. Be careful, the name of 'magic'
     * field will be changed because by the sfFormExtraPlugin.
     * The new name will be autocomplete_myform['magic']
     *
     * @see lib/vendor/symfony/1.2/lib/form/sfForm#configure()
     */
    public function configure()
    {
        $this->setWidgets(array(
          'magic'           => new sfWidgetFormJQueryAutocompleter(array(
                                                    'url'    => $this->getOption('ajaxUrl'),
                                                    'config' => '{ extraParams: { association_id: function() { return jQuery("#search_associationId").val(); } },
                                                                   scrollHeight: 250 ,
                                                                   autoFill: true
                                                                  }')),
          'associationId'   => new sfWidgetFormInputHidden(),
        ));


        $this->setValidators(array(
          'magic'           => new sfValidatorString(array('required' => true)),
          'associationId'   => new sfValidatorInteger(array('required' => true)),
        ));

        $this->widgetSchema->setNameFormat('search[%s]');
        $this->setDefault('associationId', $this->getOption('associationId'));
    }
}
?>