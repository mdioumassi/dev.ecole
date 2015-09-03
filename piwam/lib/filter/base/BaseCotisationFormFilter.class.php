<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Cotisation filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCotisationFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
      'compte_id'          => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => true)),
      'cotisation_type_id' => new sfWidgetFormPropelChoice(array('model' => 'CotisationType', 'add_empty' => true)),
      'membre_id'          => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'date'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'enregistre_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'montant'            => new sfWidgetFormFilterInput(),
      'mis_a_jour_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
        ));

        $this->setValidators(array(
      'compte_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Compte', 'column' => 'id')),
      'cotisation_type_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CotisationType', 'column' => 'id')),
      'membre_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'date'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'enregistre_par'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'montant'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'mis_a_jour_par'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
        ));

        $this->widgetSchema->setNameFormat('cotisation_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'Cotisation';
    }

    public function getFields()
    {
        return array(
      'id'                 => 'Number',
      'compte_id'          => 'ForeignKey',
      'cotisation_type_id' => 'ForeignKey',
      'membre_id'          => 'ForeignKey',
      'date'               => 'Date',
      'enregistre_par'     => 'ForeignKey',
      'montant'            => 'Number',
      'mis_a_jour_par'     => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
        );
    }
}
