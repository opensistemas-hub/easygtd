<?php

/**
 * DelegateItemAlertConfiguration form base class.
 *
 * @method DelegateItemAlertConfiguration getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDelegateItemAlertConfigurationForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('delegate_item_alert_configuration[%s]');
  }

  public function getModelName()
  {
    return 'DelegateItemAlertConfiguration';
  }

}
