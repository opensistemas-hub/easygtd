<?php

/**
 * NoActionableItemInfo filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemInfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'no_actionable_item_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => true)),
      'value'                 => new sfWidgetFormFilterInput(),
      'type'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'no_actionable_item_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NoActionableItem'), 'column' => 'id')),
      'value'                 => new sfValidatorPass(array('required' => false)),
      'type'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('no_actionable_item_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NoActionableItemInfo';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'no_actionable_item_id' => 'ForeignKey',
      'value'                 => 'Text',
      'type'                  => 'Text',
    );
  }
}
