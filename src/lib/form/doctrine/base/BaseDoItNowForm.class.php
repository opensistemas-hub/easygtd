<?php

/**
 * DoItNow form base class.
 *
 * @method DoItNow getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseDoItNowForm extends NextActionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('do_it_now[%s]');
  }

  public function getModelName()
  {
    return 'DoItNow';
  }

}
