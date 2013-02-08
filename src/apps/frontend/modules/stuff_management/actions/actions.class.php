<?php

/**
 * stuff_management actions.
 *
 * @package    EasyGtd
 * @subpackage stuff_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class stuff_managementActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    
    #capturar parametros de discriminacion
    
    $nameParameter = ($request->getParameter('field')== 'NAME')?$request->getParameter('order','DESC'):null;
    $dateParameter = ($request->getParameter('field')== 'DATE')?$request->getParameter('order','DESC'):null;
    $this->string_order = '';
    $this->string_type = '';
    $this->found = null;
    
    //Warning para saber si hay cosa más antiguas que 
    $this->stuffOlder =  false;
    $query = Doctrine_Query::create()->select('COUNT(*) as total')->from('Stuff s')->where('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->addWhere('s.stuff_state_id = ? ','1')->addWhere('DATEDIFF(NOW(), created_at) > ?','7');
        foreach ($query->execute() as $hit){
          if ($hit->getTotal() > 0) $this->stuffOlder = true;
        } 
    
    $this->stuffsPager = new sfDoctrinePager('Stuff',sfConfig::get('app_PAGE_SIZE_INBOX',20)); //The first is the class, the second name is the number of items per page
    
    if(!is_null($nameParameter) || !is_null($dateParameter)){
    
    if(!is_null($nameParameter)) {
      
      $this->string_order = $nameParameter;
      $this->string_type = 'name';
      
    } else {
    
      $this->string_order = $dateParameter;
      $this->string_type = 'created_at';
      
    }

    $this->stuffsPager->setQuery(
                                 Doctrine::getTable('Stuff')
                                 ->createQuery('s')
                                 ->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                 ->addWhere('s.StuffState.id = ?', Doctrine::getTable('StuffState')->find(1)->getId()) //The id 1 SUFF STATE - INBOX
                                 ->addOrderBy('s.'.$this->string_type.' '.$this->string_order)
                                );
    } else {
    
    if ( $request->getParameter('found') ) {
            $this->found = true;
         $this->stuffsPager->setQuery(
                                 Doctrine::getTable('Stuff')
                                 ->createQuery('s')
                                 ->addWhere('s.id=?',$request->getParameter('found'))
                                 ->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                 ->addWhere('s.StuffState.id = ?', Doctrine::getTable('StuffState')->find(1)->getId()) //The id 1
                                 );
        
    } else {
    
     $this->stuffsPager->setQuery(
                                 Doctrine::getTable('Stuff')
                                 ->createQuery('s')
                                 ->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                 ->addWhere('s.StuffState.id = ?', Doctrine::getTable('StuffState')->find(1)->getId()) //The id 1 SUFF STATE - INBOX
                             
                                );
     }                           
    
    }       
    
                                
    $this->stuffsPager->setPage($this->getRequestParameter('page',1));
    $this->stuffsPager->init();

    $this->emailToInbox = Doctrine_Query::create()->from('EmailToInbox e')->where('e.user_id = ?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();   
    
          
  }

  public function executeIndex_ajax(sfWebRequest $request)
  {
    $this->executeIndex($request);  
  }
  
  
  public function executeInbox(sfWebRequest $request) {
     #capturar parametros de discriminacion
    
    $nameParameter = ($request->getParameter('field')== 'NAME')?$request->getParameter('order','DESC'):null;
    $dateParameter = ($request->getParameter('field')== 'DATE')?$request->getParameter('order','DESC'):null;
    $this->string_order = '';
    $this->string_type = '';
    $this->found = null;
    
    
    $this->stuffsPager = new sfDoctrinePager('Stuff', sfConfig::get('app_PAGE_SIZE_INBOX',20));  //The second name is the number of items per page
    
    if(!is_null($nameParameter) || !is_null($dateParameter)){
    
    if(!is_null($nameParameter)) {
      
      $this->string_order = $nameParameter;
      $this->string_type = 'name';
      
    } else {
    
      $this->string_order = $dateParameter;
      $this->string_type = 'created_at';
      
    }
    
    $this->stuffsPager->setQuery(
                                 Doctrine::getTable('Stuff')
                                 ->createQuery('s')
                                 ->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                 ->addWhere('s.StuffState.id = ?', Doctrine::getTable('StuffState')->find(1)->getId()) //The id 1 SUFF STATE - INBOX
                                 ->addOrderBy('s.'.$this->string_type.' '.$this->string_order)
                                );
    } else {
    
     $this->stuffsPager->setQuery(
                                 Doctrine::getTable('Stuff')
                                 ->createQuery('s')
                                 ->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId() )
                                 ->addWhere('s.StuffState.id = ?', Doctrine::getTable('StuffState')->find(1)->getId()) //The id 1 SUFF STATE - INBOX
                             
                                );
    
    }       
                                
    $this->stuffsPager->setPage($this->getRequestParameter('page',1));
    $this->stuffsPager->init();
    
  }
  
  public function executeDownload_attachment(sfWebRequest $request)
  {
     $this->stuffAttachments = Doctrine::getTable('StuffAttachment')
      ->createQuery('s')
      ->addWhere('s.Stuff.user_id = ?', $this->getUser()->getGuardUser()->getId() )
      ->addWhere('s.id = ?', $request->getParameter('id',-1))
      ->limit(1)
      ->execute();

     if ($this->stuffAttachments->count() <> 1) {
         return sfView::ERROR;  
     }

     $file = sfConfig::get('sf_upload_dir').'/'.$this->stuffAttachments->getFirst()->getValue();
     $this->forward404Unless(file_exists($file));

     // Adding the file to the Response object
     $this->getResponse()->clearHttpHeaders();
     $this->getResponse()->setHttpHeader('Pragma: public', true);
     $this->getResponse()->setContentType(MimeContent::mime_content_type($file));
     $this->getResponse()->sendHttpHeaders();
     $this->getResponse()->setContent(readfile($file));

     return sfView::NONE;
  }

  public function executeDelete_attachment(sfWebRequest $request)
  {
     $this->stuffAttachments = Doctrine::getTable('StuffAttachment')
      ->createQuery('s')
      ->addWhere('s.Stuff.user_id = ?', $this->getUser()->getGuardUser()->getId() )
      ->addWhere('s.id = ?', $request->getParameter('id',-1))
      ->limit(1)
      ->execute();

     if ($this->stuffAttachments->count() <> 1) {
         return sfView::ERROR;  
     }

     $this->stuffAttachments->getFirst()->delete();
     return sfView::NONE;

  }

  public function executeNew(sfWebRequest $request)
  {
    $stuff = new Stuff();
    $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
    $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1)); //The id 1 SUFF STATE - INBOX

    $this->form = new StuffForm($stuff);
    $this->archivo = new StuffAttachmentCustomForm();
    
    $this->setLayout(false); //La vista es Ajax
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  

    $stuff = new Stuff();

    $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
    $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1)); //The id 1 SUFF STATE - INBOX

    $this->form = new StuffForm($stuff);

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }
  
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($stuff = Doctrine::getTable('Stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
   
    $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
    $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1)); //The id 1 SUFF STATE - INBOX

    $this->form = new StuffForm($stuff);
    $this->archivo = new StuffAttachmentCustomForm();

    $this->setLayout(false); //La vista es Ajax
    
  }

  public function executeUpdate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  
    $this->setTemplate('create');
   
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($stuff = Doctrine::getTable('Stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
    $this->user = Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() );

    $this->form = new StuffForm($stuff);
   
    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    //Delete only if is the stuff of the user
    $this->forward404Unless($stuff = Doctrine::getTable('Stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
    
    try {
      if ($stuff->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('this_stuff_is_not_yours_!');
      $stuff->delete();
    } catch (Exception $e) {
      Mensajes::getInstance()->agregarError($e->getMessage());
    }
    Mensajes::getInstance()->agregarExito('the_stuff_was_removed_successfully');
    $this->loadMessages();
    $this->redirect('stuff_management/index');
  }

  public function executeShow_url(sfWebRequest $request){

    $this->stuff = Doctrine::getTable('Stuff')
                      ->createQuery('s')
                      ->addWhere('s.user_id = ?', $this->getUser()->getGuardUser()->getId() )
                      ->addWhere('s.normalized_name = ?', $request->getParameter('stuff_normalized_name'))
                      ->limit(1)
                      ->execute()->getFirst();
     
    $this->setTemplate('show_url');
    $this->setLayout(false); //Nunca usa layout esta vista.

    if (!($this->stuff instanceof Stuff)) return sfView::ERROR;

  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));    

    if ($form->isValid() ) //Sólo me importa que el stuff sea válido los adjuntos se avisan.
    {
                  
        //Ahora meto los adjuntos, que si no es válido el formulario no vale la pena subir los archivos.
        //Ahora manejo los adjuntos; que pueden ser más de uno; para ello sobreescribo el método bind y save del StufAttachmentCustomForm
        $fileHandlerForm = new StuffAttachmentCustomForm(); //Utilidad para el binding de los adjuntos.
        //fileHandlerForm es el objeto Form que sirve para subir un adjunto.
        $fileHandlerForm->bindMultipleFiles($_FILES); //Le paso el adjunto de archivos de tipo FILE para que los suba y me dé los avisos.
        foreach($fileHandlerForm->getStuffAttachmentCollection() as $index => $stuffAttachment){
          $form->getObject()->getStuffAttachments()->add($stuffAttachment);
        }
    
        $stuff = $form->save(); //Save              
            
    } else {

        throw new Exception('process_form_not_valid');
    }

  }
  
  public function executeQuick(sfWebRequest $request) {
    
    try {

      if ($request->getParameter('name') == "" || strlen($request->getParameter('name')) == 0) throw new Exception('');
      $StuffObj = new Stuff();
      $StuffObj->setName($request->getParameter('name'));
      $StuffObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
      $StuffObj->setStuffState(Doctrine::getTable('StuffState')->find(1));
      $StuffObj->save();
      Mensajes::getInstance()->agregarExito($request->getParameter('name').'added');
     } catch (Exception $e) {
      //DO NOTHING
     } 
    
  }

  public function executeImport(sfWebRequest $request){

  }

  public function executeProcess_import(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml'); 
 
    try {  
      //First - validate the file.
      foreach($_FILES as $index => $file) {          
        //Validate the attachment 
        if (strlen($_FILES[$index]['name']) > 0) {
            //Validate type  
            if (!is_integer(array_search($_FILES[$index]['type'], array('text/plain','text/csv')))) throw new Exception('not_valid_type_in_file'); 
            //Validate size
            if ($_FILES[$index]['size'] > 2000000) throw new Exception('file_too_big_-_2MB_max'); 
	    //Move the file
            $path = time().'_'.$_FILES[$index]['name'];
	    if (move_uploaded_file($_FILES[$index]['tmp_name'], sfConfig::get('sf_upload_dir').'/'.$path)) {
	      //All Ok.
              $this->importFile(sfConfig::get('sf_upload_dir').'/'.$path);
              //Delete the file.
              unlink(sfConfig::get('sf_upload_dir').'/'.$path);
	    } else {
	      //Do nothing
	    }          
        }
      }
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  private function importFile($filePath = '') {
    $count = 0;
    $fd = fopen($filePath, 'r');
    // initialize a loop to go through each line of the file
    while (!feof ($fd)) {
      $buffer = fgetcsv($fd, 4096); // declare an array to hold all of the contents of each
      //row, indexed
      //0 => title , 1 => Description.
      $stuff = new Stuff();
      $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
      $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1)); //The id 1 SUFF STATE
        try {
          if (!isset($buffer[0])) throw new Exception();
          if (strlen($buffer[0]) < 1) throw new Exception();
          //Ok, we charge the title on the object.
          $stuff->setName($buffer[0]);
          //Let's see the description.
          if (isset($buffer[1])) $stuff->setDescription($buffer[1]);
          $stuff->save(); 
          $count++;
        } catch (Exception $e) {
          
        }        
      }
    fclose($fd);

    //Message
    Mensajes::getInstance()->agregarExito($count);
    Mensajes::getInstance()->agregarExito('stuff_imported');
  }
  
  public function executeSave_some_day_from_project(sfWebRequest $request){
 
    $ticklerDate = new TicklerDate();
    $actions = Doctrine_Query::create()->from('NoActionableItemProject n')->where('n.Project.id=?',$request->getParameter('project_id'))->execute();
   
    foreach ($actions as $key => $row)
    {

      ##salvo los attachments de no actionable items
      $stuffAttachements = array();
      $stuffAtt = Doctrine_Query::create()->from('NoActionableItemAttachment n')->where('n.no_actionable_item_id = ?',$row->getNoActionableItem()->getId())->execute();
      
      //get all stuff attachment for newaction attachment
      foreach($stuffAtt as $stuff){
          $nextStuffAttachmentsObject = new StuffAttachment();
          $nextStuffAttachmentsObject->setValue($stuff->getValue());
          $stuffAttachements[] = $nextStuffAttachmentsObject;

        }
      #grabo los no_actionable_items de tipo someday que su fecha sea anterior a la actual
      $stuff = new Stuff();
      $stuff->setName('Someday: '.$row->getNoActionableItem()->getName());
      $stuff->setDescription($row->getNoActionableItem()->getDescription());
      $Stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() ));
      $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1));//inbox state
      
      foreach($stuffAttachements as $stuffAtt){
        
        $stuff->getStuffAttachments()->add($stuffAtt);
      
      }
      
      $stuff->save();
      $stuff = null;
      
      
      //elimina todos los no actionable que tenga la fecha anterior a la actual
      
       //elimina todos los no actionable attachment que tenga projecto anterior
       
      $q = Doctrine_Query::create()
           ->delete('NoActionableItemProject n')
           ->where('n.project_id = ?',$request->getParameter('project_id'))
           ->execute();
      $q = null; 
       
      $q = Doctrine_Query::create()
           ->delete('NoActionableItemAttachment n')
           ->where('n.no_actionable_item_id = ?',$row->getNoActionableItem()->getId())
           ->execute();
      $q = null; 
      
       
      
      // elimina todos los no actionable info que tenga la fecha anterior a la actual
      $q = Doctrine_Query::create()
           ->delete('NoActionableItemInfo n')
           ->where('n.id = ?',$row->getId())
           ->execute();
      $q = null;
       
      $q = Doctrine_Query::create()
           ->delete('NoActionableItem n')
           ->where('n.id = ?',$row->getNoActionableItem()->getId())
           ->execute();
      $q = null;
           
    }
  $this->redirect('doing_work/index');
     //return sfView::NONE;    
  }
  
  public function executeMessage(sfWebRequest $request) {
    //DO NOTHING
    //PRINT MESSAGE
  }
  

  private function loadMessages(){
    //Load the meesages singleton into flash
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }

}
