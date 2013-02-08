<?php

/**
 * DoASAP form base class.
 *
 * @method DoASAP getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDoASAPForm extends NextActionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('do_asap[%s]');
  }

  public function getModelName()
  {
    return 'DoASAP';
  }

}
