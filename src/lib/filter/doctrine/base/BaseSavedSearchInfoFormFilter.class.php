<?php

/**
 * SavedSearchInfo filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSavedSearchInfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'saved_search_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SavedSearch'), 'add_empty' => true)),
      'value'           => new sfWidgetFormFilterInput(),
      'type'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'saved_search_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SavedSearch'), 'column' => 'id')),
      'value'           => new sfValidatorPass(array('required' => false)),
      'type'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saved_search_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SavedSearchInfo';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'saved_search_id' => 'ForeignKey',
      'value'           => 'Text',
      'type'            => 'Text',
    );
  }
}
