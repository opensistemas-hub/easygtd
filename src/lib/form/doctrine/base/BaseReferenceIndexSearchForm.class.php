<?php

/**
 * ReferenceIndexSearch form base class.
 *
 * @method ReferenceIndexSearch getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReferenceIndexSearchForm extends IndexSearchForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('reference_index_search[%s]');
  }

  public function getModelName()
  {
    return 'ReferenceIndexSearch';
  }

}
