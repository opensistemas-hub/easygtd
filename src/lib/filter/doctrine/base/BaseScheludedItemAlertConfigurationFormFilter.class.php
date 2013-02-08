<?php

/**
 * ScheludedItemAlertConfiguration filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseScheludedItemAlertConfigurationFormFilter extends AlertConfigurationFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('scheluded_item_alert_configuration_filters[%s]');
  }

  public function getModelName()
  {
    return 'ScheludedItemAlertConfiguration';
  }
}
