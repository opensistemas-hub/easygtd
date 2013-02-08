<?php

/**
 * Scheduled form base class.
 *
 * @method Scheduled getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseScheduledForm extends NextActionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('scheduled[%s]');
  }

  public function getModelName()
  {
    return 'Scheduled';
  }

}
