<?php

/**
 * Criteria filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCriteriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'unit'    => new sfWidgetFormFilterInput(),
      'type'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'value'   => new sfValidatorPass(array('required' => false)),
      'unit'    => new sfValidatorPass(array('required' => false)),
      'type'    => new sfValidatorPass(array('required' => false)),
      'user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('sfGuardUser'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('criteria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Criteria';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'value'   => 'Text',
      'unit'    => 'Text',
      'type'    => 'Text',
      'user_id' => 'ForeignKey',
    );
  }
}
