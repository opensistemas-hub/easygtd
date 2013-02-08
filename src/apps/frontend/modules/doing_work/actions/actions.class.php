<?php

/**
 * doing_work actions.
 *
 * @package    EasyGtd
 * @subpackage doing_work
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class doing_workActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {    
    //Buscador
    $this->searchId = $request->getParameter("found",-1);
  }

  public function executeShow_project_focus_list(sfWebRequest $request){
     //No hace con las acciones, sólo con los proyectos, todo el trabajo lo hacen los items del buscador y el FOCUS.
     $this->setLayout(false);
     $this->projects = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();  
  }

  public function executeShow_saved_search_list(sfWebRequest $request){
     $this->setLayout(false);
     $this->savedSearches = Doctrine_Query::create()->from('SavedSearch s')->where('s.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();  
  }
  
  //ajax render when change tabs information
  public function executeTabs_content(sfWebRequest $request) {       
  
    $this->criterias = array();

    $types = array();
    
    $type_to_action = ($request->getParameter('type_id',-1) == -1) ? null : $request->getParameter('type_id',-1);
    //Due Today es unixtimestamp
    $dueToday = ($request->getParameter('due_today',-1) == -1) ? null : $request->getParameter('due_today',-1);
    $onlyDate = ($request->getParameter('only_date',-1) == -1) ? null : $request->getParameter('only_date',-1);
    $this->exactDate = ($request->getParameter('exact_date',0) == 0) ? 0 : 1;
    $this->timezoneOffset = ($request->getParameter('timezone_offset',0) == 0) ? 0 : $request->getParameter('timezone_offset',0);     
    
    if ($request->getParameter('context_id',-1) != -1)
     $this->criterias['context_id'] = $request->getParameter('context_id',-1);
    
    if ($request->getParameter('time_id',-1) != -1)
     $this->criterias['time_id'] = $request->getParameter('time_id',-1);

    if ($request->getParameter('energy_id',-1) != -1)
     $this->criterias['energy_id'] = $request->getParameter('energy_id',-1);

    if ($request->getParameter('priority_id',-1) != -1)
     $this->criterias['priority_id'] = $request->getParameter('priority_id',-1);
        
    $this->doneStatus = $request->getParameter('done',0);

    if ($this->doneStatus == 0) {
        $status = "('TO_DO','NOTIFICATED','DELIVERED')";
    } else {
         $status = "('DONE')";
    }

    $stringInQuery= implode(",",$this->criterias);

    //Elemento del paginador
    $this->actionsPager = new sfDoctrinePager('NextAction',sfConfig::get('app_PAGE_SIZE_NEXT_ACTION',20));

 
    //Buscador:
    if (($searchId = $request->getParameter("search_id",-1)) <> -1) {
       $this->actionsPager->setQuery(
                                   $this->show_actions(array(),"('TO_DO','NOTIFICATED','DELIVERED','DONE')",$searchId,null, 0, 0, -1)
                                   );
    } else {

      $this->actionsPager->setQuery(
                                   $this->show_actions($this->criterias,$status,-1,$type_to_action, $dueToday, $onlyDate, $request->getParameter('project_id',-1))
                                   );
    }

    $this->actionsPager->setPage($this->getRequestParameter('page',1));
    $this->actionsPager->init();        

  }


  /*
    $criterias_array = list of criterias on array
    $status = done or not
    $found_text = text from parameter 
    $type_to_action = (do_asap,delegated, etc).
  */

  public function executeNewSavedSearch(sfWebRequest $request) {

    $this->type_to_action = $request->getParameter('type_id',-1);

    $this->dueToday =  $request->getParameter('due_today',-1);

    $this->onlyDate =  $request->getParameter('only_date',-1);

    $this->contexto = $request->getParameter('context_id',-1);
    
    $this->time= $request->getParameter('time_id',-1);
    
    $this->energy = $request->getParameter('energy_id',-1);
   
    $this->priority = $request->getParameter('priority_id',-1);

    $this->doneStatus = $request->getParameter('done',-1);   

    $this->projectId = $request->getParameter('project_id',-1);

    $SavedSearch =  new SavedSearch();

    $this->form = new SavedSearchForm($SavedSearch);
  }


   public function executeSaveSavedSearch(sfWebRequest $request) {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  

    try { 

      $savedSearch = new SavedSearch();
      $savedSearch->setName($request->getParameter('name_saved_search'));

      $typeFocus = new TypeFocus();
      $typeFocus->setValue($request->getParameter('type_id'));
      $savedSearch->getInformations()->add($typeFocus);
  
      $contextFocus = new ContextFocus();
      $contextFocus->setValue($request->getParameter('context_id'));
      $savedSearch->getInformations()->add($contextFocus);
    
      $timeFocus = new TimeFocus();
      $timeFocus->setValue($request->getParameter('time_id'));
      $savedSearch->getInformations()->add($timeFocus);
    
      $energyFocus = new EnergyFocus();
      $energyFocus->setValue($request->getParameter('energy_id'));
      $savedSearch->getInformations()->add($energyFocus);
    
      $priorityFocus = new PriorityFocus();
      $priorityFocus->setValue($request->getParameter('priority_id'));
      $savedSearch->getInformations()->add($priorityFocus);
   
      $doneFocus = new DoneFocus();
      $doneFocus->setValue($request->getParameter('done'));
      $savedSearch->getInformations()->add($doneFocus);

      $projectFocus = new ProjectFocus();
      $projectFocus->setValue($request->getParameter('project_id'));
      $savedSearch->getInformations()->add($projectFocus);

      $onlyDateFocus = new OnlyDateFocus();
      $onlyDateFocus->setValue($request->getParameter('only_date'));
      $savedSearch->getInformations()->add($onlyDateFocus);

      $dueTodayFocus = new DueTodayFocus();
      $dueTodayFocus->setValue($request->getParameter('due_today'));
      $savedSearch->getInformations()->add($dueTodayFocus);
    
      $savedSearch->setUserId($this->getUser()->getGuardUser()->getId());
      $savedSearch->save();

    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeDelete_saved_search(sfWebRequest $request) {

    try {

     $id = str_replace('saved_search_','',$request->getParameter("id",-1));
     $this->forward404Unless($savedSearch = Doctrine_Query::create()->from('SavedSearch s')->where('s.id = ?', $id)->addWhere('s.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute()->getFirst());
     $savedSearch->delete();     

    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  private function show_actions($criterias_array,$status,$searchId = -1,$typeOfAction = null,$dueToday = 0, $onlyDate = 0, $projectId = -1) {
  
    $actions = array();

    $queryActions = Doctrine_Query::create()->from('NextAction n')->where('n.NextActionState.type IN '.$status)->addWhere('n.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->groupBy('n.id');
   
    if (count($criterias_array) <> 0) {
       $queryActions->addWhere('n.NextActionCriterias.Criteria.id IN ('.implode(",",$criterias_array).')' );
       $queryActions->having('COUNT(n.NextActionCriterias.Criteria.id) = '.count($criterias_array));
    }
   
    //Veo si hay un filtro de tipo
    if ($typeOfAction <> '')  
       $queryActions->addWhere('n.type = ? ', $typeOfAction);

    //Veo si hay un filtro de Id
    if ($searchId <> -1)  
       $queryActions->addWhere('n.id = ? ', $searchId);

    if ($dueToday or $onlyDate) {
      //En el caso de un DoASAP, DELEGATED O Scheduled        
        if ($dueToday) {         
          if ($this->exactDate == 0) { 
            $queryActions->addWhere('(n.id IN (
                                     SELECT DISTINCT(ni.next_action_id) FROM NextActionInfo ni INNER JOIN ni.NextAction n100 WHERE n100.sfGuardUser.id = ? AND ni.NextAction.NextActionState.type IN '.$status.' AND ni.type IN (?,?,?) AND DATE_FORMAT(ni.value,"%Y-%m-%d") <= ? 
                                  ) OR n.type = ?) ', array($this->getUser()->getGuardUser()->getId(),'DUE_DATE','FOLLOW_UP_DATE','TO_DO_IN_DATE_START', gmdate('Y-m-d',$dueToday - ($this->timezoneOffset * 60)),'DO_ASAP'));        
          } 
          if ($this->exactDate == 1) { 
            $queryActions->addWhere('n.Informations.type IN (?,?,?)', array('DUE_DATE','FOLLOW_UP_DATE','TO_DO_IN_DATE_START')); 
            $queryActions->addWhere('n.id IN (
                                     SELECT DISTINCT(ni.next_action_id) FROM NextActionInfo ni INNER JOIN ni.NextAction n100 WHERE WHERE n100.sfGuardUser.id = ? AND ni.NextAction.NextActionState.type IN '.$status.' AND ni.type IN (?,?,?) AND DATE_FORMAT(ni.value,"%Y-%m-%d") = ? 
                                  )', array($this->getUser()->getGuardUser()->getId(),'DUE_DATE','FOLLOW_UP_DATE','TO_DO_IN_DATE_START', gmdate('Y-m-d',$dueToday - ($this->timezoneOffset * 60))));         
          } 
        } 
        $queryActions->orderBy('DATE_FORMAT(n.Informations.value,"%Y-%m-%d") DESC');

    }

    if ($projectId <> -1) {
      $queryActions->addWhere('n.NextActionProjects.id IN (?)', $projectId); 
    }


    return $queryActions;
  
  }
  

  public function executeMark_action_as_done(sfWebRequest $request){
  
    
    $stuffAttachments = array();
    
    $stateObj = Doctrine_Query::create()->from('NextActionState n')->where('n.type=?','DONE')->execute()->getFirst();
    
    $action = Doctrine_Query::create()->from('NextAction n')->where('n.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->addWhere('n.id = ?', $request->getParameter('next_action_id'))->limit(1)->execute()->getFirst();  


    $action->setNextActionStateId($stateObj->getId()); 
    $action->save();
    
    $action = null;
     
     
     
     if($request->getParameter('ref') == 'project'){
      
        //pass all someday on this project to inbox
        
        $this->SomedayToInbox($request->getParameter('project_id'));
    
    
       
     }
    

    return sfView::NONE;
    
  
  }


  public function executeMark_action_as_to_do(sfWebRequest $request){

    $action = Doctrine_Query::create()->from('NextAction n')->where('n.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->addWhere('n.id = ?', $request->getParameter('next_action_id'))->limit(1)->execute()->getFirst();  
    $action->setNextActionState(Doctrine::getTable('NextActionState')->createQuery('n')->where('n.type = ?', 'TO_DO')->limit(1)->execute()->getFirst()); 
    $action->save();

    return sfView::NONE;
    $this->redirect('doing_work/index');    
  
  }

  public function executeList_next_actions_done(sfWebRequest $request)
  {  
    $request->getParameterHolder()->add(array('done_status' => 'DONE'));
    $this->forward('doing_work','index');
  }

  public function executeShow(sfWebRequest $request){
  //die('no ejecutado');
       $this->NextActions = Doctrine::getTable('NextAction')
            ->createQuery('n')
            ->addWhere('n.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
            ->addWhere('n.id = ?', $request->getParameter('action_id'))
            ->limit(1)
            ->execute();
      
  }
  
  //Muestra los detalles de las acciones desde calendario  
  public function executeShow_details(sfWebRequest $request){
  
    $action = Doctrine_Query::create()->from('NextAction n')->Where('n.id=?',$request->getParameter('action_id'))->addWhere('n.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
    $this->action = $action;
    
    //saber si este elemento fue creado con funcion recursiva solo comparando hash
    
    $recursive = Doctrine_Query::create()->from('NextAction n')->where('n.hash=?',$action->getHash())->execute();
    $this->recursive = count($recursive);
    
    //capturo todos los criterios
    $context = array();
    $time = array();
    $priority = array();
    $energy = array();

    foreach ($action->getNextActionCriterias() as $row) {
    
      if ($row->getCriteria()->getType() == 'CONTEXT') {
          $context[] = $row->getCriteria()->getValue();        
      }
      
      if ($row->getCriteria()->getType() == 'ENERGY') {
        
        $energy[] = $row->getCriteria()->getValue();
        
      }
      
      if ($row->getCriteria()->getType() == 'PRIORITY') {
        
        $priority[] = $row->getCriteria()->getValue();
        
      }
      
      if ($row->getCriteria()->getType() == 'TIME_AVAILABLE') {
        
        $time[] = array('value'=>$row->getCriteria()->getValue(),'unit'=>$row->getCriteria()->getUnit());
        
      }
    
    }
    
    $this->contexts = $context;
    $this->energys = $energy;
    $this->prioritys = $priority;
    $this->times = $time;
            
  }
  
  public function executeCreate_next_action_project(sfWebRequest $request){

      $this->getUser()->setFlash('ref','project_management/index');
  
      $this->form = new CreateActionableForm();
 
      $this->stuff = new Stuff();
      $this->stuff->setId(-1); //THE UNSAVED VALUE TECHNIQUE  
      
      $this->projects = Doctrine_Query::create()->from('Project project')->where('project.id = ?',$request->getParameter('project_id'))->addWhere('project.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->execute();

      $this->typeNextActions = array(new DoItNow(),new Delegated(),new DoASAP(),new Scheduled());

      $this->type = $request->getParameter('next_action','DO_ASAP'); //The default

      $this->contexts = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'CONTEXT')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->times = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'TIME_AVAILABLE')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->energies = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'ENERGY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->priorities = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'PRIORITY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      try{
          if(count($this->contexts) == 0) throw new Exception('you_dont_have_context_criteria');
          if(count($this->times) == 0) throw new Exception('you_dont_have_context_time_criteria');
          if(count($this->energies) == 0) throw new Exception('you_dont_have_context_energy_criteria');
          if(count($this->priorities) == 0) throw new Exception('you_dont_have_context_priority_criteria');
      } catch (Exception $e){
          $this->error = $e->getMessage();
          return sfView::ERROR;
      }      
  }
  
  public function executeCreate_next_action(sfWebRequest $request){
          
      $this->getUser()->setFlash('ref','doing_work/index');
  
      $this->form = new CreateActionableForm();
 
      $this->stuff = new Stuff();
      $this->stuff->setId(-1); //THE UNSAVED VALUE TECHNIQUE  
      
      $this->projects = Doctrine_Query::create()->from('Project project')->where('project.id = ?',$request->getParameter('project_id'))->addWhere('project.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->execute();

      $this->typeNextActions = array(new DoItNow(),new Delegated(),new DoASAP(),new Scheduled());

      $this->type = $request->getParameter('next_action','DO_ASAP'); //The default

      $this->contexts = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'CONTEXT')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->times = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'TIME_AVAILABLE')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->energies = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'ENERGY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->priorities = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'PRIORITY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      try{
          if(count($this->contexts) == 0) throw new Exception('you_dont_have_context_criteria');
          if(count($this->times) == 0) throw new Exception('you_dont_have_context_time_criteria');
          if(count($this->energies) == 0) throw new Exception('you_dont_have_context_energy_criteria');
          if(count($this->priorities) == 0) throw new Exception('you_dont_have_context_priority_criteria');
      } catch (Exception $e){
          $this->error = $e->getMessage();
          return sfView::ERROR;
      }  
  }  
  
  public function executeDelete_next_action_project(sfWebRequest $request){
  
     $this->forward404Unless($request->getParameter('next_action_id'));
     //$this->forward404Unless($request->getParameter('project_id'));
     
     $q = Doctrine_Query::create()
          ->delete('NextActionProject np')
          ->where('np.next_action_id = ?',$request->getParameter('next_action_id'))
          ->execute();
     
     if ($request->getParameter('ref') == 'tree') {
     
      return sfView::NONE;
     
     } else {
     
      $this->redirect('project_management/index');
     
     }
  
  }  
 
  public function executeCreate_some_day_maybe(sfWebRequest $request){
    $this->forward404Unless($request->getParameter('action_id'));
    $this->ref = $request->getParameter('ref');
    $this->action = Doctrine::getTable('NextAction')->find($request->getParameter('action_id'));
    $this->form = new CreateSomeDayMaybeForm();  
  }
  
  public function executeSave_some_day_maybe(sfWebRequest $request){
   $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CreateSomeDayMaybeForm();
    
    $this->action = Doctrine::getTable('NextAction')->find($request->getParameter('action_id'));
    
    $this->processFormSomeDayMaybe($request, $this->form);

    $this->setTemplate('create_some_day_maybe');
  
  }
  
  protected function processFormSomeDayMaybe(sfWebRequest $request, sfForm $form){
  
     $stuffAttachements = array();
     $stuffAtt = Doctrine_Query::create()->from('NextActionAttachment n')
             ->where('n.NextAction.id = ?',$request->getParameter('action_id'))->execute();

     
//get all stuff attachment for newaction attachment

    foreach($stuffAtt as $stuff){
       
        $nextStuffAttachmentsObject = new NoActionableItemAttachment();
        $nextStuffAttachmentsObject->setValue($stuff->getValue());
        $stuffAttachements[] = $nextStuffAttachmentsObject;
    }


    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    try{
    if ($this->form->getValue('calendar') < date('Y-m-d')) throw new Exception('the_date_cannot_be_less_than_today');
    } catch (Exception $e) {
            $error = new sfValidatorError(new sfValidatorPass(), $e->getMessage());
            $errorSchema = new sfValidatorErrorSchema(new sfValidatorPass(), array('calendar' => $error));
            $form->getErrorSchema()->addError($errorSchema);
          }

    if ($form->isValid())
    {
    
      //Paso 1: Crear un objeto SomeDay Maybe
    $somedayMaybe = new SomeDayMaybe();
    
    //Paso 2: Si la accion tiene un proyecto relacionado se cambia a SomeDayMaybeProject y se borra el NextActionProject
    if ($this->action->getNextActionProjects()->count() > 0) {
      //Itero por cada uno de las relaciones.
      foreach ($this->action->getNextActionProjects() as $nextActionProject) {
        $someDayMaybeProject = new NoActionableItemProject();
        $someDayMaybeProject->setProject($nextActionProject->getProject());
        $somedayMaybe->getNoActionableItemProjects()->add($someDayMaybeProject);
        $nextActionProject->delete();       
      }
          
    } else {
      //DO NOTHING      
    }
    
    //Paso 3: se carga el nombre, el usuario y la fecha de gatillo del somedayMaybe con lo que viene en el form
    $somedayMaybe->setName($this->action->getName());
    $somedayMaybe->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() 
));
    $ticklerDate = new TicklerDate();
    $ticklerDate->setValue($this->form->getValue('calendar'));
    $somedayMaybe->getInformations()->add($ticklerDate);
    //Paso 4: Se copian los adjuntos
     foreach($stuffAttachements as $nexts){
               $somedayMaybe->getNoActionableItemAttachments()->add($nexts);
            }
    //Paso 5: Se elimina la accion.    
    $this->action->delete();

    //Paso 6: Se graba
    $somedayMaybe->save();  
    
    Mensajes::getInstance()->agregarExito('some_day_process_successful');
    $this->loadMessages();
    switch ($request->getParameter('ref','doing')) {
      case 'project':
        $this->redirect('project_management/index');
        break;
      default:
        $this->redirect('doing_work/index');
        break;   
    }
    
      
    }
  
  }
  
    
  private function save_some_day_from_project($project_id, $bool = false){

    $ticklerDate = new TicklerDate();
    $actions = Doctrine_Query::create()->from('NoActionableItemProject n')->where('n.Project.id=?',$project_id)->execute();
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
      #grabo los no_actionable_items de tipo someday asociados a algun proyecto
      $stuff = new Stuff();
      $stuff->setName('Someday: '.$row->getNoActionableItem()->getName());
      $stuff->setDescription($row->getNoActionableItem()->getDescription());
      $stuff->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
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
           ->where('n.project_id = ?',$project_id)
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
    
    
    
  }

   public function executeDownload_attachment(sfWebRequest $request)
  {
     $this->nextActionAttachments = Doctrine::getTable('NextActionAttachment')
      ->createQuery('na')
      ->addWhere('na.NextAction.user_id = ?', $this->getUser()->getGuardUser()->getId() )
      ->addWhere('na.id = ?', $request->getParameter('id',-1))
      ->limit(1)
      ->execute();

     if ($this->nextActionAttachments->count() <> 1) {
         return sfView::ERROR;
     }

     $file = sfConfig::get('sf_upload_dir').'/'.$this->nextActionAttachments->getFirst()->getValue();
     $this->forward404Unless(file_exists($file));

     // Adding the file to the Response object
     $this->getResponse()->clearHttpHeaders();
     $this->getResponse()->setHttpHeader('Pragma: public', true);
     $this->getResponse()->setContentType(MimeContent::mime_content_type($file));
     $this->getResponse()->sendHttpHeaders();
     $this->getResponse()->setContent(readfile($file));

     return sfView::NONE;
  }


  
  public function executeAdd_attachment(sfWebRequest $request){
    
      foreach($_FILES as $index => $file) {          
        //Validate the attachment 
       
        if (strlen($_FILES[$index]['name']) > 0) {
          try {  
            //Validate type          

            if (!is_integer(array_search($_FILES[$index]['type'], sfConfig::get('app_TYPE_OF_FILES')))) throw new Exception('Not valid type in file : '.$_FILES[$index]['name'].'.');
            //Validate size
            if ($_FILES[$index]['size'] > 2000000) throw new Exception('File '.$_FILES[$index]['name'].' too big - 2MB max.'); 
	    //Move the file
            $path = time().'_'.$_FILES[$index]['name'];
         
	    if (move_uploaded_file($_FILES[$index]['tmp_name'], sfConfig::get('sf_upload_dir').'/'.$path)) {
	            $nextActionAttachment = new NextActionAttachment();
              $nextActionAttachment->setValue($path);
              $nextActionAttachment->setNextAction(Doctrine::getTable('NextAction')->find($request->getParameter('action_id')));
              $nextActionAttachment->save();
              $nextActionAttachment=null;
	    } else {
	      //Do nothing
	    }
          } catch (Exception $e) {
            //ERROR MESSAGE
            $this->error=$e->getMessage();
            return sfView::ERROR;
          }
    
    
  }
  }
  $this->redirect('doing_work/index');
  }
  
  public function executeShow_calendar(sfWebRequest $request){
     
      $this->culture = $this->getUser()->getCulture();
      
      $this->calendar = Doctrine_Query::create()->from('NextActionInfo ni,ni.NextAction na')->addWhere('na.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
      
      $this->someday = Doctrine_Query::create()->from('NoActionableItemInfo no,no.NoActionableItem na')->addWhere('na.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
    
  
  }
  
  public function executeForm_calendar(sfWebRequest $request) {
    //CAUTION 
    $this->date = $request->getParameter('date');
    
    $this->contexts = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'CONTEXT')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

    $this->times = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'TIME_AVAILABLE')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

    $this->energies = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'ENERGY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

    $this->priorities = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'PRIORITY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;
    
  }
      
  public function executeSave_calendar(sfWebRequest $request){

    if($request->getParameter('action_name') != ''){
       
       //caso 1 = Lun,Mier,Viernes, caso 2 = Mar,Jue, caso 3= Todos los dias
       $recurrenceType = $request->getParameter('repeat-option');
       
       $firstDate = $request->getParameter('form_date');
       
       $lastDate = ( strlen($request->getParameter('calendar-finish'))>0 )?$request->getParameter('calendar-finish'):0;
       
       //create empty next_action for calendar
       $repeat = $this->addActionToCalendar($request);
       
       //obtengo todos los criterios con respecto al que se creo
       
       $criterias = Doctrine_Query::create()->from('NextActionCriteria n')->where('n.NextAction.id=?',$repeat->getId())->execute();
       
       // repear-choose : 1 means no, 2 yes

       if ($request->getParameter('repeat-choose') == 1) {
        
        //asignate due_date on next action
          
          $due_date  = new DueDate();
          $do_action = new NextActionInfo();
          $do_action->setNextAction($repeat);
          $do_action->setType($due_date->getDiscriminator());
          $do_action->setValue($firstDate);
          $do_action->save();
           
       } else {
          //in case of recurrenceType == 1,2,3
          if ( $recurrenceType == 1 || $recurrenceType == 2 || $recurrenceType == 3 ){
          
            $fechas = Fechas::getInstance()->recurrenceDates($recurrenceType,$firstDate,$lastDate,sfConfig::get('app_RECURRENT_PERIOD_TIME'));
          
          } else {
            
            $fechas = Fechas::getInstance()->recurrenceForLapsus($recurrenceType,$firstDate,$lastDate,sfConfig::get('app_RECURRENT_PERIOD_TIME_ON_PERIOD_LAPSUS'));
          
          }

         
         foreach ($fechas as $key => $fecha) {


          if ($key == 0) {
            
            $repeat->setOriginal(0);
            $due_date  = new DueDate();
            $do_action = new NextActionInfo();
            $do_action->setNextAction($repeat);
            $do_action->setType($due_date->getDiscriminator());
            $do_action->setValue($fecha);
            $do_action->save();   
            $repeat->save();       
          
          } else {

            $repeat = $repeat->copy();
          
            foreach ($criterias as $criteria) {
            
              $criteriaObj = new NextActionCriteria();
              $criteriaObj->setNextAction($repeat);
              $criteriaObj->setCriteria($criteria->getCriteria());
              $criteriaObj->save();
            
            }
            
            $due_date  = new DueDate();
            $do_action = new NextActionInfo();
            $do_action->setNextAction($repeat);
            $do_action->setType($due_date->getDiscriminator());
            $do_action->setValue($fecha);
            $do_action->save();             
            
            $repeat->save();
          
          }
                                      
         }
                  
       
       }
     
    }
       
        Mensajes::getInstance()->agregarExito('the_action_was_added_successfully');
        $this->loadMessages();
       
        $this->redirect('doing_work/show_calendar#calendar');

  }
  
  private function addActionToCalendar($request,$date=null){
  
        $do_asap = new DoAsap();
        $action = new NextAction();
        $action->setName($request->getParameter('action_name'));
        $action->setDescription( str_replace("\r\n"," ",$request->getParameter('action_description')) );
        $action->setNextActionState(Doctrine::getTable('NextActionState')->find(1));
        $action->setType($do_asap->getDiscriminator());
        $action->setHash(md5( $request->getParameter('action_name').time() ));
        $action->setOriginal(1);
        $action->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
        $action->save();
        
        if ( !is_null($date) ) {
                
          $due_date  = new DueDate();
          $do_action = new NextActionInfo();
          $do_action->setNextAction($action);
          $do_action->setType($due_date->getDiscriminator());
          $do_action->setValue($date);
          $do_action->save();
          
        }
                
        //cuento el numero de contextos elegidos
        $criteria_count = count($request->getParameter('context'));
        $context = $request->getParameter('context');
                
        //recorro los contextos y los agrego 
        for($i = 0 ; $i < $criteria_count; $i ++){
        
             $nextActionCriteria = new NextActionCriteria();
             $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($context[$i]));
             $nextActionCriteria->setNextAction($action);
             $nextActionCriteria->save();
             $nextActionCriteria = null;
        }
        
        
        $nextActionCriteria = new NextActionCriteria();
        $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('time')));
        $nextActionCriteria->setNextAction($action);
        $nextActionCriteria->save();
        $nextActionCriteria = null;
        //save energy
        $nextActionCriteria = new NextActionCriteria();
        $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('energy')));
        $nextActionCriteria->setNextAction($action);
        $nextActionCriteria->save();
        $nextActionCriteria = null;
        //save priority
        $nextActionCriteria = new NextActionCriteria();
        $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('priority')));
        $nextActionCriteria->setNextAction($action);
        $nextActionCriteria->save();
        $nextActionCriteria = null;
        
        return $action;
  }
  
  /*
  * This function is used on like project, doing work, calendar
  */
  public function executeDelete_action_from_calendar(sfWebRequest $request){
  
    $q = Doctrine::getTable('NextAction')->find($request->getParameter('id'));
    
    if($q instanceof NextAction){
      $q->delete();
      
      Mensajes::getInstance()->agregarExito('the_action_was_removed_successfully');
      $this->loadMessages();
      if ($request->getParameter('ref') == 'project') {
        $this->redirect('project_management/index');
      } else {
        //DO NOTHING
      }
      
     if ($request->getParameter('ref') == 'doing') {
        $this->redirect('doing_work/index');
      } else {
        //DO NOTHING
      }   
      
      if ($request->getParameter('ref') == 'tree') {
        return sfView::NONE;
      } else {
        //DO NOTHING
      }      
      
      $this->redirect('doing_work/show_calendar');
      
    }else{
      //NO NOTHING
    }
    $this->redirect('doing_work/show_calendar');
  
  }
  
  public function executeDelete_recurrent_action(sfWebRequest $request) {
  
    $id = $request->getParameter('id');
    
    $actionObj = Doctrine::getTable('NextAction')->find($id);
    
    //get All actions
    
    $recurrence = Doctrine_Query::create()->from('NextAction n')->where('n.hash=?',$actionObj->getHash())->execute();
    
    //delete all actions
    foreach ($recurrence as $row) {
      
      $row->delete();  
      
    }
      Mensajes::getInstance()->agregarExito('These have been successfully removed');
      $this->loadMessages();
    return sfView::NONE;
  
  }
  
  
  
  
  public function executeExport_to_ics(sfWebRequest $request){

      $v = new vcalendar();
      
      $criterias = Doctrine_Query::create()->from('NextActionInfo ni,ni.NextAction na')->addWhere('na.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
      
      
      $array_calendar= array();
      
      foreach($criterias as $criteria){

              if($criteria->getValue()!="" && preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/',$criteria->getValue())){
              //parse the dates
                  list($year,$month,$day) = explode('-',$criteria->getValue());
                  $fecha = $year.','.($month-1).','.$day.'';
               }

              if($criteria->getValue()!="" && preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/',$criteria->getValue())){
              //parse the times
                list($hour,$minutes) = explode(':',$criteria->getValue());
                $hora = $hour.','.$minutes;
              } 
               

              $array_calendar[$criteria->getNextAction()->getId()]['name']=$criteria->getNextAction()->getName();
               
              if ($criteria->getType()=='TO_DO_IN_DATE_END'){
                $array_calendar[$criteria->getNextAction()->getId()]['end']=$fecha; 
                }

              if ($criteria->getType()=='TO_DO_IN_DATE_START'){
                $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
               
                }

              if ($criteria->getType()=='DUE_DATE'){
                $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
               
                }  
                
              if ($criteria->getType()=='FOLLOW_UP_DATE'){
                $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
               
                }
                
              if ($criteria->getType()=='FOLLOW_UP_TIME'){
                $array_calendar[$criteria->getNextAction()->getId()]['time']=$hora; 
               
                }  

              if ($criteria->getType()=='DELEGATED_TO'){
                $array_calendar[$criteria->getNextAction()->getId()]['delegated']=$criteria->getValue(); 
               
                }


              $array_calendar[$criteria->getNextAction()->getId()]['description']=$criteria->getNextAction()->getDescription(); 
               

 
 //end formating the data 
        

      
      }


     
     foreach ($array_calendar as $row){


      
      list($years,$months,$days) = explode(',',$row['start']);
      if(!empty($row['end'])){
      
        list($years_end,$months_end,$days_end) = explode(',',$row['end']);
        
        $months_end = $months_end+1;
         if($days_end > 9 ){
          $days_end = $days_end;
        
        }
        if($days_end <= 9){
          $days_end = $days_end;
        }
        
        if($months_end > 9 ){
          $months_end = $months_end;
        }
        if($months_end <= 9){
          $months_end = '0'.$months_end;
        }
        
        $dates_end=$years_end.$months_end.$days_end;
        
      }
      $months = $months+1;
      

      if($days > 9 ){
        $days = $days;
      }
      if($days <= 9){
        $days = $days;
      }
      
      if($months > 9 ){
        $months = $months;
      }
      if($months <= 9){
        $months = '0'.$months;
      }
      
     
      
      
      $dates=$years.$months.$days;
      
      


      ///build the formating
      
          $v->setConfig( '98765445678', 'easygtd.opensistemas.info' );            // set Your unique id

          $v->setProperty( 'method', 'PUBLISH' );                    // required of some calendar software
          $v->setProperty( "x-wr-calname", "EasyGtd Calendar" );      // required of some calendar software
          $v->setProperty( "X-WR-CALDESC", "EasyGtd Calendar" ); // required of some calendar software
          $v->setProperty( "X-WR-TIMEZONE", "America/Santiago" );    // required of some calendar software
          

            $vevent = new vevent();
            
            if(!empty($row['end'])){
              $start_array=array('year'=>$years,'month'=>$months,'day'=>$days);
              $end_array=array('year'=>$years_end,'month'=>$months_end,'day'=>$days_end);

              $vevent->setProperty( 'dtstart', $start_array);
              $vevent->setProperty( 'dtend',  $end_array);

            } else {
            
            $vevent->setProperty( 'dtstart', $dates, array('VALUE' => 'DATE'));
            
            }
            

            $vevent->setProperty(  'summary',$row['name'] );
            $vevent->setProperty(  'description', $row['description'] );


            $v->setComponent ( $vevent );
            $vevent = null;

//end building

     }
     
     
     
      
          $v->returnCalendar();

      
      $this->redirect('doing_work/show_calendar');
      
     
  }
 
    
  protected function SomeDayToInbox($project_id) {

    $query = Doctrine_Query::create()->from('NextActionProject np')->where('np.Project.id=?',$project_id)->addWhere('np.NextAction.next_action_state_id=?',1)->execute();
    
    $projectObj = Doctrine::getTable('Project')->find($project_id);
    

    $cont = count($query);
    
    if($cont == 0) {
      
     
      $this->SomeDayToInboxExecute($project_id);
    
    }
    
    
    
  
  }
  
  protected function SomeDayToInboxExecute($project_id) {

      $stuffAttachments = array();
      $project = Doctrine::getTable('Project')->find($project_id);
      
      foreach ($project->getProjectNoActionableActions() as $row) {
        
        
        
        //new object stuff
        $stuffObj = new Stuff();
        $stuffObj->setName($row->getNoActionableItem()->getName());
        $stuffObj->setDescription($row->getNoActionableItem()->getDescription());
        $stuffObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));  
        $stuffObj->setStuffState(Doctrine::getTable('StuffState')->find(1));
        
        //save stuff
        
         foreach($row->getNoActionableItem()->getNoActionableItemAttachments() as $att){
           //insert into a new object all attachment
          $stuffAttachment = new StuffAttachment();
          $stuffAttachment->setValue($att->getValue());
          $stuffAttachments[] = $stuffAttachment;
          $stuffAttachment = null;
      
        }
        if(count($stuffAttachments) > 0) {
         foreach($stuffAttachments as $stuffAttachment){
           $stuffObj->getStuffAttachments()->add($stuffAttachment);
         }  
         
         }
        
        $stuffObj->save();
        
        //deleting SOMEDAY ITEM
        
        $doctrineQuery = Doctrine::getTable('NoActionableItem')->find($row->getNoActionableItem()->getId());
        
        $doctrineQuery->delete();
        
        $doctrineQuery = null;
        
        
        $stuffObj = null;
        $stuffAttachments = null;
        Mensajes::getInstance()->agregarExito('all_someday_maybe_items_now_are_on_inbox');
        $this->loadMessages();
        
      }  
        
     return sfView::NONE;
    $this->redirect('project_management/index');
  
  }
  /*
    drag & drop function for calendar
  */
  public function executeDrop_dates(sfWebRequest $request) {
    #@param $request->getParameter('id');
    #@param $request->getParameter('days');
    
    $actionObj = Doctrine_Query::create()->from('NextActionInfo ni')->where('ni.NextAction.id=?',$request->getParameter('id'))->execute();
    
    foreach ($actionObj as $row ) {
      

      if ($row->getType() == 'DUE_DATE') {
         $row->setValue(Fechas::getInstance()->suma_fechas($row->getValue(),$request->getParameter('days')));
         $row->save();
      }
      
      if ($row->getType() == 'TO_DO_IN_DATE_START') {
         $row->setValue(Fechas::getInstance()->suma_fechas($row->getValue(),$request->getParameter('days')));
         $row->save();
      }
      
      if ($row->getType() == 'TO_DO_IN_DATE_END') {
         $row->setValue(Fechas::getInstance()->suma_fechas($row->getValue(),$request->getParameter('days')));
         $row->save();
      }
      
      if ($row->getType() == 'FOLLOW_UP_DATE') {
         $row->setValue(Fechas::getInstance()->suma_fechas($row->getValue(),$request->getParameter('days')));
         $row->save();
      }
      
    }

    
  }
  
  public function executeSearch(sfWebRequest $request){
    
    //Load index search values  
    LoadDefaultData::getInstance()->load_index_search(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
    //return value for query
    $this->query = $request->getParameter('q',null);
    $this->types = array();
    $string = '';

    $this->types = array(
                         'project' => ($request->getParameter('project_type'))?'PROJECTS':'',
                         'next_action' => ($request->getParameter('action_type'))?'NEXT_ACTIONS':'',
                         'stuff' => ($request->getParameter('stuff_type'))?'STUFFS':'',
                         'someday' => ($request->getParameter('someday_type'))?'SOMEDAYS':'',
                         'reference' => ($request->getParameter('reference_type'))?'REFERENCES':''
                        
                         );

$count = 0;
 foreach ($this->types as $row) {
  
  if(strlen($row) == 0) {
  
  } else {
    
    if ($count == 0) { 
      $string .= " and s.type='".$row."'";
    } else {
      $string .= " or s.type='".$row."'";
    }
    $count++;
  }
  
  
 }

   
    try {
      
      if(strlen($request->getParameter('q',null)) == 0) throw new Exception('empty');
            

       $this->results = new sfDoctrinePager('IndexSearch',20); 
       $this->results->setQuery(
             Doctrine::getTable('IndexSearch')
                       ->createQuery('s')
                       ->addWhere('s.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())
                       ->addWhere("s.value LIKE ? ".$string,'%'.$request->getParameter('q',null).'%')
                                 
    
       );


                       
       
      $this->results->setPage($this->getRequestParameter('page',1));
      $this->results->init();
      
    } catch (Exception $e) {
      echo $e->getMessage();
      $this->results = null;
      
    }
    
   
    
   
  }
  
  
  public function executeCopy_ajax(sfWebRequest $request) {
      //ID FROM ACTION TO COPY
      $id = $request->getParameter('next_action_id');
      $project = $request->getParameter('project_id');
      
      $actionObj = Doctrine::getTable('NextAction')->find($id);
      
      $action = new NextAction();
      $action->setName($actionObj->getName());
      $action->setNextActionState($actionObj->getNextActionState());
      $action->setDescription($actionObj->getDescription());
      $action->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $action->setType($actionObj->getType());
      
      $action->save();
     
   
      //copy attachment of next action
     
      foreach ($actionObj->getNextActionAttachments() as $att) {
        
        $attach = new NextActionAttachment();
        $attach->setValue($att->getNextActionAttachment()->getValue());
        $attach->setNextAction($action);
        $attach->save();
        $attach = null;
      
      }
      
      //copy criterias of next action

      foreach ($actionObj->getNextActionCriterias() as $criteria) {

        $criterias = new NextActionCriteria();
        $criterias->setNextAction($action);
        $criterias->setCriteriaId($criteria->getCriteria()->getId());
        $criterias->save();
        $criterias = null;
      
      }


      //copy info of next action
      
      foreach ($actionObj->getInformations() as $info) {
      
        $infor = new NextActionInfo();
        $infor->setValue($info->getValue());
        $infor->setNextAction($action);
        $infor->setType($info->getType());
        $infor->save();
        $infor = null;  
        
      
      }
      
      //save related with project
      
      $projectRel = new NextActionProject();
      $projectRel->setProject(Doctrine::getTable('Project')->find($project));
      $projectRel->setNextAction($action);
      $projectRel->save();
      $projectRel = null;
  
      return sfView::NONE;
  
  }
  
  public function executeCut_action_from_project(sfWebRequest $request) {

    $projectId = $request->getParameter('project_id');

    $actionId = $request->getParameter('action_id');
    
    $projectObj = Doctrine::getTable('Project')->find($projectId);
    
    $projectActionObj = Doctrine_Query::create()->from('NextActionProject n')->where('n.NextAction.id=?',$actionId)->execute()->getFirst();
    
    $projectActionObj->setProject($projectObj);
    $projectActionObj->save();
    
    return sfView::NONE;
  
  }
  

  
  public function executeGet_information(sfWebRequest $request) {
    $this->informations = Doctrine_Query::create()->from('NextActionInfo ni')->where('ni.NextAction.id=?',$request->getParameter('action_id'))->execute();
  }
  
  
   private function loadMessages(){
    //Load the meesages singleton into flash
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }
}
