<?php

/**
 * DoAsapItemAlertConfiguration form base class.
 *
 * @method DoAsapItemAlertConfiguration getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDoAsapItemAlertConfigurationForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('do_asap_item_alert_configuration[%s]');
  }

  public function getModelName()
  {
    return 'DoAsapItemAlertConfiguration';
  }

}
