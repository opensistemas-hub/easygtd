<?php

/**
 * ActualProject form base class.
 *
 * @method ActualProject getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActualProjectForm extends ProjectStateForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('actual_project[%s]');
  }

  public function getModelName()
  {
    return 'ActualProject';
  }

}
