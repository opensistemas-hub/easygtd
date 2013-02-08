<?php

/**
 * NoActionableItemProject form base class.
 *
 * @method NoActionableItemProject getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemProjectForm extends ActionProjectForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['no_actionable_item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => true));
    $this->validatorSchema['no_actionable_item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'required' => false));

    $this->widgetSchema->setNameFormat('no_actionable_item_project[%s]');
  }

  public function getModelName()
  {
    return 'NoActionableItemProject';
  }

}
