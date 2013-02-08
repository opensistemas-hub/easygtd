<?php

/**
 * FutureProject form base class.
 *
 * @method FutureProject getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFutureProjectForm extends ProjectStateForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('future_project[%s]');
  }

  public function getModelName()
  {
    return 'FutureProject';
  }

}
