<?php

/**
 * TimeAvailable form base class.
 *
 * @method TimeAvailable getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTimeAvailableForm extends CriteriaForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('time_available[%s]');
  }

  public function getModelName()
  {
    return 'TimeAvailable';
  }

}
