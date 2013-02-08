<?php

/**
 * NextActionIndexSearch form base class.
 *
 * @method NextActionIndexSearch getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNextActionIndexSearchForm extends IndexSearchForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('next_action_index_search[%s]');
  }

  public function getModelName()
  {
    return 'NextActionIndexSearch';
  }

}
