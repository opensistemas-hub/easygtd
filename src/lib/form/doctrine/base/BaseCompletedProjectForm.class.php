<?php

/**
 * CompletedProject form base class.
 *
 * @method CompletedProject getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCompletedProjectForm extends ProjectStateForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('completed_project[%s]');
  }

  public function getModelName()
  {
    return 'CompletedProject';
  }

}
