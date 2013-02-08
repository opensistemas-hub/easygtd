<?php

/**
 * SavedSearchInfo form base class.
 *
 * @method SavedSearchInfo getObject() Returns the current form's model object
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     leobarrientosc
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSavedSearchInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'saved_search_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SavedSearch'), 'add_empty' => false)),
      'value'           => new sfWidgetFormInputText(),
      'type'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'saved_search_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SavedSearch'))),
      'value'           => new sfValidatorString(array('max_length' => 120, 'required' => false)),
      'type'            => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('saved_search_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SavedSearchInfo';
  }

}
