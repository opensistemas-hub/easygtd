<?php

/**
 * NoActionableItemFolder filter form base class.
 *
 * @package    EasyGtd
 * @subpackage filter
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNoActionableItemFolderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'no_actionable_item_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NoActionableItem'), 'add_empty' => true)),
      'folder_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Folder'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'no_actionable_item_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NoActionableItem'), 'column' => 'id')),
      'folder_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Folder'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('no_actionable_item_folder_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NoActionableItemFolder';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'no_actionable_item_id' => 'ForeignKey',
      'folder_id'             => 'ForeignKey',
    );
  }
}
