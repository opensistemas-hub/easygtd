<?php

/**
 * DayScheludedItemAlertConfiguration filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDayScheludedItemAlertConfigurationFormFilter extends AlertConfigurationFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('day_scheluded_item_alert_configuration_filters[%s]');
  }

  public function getModelName()
  {
    return 'DayScheludedItemAlertConfiguration';
  }
}
