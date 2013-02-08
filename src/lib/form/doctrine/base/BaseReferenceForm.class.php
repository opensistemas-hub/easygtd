<?php

/**
 * Reference form base class.
 *
 * @method Reference getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReferenceForm extends NoActionableItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('reference[%s]');
  }

  public function getModelName()
  {
    return 'Reference';
  }

}
