<?php

/**
 * ReferencesMark form base class.
 *
 * @method ReferencesMark getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReferencesMarkForm extends BookmarkForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('references_mark[%s]');
  }

  public function getModelName()
  {
    return 'ReferencesMark';
  }

}
