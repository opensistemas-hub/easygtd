<?php


class NextActionAttachmentCustomForm extends BaseForm
{

  private $nextActionAttachmentCollection = array();

  public function getNextActionAttachmentCollection(){
    return $this->nextActionAttachmentCollection;
  }

  public function configure()
  {
    $this->setWidgets(array(
      'file'    => new sfWidgetFormInputFile(),
    ));
    $this->widgetSchema->setNameFormat('attach[%s]');

    $this->setValidators(array(
      'file'    => new sfValidatorFile(),
    ));
  }

  public function bindMultipleFiles($files = array()) {
    foreach($files as $index => $file) {
        //Validate the attachment
        if (strlen($_FILES[$index]['name']['file']) > 0) {
          try {
            //Validate type
            if (!is_integer(array_search($_FILES[$index]['type']['file'], sfConfig::get('app_TYPE_OF_FILES')))) throw new Exception('not_valid_type_in_file_:'.$_FILES[$index]['name']['file'].'.');
            //Validate size
            if ($_FILES[$index]['size']['file'] > sfConfig::get('app_FILE_WEIGHT')) throw new Exception('File '.$_FILES[$index]['name']['file'].'too_big_-_2MB_max');
	    //Move the file
            $path = time().'_'.$_FILES[$index]['name']['file'];
	    if (move_uploaded_file($_FILES[$index]['tmp_name']['file'], sfConfig::get('sf_upload_dir').'/'.$path)) {
               $nextActionAttachment = new NextActionAttachment();
               $nextActionAttachment->setValue($path);
               $this->nextActionAttachmentCollection[] = $nextActionAttachment;
               $nextActionAttachment = null;
	    } else {
	      //Do nothing
	    }
          } catch (Exception $e) {
            Mensajes::getInstance()->agregarError($e->getMessage());
          }
       }
    }
  }


}
