<?php

/**
 * DoAsapItem form base class.
 *
 * @method DoAsapItem getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDoAsapItemForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('do_asap_item[%s]');
  }

  public function getModelName()
  {
    return 'DoAsapItem';
  }

}
