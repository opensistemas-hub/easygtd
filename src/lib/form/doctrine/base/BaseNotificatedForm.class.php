<?php

/**
 * Notificated form base class.
 *
 * @method Notificated getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNotificatedForm extends NextActionStateForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('notificated[%s]');
  }

  public function getModelName()
  {
    return 'Notificated';
  }

}
