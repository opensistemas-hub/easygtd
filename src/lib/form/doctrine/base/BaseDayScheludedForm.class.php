<?php

/**
 * DayScheluded form base class.
 *
 * @method DayScheluded getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDayScheludedForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('day_scheluded[%s]');
  }

  public function getModelName()
  {
    return 'DayScheluded';
  }

}
