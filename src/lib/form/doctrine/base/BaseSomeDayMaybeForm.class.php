<?php

/**
 * SomeDayMaybe form base class.
 *
 * @method SomeDayMaybe getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSomeDayMaybeForm extends NoActionableItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('some_day_maybe[%s]');
  }

  public function getModelName()
  {
    return 'SomeDayMaybe';
  }

}
