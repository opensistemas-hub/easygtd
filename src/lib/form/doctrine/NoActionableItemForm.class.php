<?php

/**
 * NoActionableItem form.
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NoActionableItemForm extends BaseNoActionableItemForm
{
  public function configure()
  {
     $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextArea(),
      'type'            => new sfWidgetFormInputText(),
      'date'            => new sfWidgetFormInputHidden(),
      'user_id'         => new sfWidgetFormInputHidden(),
      'created_at'      => new sfWidgetFormInputHidden(),
      'updated_at'      => new sfWidgetFormInputHidden(),
      'normalized_name' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorPass(),
      'description'     => new sfValidatorPass(),
      'date'            => new sfValidatorPass(),
      'type'            => new sfValidatorPass(),
      'user_id'         => new sfValidatorPass(),
      'created_at'      => new sfValidatorPass(),
      'updated_at'      => new sfValidatorPass(),
      'normalized_name' => new sfValidatorPass(),
    ));
  
    $this->widgetSchema->setNameFormat('no_actionable_item[%s]');

  }
}
