<?php
/**
 * no_actionable_item_management actions.
 *
 * @package    EasyGtd
 * @subpackage no_actionable_item_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class no_actionable_item_managementActions extends sfActions
{
  
  public function executeReference(sfWebRequest $request){
  
    $this->referencePager = new sfDoctrinePager('Reference',sfConfig::get('app_PAGE_SIZE_NOACTIONABLE_ITEM',2));
    
    if($request->getParameter('field')=='DATE'){
    
    $this->referencePager->setQuery(
                                  Doctrine::getTable('Reference')
                                    ->createQuery('r')
                                    ->where('r.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId()) 
                                    ->orderBy('r.created_at '.$request->getParameter('order'))
                                   
                                   );
                                   
                                   
    } else {
          $this->referencePager->setQuery(
                                  Doctrine::getTable('Reference')
                                    ->createQuery('r')
                                    ->where('r.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId()) 

                                   
                                   );
        
    }
    
    if($request->getParameter('field')=='NAME'){
    
    $this->referencePager->setQuery(
                                  Doctrine::getTable('Reference')
                                    ->createQuery('r')
                                    ->where('r.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId()) 
                                    ->orderBy('r.name '.$request->getParameter('order'))
                                   
                                   );
                                   
                                   
    } else {
          $this->referencePager->setQuery(
                                  Doctrine::getTable('Reference')
                                    ->createQuery('r')
                                    ->where('r.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId()) 

                                   
                                   );
        
    }
   
    $this->referencePager->setPage($this->getRequestParameter('page',1));
    $this->referencePager->init();
  
  }
  
  public function executeShow(sfWebRequest $request){
    $this->type=null;
    $this->action = Doctrine::getTable('NoActionableItem')->find($request->getParameter('action_id'));
    
      switch ($request->getParameter('ref')){
        case 'REFERENCE':
              $this->type='Folder';
              break;
        case 'SOMEDAYMAYBE':
              $this->type='Ticker Date';
              break;
        default:
              $this->type=null;            
      
      }
    
  }
  
  public function executeSome_day_maybe(sfWebRequest $request) {
    $this->somedayPager = new sfDoctrinePager('SomeDayMaybe',sfConfig::get('app_PAGE_SIZE_NOACTIONABLE_ITEM',2));
    $this->somedayPager->setQuery(
                                  Doctrine::getTable('SomeDayMaybe')
                                    ->createQuery('r')
                                    ->where('r.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())                          
                                    ->orderBy('DATE_FORMAT(r.Informations.value,"%Y-%m-%d") DESC')
                                   );   
    $this->somedayPager->setPage($this->getRequestParameter('page',1));
    $this->somedayPager->init();  
  }
  
  public function executeSomeday_maybe_ajax(sfWebRequest $request) {  
    $this->executeSome_day_maybe($request);
  }

  public function executeNew(sfWebRequest $request) {
    $this->form = new NoActionableItemForm();
    $this->archivo = new NoActionableItemAttachmentCustomForm();
  }

  public function executeCreate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->archivo = new NoActionableItemAttachmentCustomForm();    
    $this->form = new NoActionableItemForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
  
    $this->forward404Unless($no_actionable_item = Doctrine::getTable('NoActionableItem')->find(array($request->getParameter('id'))), sprintf('Object no_actionable_item does not exist (%s).', $request->getParameter('id')));

    $this->archivo = new NoActionableItemAttachmentCustomForm();
    
    $this->form = new NoActionableItemForm($no_actionable_item);

    
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($no_actionable_item = Doctrine::getTable('NoActionableItem')->find(array($request->getParameter('id'))), sprintf('Object no_actionable_item does not exist (%s).', $request->getParameter('id')));
    $this->form = new NoActionableItemForm($no_actionable_item);

    $this->archivo = new NoActionableItemAttachmentCustomForm();

    $this->processForm($request, $this->form);
    
    // Muestra arbol proyectos
    $this->projects = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
          
    $q = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id = ?',$this->getUser()->getGuardUser()->getId());
    
    $this->treeObject = Doctrine::getTable('Project')->getTree();
//    //insert the custom query on the tree object
//    $this->treeObject->setBaseQuery($q);
//
//    $this->rootColumnName = $this->treeObject->getAttribute('rootColumnName');
    // Fin

    $this->redirect('folder_management/index');
  }

  public function executeDelete(sfWebRequest $request)
  {
       
    $this->forward404Unless($noActionableItem = Doctrine::getTable('NoActionableItem')->find(array($request->getParameter('id'))), sprintf('Object no_actionable_item does not exist (%s).', $request->getParameter('id')));
    if ($noActionableItem->getSfGuardUser()->getId() == $this->getUser()->getGuardUser()->getId()) $noActionableItem->delete();
    return sfView::NONE;    
    
  }


  public function executeNew_someday_maybe(sfWebRequest $request)
  {
    $someDayMaybe = new SomeDayMaybe();
    $someDayMaybe->setSfGuardUser($this->getUser()->getGuardUser());
    $this->form = new NoActionableItemForm($someDayMaybe);
    $this->archivo = new NoActionableItemAttachmentCustomForm();
  }



  public function executeCreate_someday_maybe(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->archivo = new NoActionableItemAttachmentCustomForm();

    $this->form = new NoActionableItemForm();
    
    try {
      $this->processFormSomeDay($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  

   public function executeDelete_someday_maybe(sfWebRequest $request)
  {

    $this->forward404Unless($noActionableItem = Doctrine::getTable('NoActionableItem')->find(array($request->getParameter('id'))), sprintf('Object no_actionable_item does not exist (%s).', $request->getParameter('id')));
    if ($noActionableItem->getSfGuardUser()->getId() == $this->getUser()->getGuardUser()->getId()) $noActionableItem->delete();
    return sfView::NONE;

  }


  protected function processFormSomeDay(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

      if ($form->isValid()){

      $somedayMaybeObj = new SomeDayMaybe();
      $somedayMaybeObj->setName($form->getValue('name'));
      $somedayMaybeObj->setDescription($form->getValue('description'));
      $somedayMaybeObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));

      //fecha
      $ticklerDate = new TicklerDate();    
      $ticklerDate->setValue($form->getValue('date'));
      $somedayMaybeObj->getInformations()->add($ticklerDate);
      

      //adjuntos
      $fileHandlerForm = new NoActionableItemAttachmentCustomForm(); //Utilidad para el binding de los adjuntos.
      //fileHandlerForm es el objeto Form que sirve para subir un adjunto.
      $fileHandlerForm->bindMultipleFiles($_FILES); //Le paso el adjunto de archivos de tipo FILE para que los suba y me dé los avisos.
      foreach($fileHandlerForm->getNoActionableItemAttachmentCollection() as $index => $noActionableItemAttachment){
        $somedayMaybeObj->getNoActionableItemAttachments()->add($noActionableItemAttachment);
      }

      $someday =  $somedayMaybeObj->save();
  
    }

  }



  public function executeDelete_attachment(sfWebRequest $request)
  {

    echo('delete_attachment'); die('x');
     $this->noActionableItemAttachment = Doctrine::getTable('NoActionableItemAttachment')
      ->createQuery('s')
      ->addWhere('s.NoActionableItem.user_id = ?', $this->getUser()->getGuardUser()->getId() )
      ->addWhere('s.id = ?', $request->getParameter('id',-1))
      ->limit(1)
      ->execute();

     if ($this->noActionableItemAttachment->count() <> 1) {
         return sfView::ERROR;
     }

     $this->noActionableItemAttachment->getFirst()->delete();
     return sfView::NONE;

  }



  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

   // echo ($form); die();

    if ($form->isValid())
    {
      $fileHandlerForm = new NoActionableItemAttachmentCustomForm(); //Utilidad para el binding de los adjuntos.
      //fileHandlerForm es el objeto Form que sirve para subir un adjunto.
      $fileHandlerForm->bindMultipleFiles($_FILES); //Le paso el adjunto de archivos de tipo FILE para que los suba y me dé los avisos.
      foreach($fileHandlerForm->getNoActionableItemAttachmentCollection() as $index => $noActionableItemAttachment){
        $form->getObject()->getNoActionableItemAttachments()->add($noActionableItemAttachment);
      }

      $no_actionable_item = $form->save();
    }


  }
  
 
  public function executeAdd_new_reference(sfWebRequest $request){
  
    $this->form = new AddNewReferenceForm();
    $this->folders= Doctrine_Query::create()->from('Folder f')->where('f.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
    
    try{
    
      if (count($this->folders) == 0) throw new Exception('you_dont_have_any_folder_in_this_moment');
    
    
    } catch (Exception $e){
      $this->error=$e->getMessage();
      return sfView::ERROR;
    }

  }
  
  public function executeSave_new_reference(sfWebRequest $request){
  
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $this->folders= Doctrine_Query::create()->from('Folder f')->where('f.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
    
    $this->form = new AddNewReferenceForm();

    $this->processAddNewReferenceForm($request, $this->form);

    $this->setTemplate('add_new_reference');
    
  }
  
  protected function processAddNewReferenceForm(sfWebRequest $request, sfForm $form){
    
    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    $noActionableAttachments=array();
    try{
      
      if($request->getParameter('folder_id') == "-1") throw new Exception('choose_some_folder');

    } catch(Exception $e){
        $error = new sfValidatorError(new sfValidatorPass(), $e->getMessage());
        $errorSchema = new sfValidatorErrorSchema(new sfValidatorPass(), array('name' => $error));
        $form->getErrorSchema()->addError($errorSchema);
    }
    
    

    foreach($_FILES as $index => $file) {          
        //Validate the attachment 
        if (strlen($_FILES[$index]['name']) > 0) {
          try {  
          
         
            //Validate type        
           
            if (!is_integer(array_search($_FILES[$index]['type'], sfConfig::get('app_TYPE_OF_FILES')))) throw new Exception('Not valid type in file : '.$_FILES[$index]['name'].'.'); 
            //Validate size
            if ($_FILES[$index]['size'] > 2000000) throw new Exception('File '.$_FILES[$index]['name'].'too_big_-_2MB_max'); 
	    //Move the file
            $path = time().'_'.$_FILES[$index]['name'];
	    if (move_uploaded_file($_FILES[$index]['tmp_name'], sfConfig::get('sf_upload_dir').'/'.$path)) {
                
	      $noActionableAttachment = new NoActionableItemAttachment();
        $noActionableAttachment->setValue($path);
        $noActionableAttachments[] = $noActionableAttachment;
        $noActionableAttachment = null;
        
	    } else {
	      //Do nothing
	    }
	    
         if($request->getParameter('folder_id') == "-1") throw new Exception('choose_some_folder');
         
         
          } catch (Exception $e) {
            $error = new sfValidatorError(new sfValidatorPass(), $e->getMessage());
            $errorSchema = new sfValidatorErrorSchema(new sfValidatorPass(), array('attachment_'.$index => $error));
            $form->getErrorSchema()->addError($errorSchema);
          }
       }
    }
    
 
    
    if ($form->isValid()){
      try{
      $noAction = new NoActionableItem();
      $type = new Reference();
      
      //save no_action
      $noAction->setName($this->form->getValue('name'));
      $noAction->setDescription($this->form->getValue('description'));
      $noAction->setType($type->getDiscriminator());
      $noAction->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      
      //save attachments
  
        foreach($noActionableAttachments as $noActionableAttachmentItem) {
           $noAction->getNoActionableItemAttachments()->add($noActionableAttachmentItem);
        }
      
      $noAction->save();
      
      //save no_action to folder
      $noActionFolder = new NoActionableItemFolder();
      $noActionFolder->setNoActionableItem($noAction);
      $noActionFolder->setFolder(Doctrine::getTable('Folder')->find($request->getParameter('folder_id')));
      $noActionFolder->save();
      $type=null;      
      //save the info
      
      $q = Doctrine::getTable('Folder')->find($request->getParameter('folder_id'));
      $type = new Folder();
      $noActionInfo = new NoActionableItemInfo();
      $noActionInfo->setType($type->getDiscriminator());
      $noActionInfo->setValue($q->getName());
      $noActionInfo->setNoActionableItem($noAction);
      $noActionInfo->save();
      
      
      Mensajes::getInstance()->agregarExito('the_reference_was_added_successfully');
      $this->loadMessages();
      $this->redirect('folder_management/index');
      } catch(Exception $e) {
        //some kind of error but I do not know???
      }
      
      
      
    }
  
  
  }
  
  public function executeEdit_someday(sfWebRequest $request) {
  
    $id = $request->getParameter('id');
        
    $noActionObj = Doctrine::getTable('NoActionableItem')->find($id);
    $noActionInfo = Doctrine_Query::create()->from('NoActionableItemInfo n')->Where('n.NoActionableItem.id=?',$id)->execute()->getFirst();
    
    $this->projectSelected = Doctrine_Query::create()->from('NoActionableItemProject np')->where('np.NoActionableItem.id=?',$id)->execute()->getFirst();
    
    $this->projectSelected = ($this->projectSelected instanceof NoActionableItemProject)?$this->projectSelected->getProject()->getId():null;
    
    
   // Muestra arbol proyectos
    $this->projects = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
          
    $q = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id = ?',$this->getUser()->getGuardUser()->getId());
    
    $this->treeObject = Doctrine::getTable('Project')->getTree();
    //insert the custom query on the tree object
    $this->treeObject->setBaseQuery($q);
     
    $this->rootColumnName = $this->treeObject->getAttribute('rootColumnName');
    // Fin 
    
   
    $this->noActionItem = $noActionObj;
    
    if ( $request->getMethod() == sfRequest::POST ) {
    
    //save action
       if ( $noActionObj instanceof NoActionableItem ) {
          
          $noActionObj->setName($request->getParameter('name'));
          $noActionObj->setDescription($request->getParameter('description'));
          $noActionObj->save();
          
          $noActionInfo = ($noActionInfo instanceof NoActionableItemInfo)?$noActionInfo:new NoActionableItemInfo();
          $noActionInfo->setNoActionableItem($noActionObj);       
          $noActionInfo->setValue($request->getParameter('date'));
          $noActionInfo->save();
          
          // if exist some project, them update 
          
          if ( $request->getParameter('project_list') != '-1' ) {
            
            $noActionProj = Doctrine_Query::create()->from('NoActionableItemProject np')->Where('np.NoActionableItem.id=?',$noActionObj->getId())->execute()->getFirst();
            
            $noActionProj = ($noActionProj instanceof NoActionableItemProject) ? $noActionProj : new NoActionableItemProject();
            
            $noActionProj->setNoActionableItem($noActionObj);
            
            $noActionProj->setProject(Doctrine::getTable('Project')->find($request->getParameter('project_list')));
            $noActionProj->save();
          
          }
          
          }
        
    } else {
      //DO NOTHING
    }
   
  }
  
  public function executeReturn_inbox(sfWebRequest $request){
    //catch a action for parameter action id
    $action = Doctrine::getTable('NoActionableItem')->find($request->getParameter('action_id'));
    
    $stuffAttachments = array();
    
    //catch all attachment from the last action 
    foreach($action->getNoActionableItemAttachments() as $row){
      //insert into a new object all attachment
      $stuffAttachment = new StuffAttachment();
      $stuffAttachment->setValue($row->getValue());
      $stuffAttachments[] = $stuffAttachment;
      $stuffAttachment = null;
      
    }
    //add a new stuff object
    $stuff = new Stuff();
    $stuff->setName($action->getName());
    $stuff->setDescription($action->getDescription());
    $stuff->setStuffState(Doctrine::getTable('StuffState')->find(1));
    $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));  
          
     //save all attachment     
     foreach($stuffAttachments as $stuffAttachment){
      $stuff->getStuffAttachments()->add($stuffAttachment);
     }    
     $stuff->save();
     
     //delete the no actionable item on Cascade 
     $q = Doctrine_Query::create();
     $q->delete('NoActionableItem na');
     $q->where('na.id = ?',$request->getParameter('action_id'));
     $q->execute();
     
    $this->redirect('no_actionable_item_management/some_day_maybe');
  }
  
  public function executeCopy_ajax_reference(sfWebRequest $request) {
    
    $noActionable = $request->getParameter('no_actionable_id');
    $folder = $request->getParameter('folder_id');

    
    $noaction = Doctrine::getTable('NoActionableItem')->find($noActionable);
    $folderObj = Doctrine::getTable('Folder')->find($folder);
    
   
    
      $noAction = new NoActionableItem();
      $noAction->setName($noaction->getName());
      $noAction->setDescription($noaction->getDescription());
      $noAction->setType($noaction->getType());
      $noAction->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $noAction->save();
      
      foreach ($noaction->getNoActionableItemAttachments() as $att) {
      
        $atta = new NoActionableItemAttachment();
        $atta->setValue($att->getValue());
        $atta->setNoActionableItem($noAction);
        $atta->save();
      
      }
      
      $folderRef = new NoActionableItemFolder();
      $folderRef->setFolder($folderObj);
      $folderRef->setNoActionableItem($noAction);
      $folderRef->save();
      
      
      

    
    return sfView::NONE;
  
  }
  
  
  
  
  /*
  *copy no actionable items on project tree
  */
  public function executeCopy_ajax(sfWebRequest $request) {
    
    $noActionable = $request->getParameter('no_actionable_id');
    $project = $request->getParameter('project_id');

    
    $noaction = Doctrine::getTable('NoActionableItem')->find($noActionable);
    $projectObj = Doctrine::getTable('Project')->find($project);
    
   
    
      $noAction = new NoActionableItem();
      $noAction->setName($noaction->getName());
      $noAction->setDescription($noaction->getDescription());
      $noAction->setType($noaction->getType());
      $noAction->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $noAction->save();
      

      
      foreach ($noaction->getNoActionableItemAttachments() as $att) {
      
        $atta = new NoActionableItemAttachment();
        $atta->setValue($att->getValue());
        $atta->setNoActionableItem($noAction);
        $atta->save();
      
      }
      
      foreach ($noaction->getInformations() as $info) {
        $infoNoActionable = new NoActionableItemInfo();
        $infoNoActionable->setNoActionableItem($noAction);
        $infoNoActionable->setValue($info->getValue());
        $infoNoActionable->setType('TICKER_DATE');
        $infoNoActionable->save();
       
      }
      
    

        $noActionableProject = new NoActionableItemProject();
        $noActionableProject->setProject($projectObj);
        $noActionableProject->setNoActionableItem($noAction);
        $noActionableProject->save(); 
  
    return sfView::NONE;
  
  }
  
  
  public function executeCut_someday_from_project(sfWebRequest $request) {

    $projectId = $request->getParameter('project_id');

    $actionId = $request->getParameter('action_id');
    
    $projectObj = Doctrine::getTable('Project')->find($projectId);
    
    $projectActionObj = Doctrine_Query::create()->from('NoActionableItemProject n')->where('n.NoActionableItem.id=?',$actionId)->execute()->getFirst();
    
    $projectActionObj->setProject($projectObj);
    $projectActionObj->save();
    
    return sfView::NONE;
  
  }
  
  public function executeDelete_from_project(sfWebRequest $request) {
    
    #CASES
    #1- PERMANENT
    #2- FROM PROJECT
    
    $type= $request->getParameter('type');
    $id = $request->getParameter('id');
    
    $project = ( $request->getParameter('project') )? $request->getParameter('project'):-1;
    if ( $type == 'permanent' ) {
    
      $object = Doctrine::getTable('NoActionableItem')->find($id);
      $object->delete();
    
    } else { #from project
          
        $someObj = Doctrine_Query::create()->from('NoActionableItemProject n')->where('n.NoActionableItem.id=?',$id)->execute()->getFirst();

        $someObj->delete();
        
    }
    
    
    return sfView::NONE;
  
  }
  
  public function executeSomeday_to_action(sfWebRequest $request) {
  
    $id = $request->getParameter('id');
    
    //capturo objeto no actionable
    $noActionObj = Doctrine::getTable('NoActionableItem')->find($id);

    //detectar proyecto padre al cual pertenece
    
    $obj = Doctrine_Query::create()->from('NoActionableItemProject n')->Where('n.NoActionableItem.id=?',$id)->execute()->getFirst();
    //capturo el objeto proyecto
    $projectObj = $obj->getProject();
    
    $obj = null;
    
    
    
    //Creo una nueva accion
    
    $nextActionObj = new NextAction();
    
    $nextActionObj->setSfGuardUser( Doctrine::getTable('SfGuardUser')->find( $this->getUser()->getGuardUser()->getId() ) );
    $nextActionObj->setNextActionState( Doctrine::getTable('NextActionState')->find( 1 ) );
    $nextActionObj->setName($noActionObj->getName());
    $nextActionObj->setDescription($noActionObj->getDescription());
    $nextActionObj->setType('DO_ASAP');
    $nextActionObj->save();
    
    //agrego attachments relacionados
    
    foreach ($noActionObj->getNoActionableItemAttachments() as $att) {
    
      $att = new NextActionAttachment();
      $att->setValue($att->getValue());
      $att->setNextAction($nextActionObj);
      $att->save();
      
      $att = null;
    
    }
    
    //agrego criterios relacionados .. 1 de cada uno y el primero que encuentre
    
    //time

    $criteria = new NextActionCriteria();
    $criteria->setNextAction($nextActionObj);
    $criteria->setCriteria($this->criteriaSearch('TIME_AVAILABLE',$this->getUser()->getGuardUser()->getId()));
    $criteria->save();
    $criteria = null;
    
    //context
    
    $criteria = new NextActionCriteria();
    $criteria->setNextAction($nextActionObj);
    $criteria->setCriteria($this->criteriaSearch('CONTEXT',$this->getUser()->getGuardUser()->getId()));
    $criteria->save();  
    $criteria = null;
    
    //energy
    
    $criteria = new NextActionCriteria();
    $criteria->setNextAction($nextActionObj);
    $criteria->setCriteria($this->criteriaSearch('ENERGY',$this->getUser()->getGuardUser()->getId()));
    $criteria->save();
    $criteria = null;
    
    //priority
    
    $criteria = new NextActionCriteria();
    $criteria->setNextAction($nextActionObj);
    $criteria->setCriteria($this->criteriaSearch('PRIORITY',$this->getUser()->getGuardUser()->getId()));
    $criteria->save();  
    $criteria = null;
    
    
    //asocio con el proyecto
    
    $relatedWithProject = new  NextActionProject();
    $relatedWithProject->setNextAction($nextActionObj);
    $relatedWithProject->setProject($projectObj);
    $relatedWithProject->save();
    $relatedWithProject = null;
    
    $noActionObj->delete();
    
    return sfView::NONE;
  
  }
  
  
  //RETURN THE FIRST CRITERIA FOUNDED FROM SPECIFIC USER
  private function criteriaSearch($type,$user) {
  
    $criteria = Doctrine_Query::create()->from('Criteria c')->where('c.type=?',$type)->addWhere('c.sfGuardUser.id=?',$user)->execute()->getFirst();
    
    return $criteria;
  
  }
  
  public function executeReference_move(sfWebRequest $request) {
  
#    parent_id="+jq('#object-id').val()+"&children_id="+id
    $folder = $request->getParameter('parent_id');
    $action = $request->getParameter('children_id');
    
    
    $reference = Doctrine_Query::create()->from('NoActionableItemFolder nf')->Where('nf.NoActionableItem.id=?',$action)->addWhere('nf.Folder.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
    
    echo $reference->getNoActionableItem()->getName();
    
    $reference->setFolder( Doctrine::getTable('Folder')->find($folder) );
    $reference->save();
    
    return sfView::NONE;
    
    
    echo $project.'<br/>';
    echo $action.'<br/>';
    
    die();
  
  }

  
  
  private function loadMessages(){
    //Load the meesages singleton into flash
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }

  public function executeDownload_attachment(sfWebRequest $request)
  {
     $this->noActionableItemAttachment = Doctrine::getTable('NoActionableItemAttachment')
      ->createQuery('s')
      ->addWhere('s.NoActionableItem.user_id = ?', $this->getUser()->getGuardUser()->getId() )
      ->addWhere('s.id = ?', $request->getParameter('attachment_id',-1))
      ->limit(1)
      ->execute();

     if ($this->noActionableItemAttachment->count() <> 1) {
         return sfView::ERROR;
     }

     $file = sfConfig::get('sf_upload_dir').'/'.$this->noActionableItemAttachment->getFirst()->getValue();
     $this->forward404Unless(file_exists($file));

     // Adding the file to the Response object
     $this->getResponse()->clearHttpHeaders();
     $this->getResponse()->setHttpHeader('Pragma: public', true);
     $this->getResponse()->setContentType(MimeContent::mime_content_type($file));
     $this->getResponse()->sendHttpHeaders();
     $this->getResponse()->setContent(readfile($file));

     return sfView::NONE;
  }




}
