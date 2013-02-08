<?php

/**
 * SomeDayMaybeItemAlertConfiguration form base class.
 *
 * @method SomeDayMaybeItemAlertConfiguration getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSomeDayMaybeItemAlertConfigurationForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('some_day_maybe_item_alert_configuration[%s]');
  }

  public function getModelName()
  {
    return 'SomeDayMaybeItemAlertConfiguration';
  }

}
