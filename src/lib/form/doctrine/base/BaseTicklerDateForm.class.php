<?php

/**
 * TicklerDate form base class.
 *
 * @method TicklerDate getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTicklerDateForm extends NoActionableItemInfoForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('tickler_date[%s]');
  }

  public function getModelName()
  {
    return 'TicklerDate';
  }

}
