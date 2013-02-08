<?php

/**
 * NoActionableItemProject filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemProjectFormFilter extends ActionProjectFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['no_actionable_item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => true));
    $this->validatorSchema['no_actionable_item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NoActionableItem'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('no_actionable_item_project_filters[%s]');
  }

  public function getModelName()
  {
    return 'NoActionableItemProject';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'no_actionable_item_id' => 'ForeignKey',
    ));
  }
}
