<?php

/**
 * ScheludedItem form base class.
 *
 * @method ScheludedItem getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseScheludedItemForm extends AlertConfigurationForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('scheluded_item[%s]');
  }

  public function getModelName()
  {
    return 'ScheludedItem';
  }

}
