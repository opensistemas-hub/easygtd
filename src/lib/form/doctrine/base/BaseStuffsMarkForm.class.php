<?php

/**
 * StuffsMark form base class.
 *
 * @method StuffsMark getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStuffsMarkForm extends BookmarkForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('stuffs_mark[%s]');
  }

  public function getModelName()
  {
    return 'StuffsMark';
  }

}
