<?php

/**
 * Folder form.
 *
 * @package    EasyGtd
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FolderForm extends BaseFolderForm
{
  /**
   * @see NoActionableItemInfoForm
   */
  public function configure()
  {   
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'user_id'         => new sfWidgetFormInputHidden(),
      'created_at'      => new sfWidgetFormInputHidden(),
      'updated_at'      => new sfWidgetFormInputHidden(),
      'normalized_name' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'user_id'         => new sfValidatorPass(),
      'created_at'      => new sfValidatorPass(),
      'updated_at'      => new sfValidatorPass(),
      'normalized_name' => new sfValidatorPass(),
    ));
    $this->widgetSchema->setNameFormat('folder[%s]');
  }
}
