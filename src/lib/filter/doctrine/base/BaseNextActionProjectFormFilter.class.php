<?php

/**
 * NextActionProject filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionProjectFormFilter extends ActionProjectFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['next_action_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NextAction'), 'add_empty' => true));
    $this->validatorSchema['next_action_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NextAction'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('next_action_project_filters[%s]');
  }

  public function getModelName()
  {
    return 'NextActionProject';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'next_action_id' => 'ForeignKey',
    ));
  }
}
