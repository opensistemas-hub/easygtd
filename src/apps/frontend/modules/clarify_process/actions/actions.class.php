<?php

/**
 * clarify_process actions.
 *
 * @package    EasyGtd
 * @subpackage clarify_process
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clarify_processActions extends sfActions
{  
 
  public function executeStart(sfWebRequest $request) {    
    $this->stuffs = Doctrine_Query::create()->from('Stuff s')->where('s.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('s.StuffState.id=?',1)->execute();
  }

  public function executeNext(sfWebRequest $request) {
    
  }

  public function executeCreate_actionable_from_project(sfWebRequest $request){
    $this->projectsValue = Doctrine_Query::create()->from('Project p')->where('p.id=?',$request->getParameter('project_id'))->addWhere('p.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
    $this->executeCreate_actionable($request);

    if ($request->getParameter('ref',-1) <> -1) {
      $this->ref = $request->getParameter('ref',-1);
    }

  }

  public function executeCreate_actionable(sfWebRequest $request){

      $this->form = new CreateActionableForm();
      
      $this->archivo =  new NextActionAttachmentCustomForm();
      //En el caso de crear una acción en base a una Cosa
      $this->stuff = null;

      if ($request->getParameter('stuff_id',-1) <> -1) {
        $this->stuff = Doctrine_Query::create()->from('Stuff s')->where('s.id=?',$request->getParameter('stuff_id'))->addWhere('s.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
      }

      if ($request->getParameter('ref',-1) <> -1) {
       $this->ref = $request->getParameter('ref',-1);
      }
      
      $this->typeNextActions = array(new DoItNow(),new Delegated(),new DoASAP(),new Scheduled());
      
      $this->contexts = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'CONTEXT')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->orderBy('criteria.value ASC')->execute() ;

      $this->times = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'TIME_AVAILABLE')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->orderBy('criteria.value ASC')->execute() ;

      $this->energies = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'ENERGY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->orderBy('criteria.value ASC')->execute() ;

      $this->priorities = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'PRIORITY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->orderBy('criteria.value ASC')->execute() ;

      $this->projects = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->orderBy('p.name ASC')->execute();

      }

  public function executeSave_actionable(sfWebRequest $request) 
  {      

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  

      $this->forward404Unless($request->isMethod('POST'));

      $this->form = new CreateActionableForm();

      if ($request->getParameter('stuff_id', -1) <> -1) {
        $this->stuff = Doctrine_Query::create()->from('Stuff s')->where('s.id=?',$request->getParameter('stuff_id'))->addWhere('s.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
      }
      
      if ($request->getParameter('action_id', -1) <> -1) { 
        $this->action = Doctrine_Query::create()->from('NextAction na')->where('na.id=?',$request->getParameter('action_id'))->addWhere('na.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
      }

      $this->typeNextActions = array(new DoItNow(),new Delegated(),new DoASAP(),new Scheduled());

      $this->contexts = Doctrine_Query::create()->from('Context c')->where('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->times= Doctrine_Query::create()->from('TimeAvailable c')->where('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->energies = Doctrine_Query::create()->from('Energy c')->where('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->priorities = Doctrine_Query::create()->from('Priority c')->where('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->type = $request->getParameter('next_action','DO_ASAP'); //The default  
         
    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }
      
  }  
  
  public function executeEdit_action(sfWebRequest $request){
     
      //En el caso de crear una acción en base a una Cosa
      $this->action = null;

      if ($request->getParameter('action_id',-1) <> -1) {
        $this->action = Doctrine_Query::create()->from('NextAction n')->where('n.id=?',$request->getParameter('action_id'))->addWhere('n.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
      }  

      if ($request->getParameter('ref',-1) <> -1) {
       $this->ref = $request->getParameter('ref',-1);
      }

        try {
          if ($this->action->getNextActionProjects()->count() == 0) throw new Exception();  
          $this->projectsValue = $this->action->getNextActionProjects()->getFirst()->getProject();  
        } catch (Exception $e) {
 
        }

        $criteriasAssoc = $this->action->getNextActionCriterias();
        $this->contextCriterias = array();

        //action de type DOASAP
        foreach ($criteriasAssoc as $criteriaAssoc) {

          if($criteriaAssoc->getCriteria() instanceof TimeAvailable){
            $this->timeAvailable = $criteriaAssoc->getCriteria();
          }

          if($criteriaAssoc->getCriteria() instanceof Energy){
           $this->energy = $criteriaAssoc->getCriteria();
          }

          if($criteriaAssoc->getCriteria() instanceof Priority){
           $this->priority = $criteriaAssoc->getCriteria();
          }

          if($criteriaAssoc->getCriteria() instanceof Context){
           $this->contextCriterias[] = $criteriaAssoc->getCriteria();
          }

        }
     
        $informations = $this->action->getInformations();

        foreach ($informations as $informationsItem){

         //action de type DOASAP
         if($informationsItem instanceof DueDate){
           $this->duedate = $informationsItem->getValue();
         }

          //action de type DELEGATED
          if($informationsItem instanceof DelegatedTo){
           $this->delegateto = $informationsItem->getValue();
          }

          if($informationsItem instanceof FollowUpDate){
           $this->followupdate = $informationsItem->getValue();
          }

          if($informationsItem instanceof FollowUpTime){
           $this->followuptime  = $informationsItem->getValue();
          }

          //action de type SCHEDULED
          if($informationsItem instanceof ToDoInDateStart){
           $this->todoindatestart = $informationsItem->getValue();
          }

          if($informationsItem instanceof ToDoInDateEnd){
           $this->todoindateend = $informationsItem->getValue();
          }

          if($informationsItem instanceof ToDoInHourStart){
           $this->todoinhourstart = $informationsItem->getValue();
          }

          if($informationsItem instanceof ToDoInHourEnd){
           $this->todoinhourend = $informationsItem->getValue();
          }                 

        }

      $this->executeCreate_actionable($request);
  
  }

  
  public function executeDelete_attachment(sfWebRequest $request){

    if ($request->getParameter('stuff_attachment_id', -1 ) <> -1 ) {
      
      $this->attachments = Doctrine::getTable('StuffAttachment')
           ->createQuery('s')
           ->addWhere('s.Stuff.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
           ->addWhere('s.id = ?', $request->getParameter('stuff_attachment_id',-1))
           ->limit(1)
           ->execute();      
    } 

    if ($request->getParameter('next_action_attachment_id', -1 ) <> -1 ) {
    
       $this->attachments = Doctrine::getTable('NextActionAttachment')
             ->createQuery('na')
             ->addWhere('na.NextAction.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
             ->addWhere('na.id = ?', $request->getParameter('next_action_attachment_id',-1))
             ->limit(1)
             ->execute();            
    }
    
    if ($this->attachments->count() <> 1) {
        return sfView::ERROR;  
    }

    $this->attachments->getFirst()->delete();
     
    return sfView::NONE;

  } 
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    if ($form->isValid())
    {
      if($this->action instanceof NextAction) $val = 'new' ;
      $nextActionObj = ($this->action instanceof NextAction) ? $this->action : new NextAction();

      //Uso una excepción al BIND.
      $nextActionObj->setName($this->form->getValue('name'));
      $nextActionObj->setDescription($request->getParameterHolder()->get('description'));      
      $nextActionObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));      

      if ($request->getParameter('project_id',-1) != -1) {
        $nextActionObj->getNextActionProjects()->delete();
        $nextActionProject = new NextActionProject();
        $nextActionProject->setProject(Doctrine::getTable('Project')->find($request->getParameter('project_id')));
        $nextActionObj->getNextActionProjects()->add($nextActionProject);          
      }

      if ($this->stuff instanceof Stuff) {
        //get all stuff attachment for newaction attachment
        $stuffAttachments = array();
        foreach($this->stuff->getStuffAttachments() as $stuffAttachment) {
          $nextActionAttachmentsObject = new NextActionAttachment();
          $stuffAttachments[] = $nextActionAttachmentsObject->setValue($stuffAttachment->getValue());         
        }
         
        foreach($stuffAttachments as $next){
          $nextActionObj->getNextActionAttachments()->add($next);
        }         
      }
        

        //TODO MENSAJE DE ERROR EN EL FLASH.
        $fileHandlerForm = new NextActionAttachmentCustomForm(); //Utilidad para el binding de los adjuntos.
        //fileHandlerForm es el objeto Form que sirve para subir un adjunto.
        $fileHandlerForm->bindMultipleFiles($_FILES); //Le paso el adjunto de archivos de tipo FILE para que los suba y me dé los avisos.
        foreach($fileHandlerForm->getNextActionAttachmentCollection() as $index => $nextActionAttachment){
          $nextActionObj->getNextActionAttachments()->add($nextActionAttachment);
        }
      
     //SI SE ACTUALIZA, ENTONCES NO CAMBIE EL HASH
      if ( ($this->action instanceof NextAction) ) { 
        //DO NOTHING      
      } else { //CASO STUFF
        $nextActionObj->setHash(md5($this->form->getValue('name').time() ));  
        $nextActionObj->setOriginal(1);          
      }

      $nextActionState = new ToDo();
    
      switch ($request->getParameter('next_action')) {
        case 'DO_IT_NOW': $nextActionState = Doctrine::getTable('NextActionState')->find(2);
          break;

        case 'DO_ASAP': $nextActionState = Doctrine::getTable('NextActionState')->find(1);
          break;

        case 'DELEGATED': $nextActionState = Doctrine::getTable('NextActionState')->find(3);
          break;

        case 'SCHEDULED': $nextActionState = Doctrine::getTable('NextActionState')->find(1);
          break;
      }

      $nextActionObj->setNextActionState($nextActionState);
               
      if ($this->stuff instanceof Stuff) {
        $this->stuff->setStuffState(Doctrine::getTable('StuffState')->find(3));
        $this->stuff->save();

        $nextActionStuff = new NextActionStuff();
        $nextActionStuff->setNextAction($nextActionObj);
        $nextActionStuff->setStuff($this->stuff);
        $nextActionStuff->save();
      }

      $nextActionObj->setType($request->getParameter('next_action'));
      $nextActionObj->save();
      

       
      //save 1 or more context
      //first i deleted all criterias on the action en el caso de estar editando.
      $nextActionObj->getNextActionCriterias()->delete(); 
       
      //Count the criteria choosen      
      $criteria_count = count($request->getParameter('context'));
      $context = $request->getParameter('context');      
      //recorro los contextos y los agrego       
      for ($i = 0 ; $i <$criteria_count; $i ++) {           
            $nextActionCriteria = new NextActionCriteria();
            $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($context[$i]));
            $nextActionCriteria->setNextAction($nextActionObj);
            $nextActionCriteria->save();
            $nextActionCriteria = null;         
       }      
      
      try {
          //Scheduled does not need to save time, priority and energy
          if (($request->getParameter('next_action') == 'SCHEDULED') or ($request->getParameter('next_action') == 'DO_IT_NOW')  or ($request->getParameter('next_action') == 'DELEGATED') ) throw new Exception();
          //save time_available if this have one
          $nextActionCriteria = new NextActionCriteria();
          $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('time')));
          $nextActionCriteria->setNextAction($nextActionObj);
          $nextActionCriteria->save();
          $nextActionCriteria = null;
          //save energy
          $nextActionCriteria = new NextActionCriteria();
          $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('energy')));
          $nextActionCriteria->setNextAction($nextActionObj);
          $nextActionCriteria->save();
          $nextActionCriteria = null;
          //save priority
          $nextActionCriteria = new NextActionCriteria();
          $nextActionCriteria->setCriteria(Doctrine::getTable('Criteria')->find($request->getParameter('priority')));
          $nextActionCriteria->setNextAction($nextActionObj);
          $nextActionCriteria->save();
          $nextActionCriteria = null;
          
       } catch (Exception $e) {
            //DO NOTHING                       
       }
          
       //Delete first the nextActionInfo
       $nextActionObj->getInformations()->delete();

         if ($request->getParameter('next_action')=='DO_ASAP') {
           
           //in this case the date is not necesary, then if exist save in the info, else don´t
           if ($request->getParameter('calendar_do_asap')){
            
             //verifico si quiero que se repita- en caso de que sea asi solo lo hace
             //TODO: ¿Qué va a pasar con las acciones recurrentes no originales al editar?
             $recurrenceType = $request->getParameter('repeat-option');
             $firstDate = $request->getParameter('calendar_do_asap');
             $lastDate = ( strlen($request->getParameter('calendar-finish'))>0 )?$request->getParameter('calendar-finish'):0;
             $criterias = Doctrine_Query::create()->from('NextActionCriteria n')->where('n.NextAction.id=?',$nextActionObj->getId())->execute();
             $nextActionObjC = $nextActionObj;

             switch ( $request->getParameter('repeat-choose', 1) ) {
             
               case '1':               
                 $nextActionInfo = new DueDate();
                 $nextActionInfo->setValue($firstDate);
                 $nextActionInfo->setNextAction($nextActionObj);
                 $nextActionInfo->save();
                 $nextActionInfo = null;              
                 break;
                
               case '2':
               // si recurrenceType = 1 entonces es Lunes,Miercoles y viernes
               // si es 2 es Martes y Jueves
               // si es 3 todos los dias
               // si es 4 es una vez a la semana
               // si es 5 una vez al mes
               // si es 6 una vez al año
                 if ( $recurrenceType == 1 || $recurrenceType == 2 || $recurrenceType == 3 ){                
                   $fechas = Fechas::getInstance()->recurrenceDates($recurrenceType,$firstDate,$lastDate,sfConfig::get('app_RECURRENT_PERIOD_TIME'));           
                 } else {           
                   $fechas = Fechas::getInstance()->recurrenceForLapsus($recurrenceType,$firstDate,$lastDate,sfConfig::get('app_RECURRENT_PERIOD_TIME_ON_PERIOD_LAPSUS'));              
                 }
                 
                 foreach ($fechas as $key => $fecha) {
                   if ($key == 0) {
                     $nextActionObjC->setOriginal(0);
                     $do_action = new DueDate();
                     $do_action->setNextAction($nextActionObjC);
                     $do_action->setValue($fecha);
                     $do_action->save();   
                     $nextActionObjC->save();                 
                   } else {
                     $nextActionObjC = $nextActionObjC->copy();
                     foreach ($criterias as $criteria) {
                       $criteriaObj = new NextActionCriteria();
                       $criteriaObj->setNextAction($nextActionObjC);
                       $criteriaObj->setCriteria($criteria->getCriteria());
                       $criteriaObj->save();            
                     }

                   $do_action = new DueDate();
                   $do_action->setNextAction($nextActionObjC);
                   $do_action->setValue($fecha);
                   $do_action->save();             
            
                   $nextActionObjC->save();
                   } //End if                                    
                 }                              
                 break;            
              } //End switch
            
              
             
             } else {
              //DO NOTHING
             }
           } //En if DO ASAP

          //if this next action have a type delegate or scheduled them save a values in the corresponding entities
          if($request->getParameter('next_action')=='DELEGATED' || $request->getParameter('next_action')=='SCHEDULED'){

             if(strlen($request->getParameter('delegate_to')) > 0) {
                  //in case to delegate to
                  $nextActionInfo = new DelegatedTo();
                  $nextActionInfo->setValue($request->getParameter('delegate_to'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->save();
                  $nextActionInfo = null;

                  if($request->getParameter('calendar_delegated') <> ''){
                  
                  $nextActionInfo = new FollowUpDate();
                  $nextActionInfo->setValue($request->getParameter('calendar_delegated'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->save();
                  $nextActionInfo = null;
                  
                  }

                  if($request->getParameter('followup_time') <> ''){
                  
                  $nextActionInfo = new FollowUpTime();
                  $nextActionInfo->setValue($request->getParameter('followup_time'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->save();
                  $nextActionInfo = null;
 
                  } 

              } else {
                  // case scheluded
                  $to_do_in_date_start = new ToDoInDateStart();
                  $nextActionInfo = new NextActionInfo();
                  $nextActionInfo->setValue($request->getParameter('calendar_scheluded_start'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->setType($to_do_in_date_start->getDiscriminator());
                  $nextActionInfo->save();
                  $nextActionInfo = null;
                  $to_do_in_date = null;
                  
                  $to_do_in_date_end = new ToDoInDateEnd();
                  $nextActionInfo = new NextActionInfo();
                  $nextActionInfo->setValue((strlen($request->getParameter('calendar_scheluded_end')) > 0)?$request->getParameter('calendar_scheluded_end'):$request->getParameter('calendar_scheluded_start'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->setType($to_do_in_date_end->getDiscriminator());
                  $nextActionInfo->save();
                  $nextActionInfo = null;
                  $to_do_in_date = null;

                  $to_do_in_hour_start = new ToDoInHourStart();
                  $nextActionInfo = new NextActionInfo();
                  $nextActionInfo->setValue($request->getParameter('time_choose_start'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->setType($to_do_in_hour_start->getDiscriminator());
                  $nextActionInfo->save();
                  $nextActionInfo = null;
                  $to_do_in_hour_start=null;
                  
                  $to_do_in_hour_end = new ToDoInHourEnd();
                  $nextActionInfo = new NextActionInfo();
                  $nextActionInfo->setValue($request->getParameter('time_choose_end'));
                  $nextActionInfo->setNextAction($nextActionObj);
                  $nextActionInfo->setType($to_do_in_hour_end->getDiscriminator());
                  $nextActionInfo->save();
                  $nextActionInfo = null;
                  $to_do_in_hour_end=null;
                  
              }
            }

    }//fin is valid form
} 
  
 

  //RETURN THE FIRST CRITERIA FOUNDED FROM SPECIFIC USER
  private function criteriaSearch($type,$user) {
  
    $criteria = Doctrine_Query::create()->from('Criteria c')->where('c.type=?',$type)->addWhere('c.sfGuardUser.id=?',$user)->execute()->getFirst();
    
    return $criteria;
  
  }
  
  public function executeFolder_view_ajax(sfWebRequest $request) {   
    $this->folders = Doctrine_Query::create()->from('Folder f')->where('f.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->orderBy('f.name DESC')->execute();  
    //Esto ejecuta la creación de una libreta por defecto.
    if ($this->folders->count() == 0) { 
      LoadDefaultData::getInstance()->loadDefaultFolder($this->getUser()->getGuardUser());
      $this->folders = Doctrine_Query::create()->from('Folder f')->where('f.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->orderBy('f.name DESC')->execute();  
    }

  }


  public function executeCreate_no_actionable(sfWebRequest $request){
   
    $this->form = new CreateNoActionableForm();

    //estoy creando un no actionable desde un stuff
    $this->stuff = Doctrine_Query::create()->from('Stuff stuff')->where('stuff.id = ?',$request->getParameterHolder()->get('stuff_id'))->addWhere('stuff.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->addOrderBy('id ASC')->limit(1)->execute()->getFirst();

    //En este caso estoy transformando una accion de NextAction a NoActionable {Reference o SomeDayMaybe}
    $this->nextAction = Doctrine_Query::create()->from('NextAction nextAction')->where('nextAction.id = ?',$request->getParameterHolder()->get('next_action_id'))->addWhere('nextAction.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->addOrderBy('id ASC')->limit(1)->execute()->getFirst();
    
    $this->folders = Doctrine::getTable('Folder')
         ->createQuery('f')
         ->addWhere('f.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
         ->execute();
    
    if ($request->getParameter('ref',-1) <> -1) {
      $this->ref = $request->getParameter('ref',-1);
    }

  }

  public function executeSave_no_actionable(sfWebRequest $request){
    
       $this->forward404Unless($request->isMethod('POST'));
              
       $this->folders = Doctrine::getTable('Folder')
            ->createQuery('f')
            ->addWhere('f.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
            ->execute();

       if($request->getParameter('next_action_id',-1) <> -1){
         $this->nextAction = Doctrine_Query::create()->from('NextAction nextAction')->where('nextAction.id = ?',$request->getParameter('next_action_id'))->addWhere('nextAction.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->addOrderBy('id ASC')->limit(1)->execute()->getFirst();
       } else {
         $this->stuff = Doctrine_Query::create()->from('Stuff stuff')->where('stuff.id = ?',$request->getParameterHolder()->get('stuff_id'))->addWhere('stuff.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->addOrderBy('id ASC')->limit(1)->execute()->getFirst();
       }

       $this->form = new CreateNoActionableForm();
    
       $this->processFormNoActionable($request, $this->form);

  }
  
  protected function processFormNoActionable(sfWebRequest $request, sfForm $form)
  {

    //Estoy editando
    if($this->nextAction instanceof NextAction){

      $nextActionAttachments = array();

      foreach($this->nextAction->getNextActionAttachments() as $nextAction){
          $nextActionAttachmentsObject = new NoActionableItemAttachment();
          $nextActionAttachmentsObject->setValue($nextAction->getValue());
          $nextActionAttachments[] = $nextActionAttachmentsObject;
      }

    } else if($this->stuff instanceof Stuff){ //cuando viene de Stuff
      $stuffAttachments = array();     
      //get all stuff attachment for newaction attachment
      foreach($this->stuff->getStuffAttachments() as $stuff){
          $nextStuffAttachmentsObject = new NoActionableItemAttachment();
          $stuffAttachments[] = $nextStuffAttachmentsObject->setValue($stuff->getValue());
      }

    }
    // Here process a save_actionabled and save all values necessary from all entities related
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    //inicio el validador de campos
    try{

        if ($request->getParameter('actions')=='list'){
            if($this->form->getValue('date')){
            if($this->form->getValue('date') < date('Y-m-d')) throw new Exception('The date cannot be less than today');
            }
        }

        if ($request->getParameter('actions') == 'folder') {

            if($request->getParameter('folder_id',-1) == -1) throw new Exception('You must choose some folder.');

        }

    } catch (Exception $e) {
       $error = new sfValidatorError(new sfValidatorPass(), $e->getMessage());
       $errorSchema = new sfValidatorErrorSchema(new sfValidatorPass(), array('date' => $error));
       $form->getErrorSchema()->addError($errorSchema);
    }
    
    if ($form->isValid()) {

        switch ($request->getParameter('actions')){

            case "delete":

              if($this->nextAction instanceof NextAction){ 

                $q = Doctrine_Query::create();
                $q->delete('NextAction s');
                $q->where('s.id = ?', $request->getParameter('next_action_id'));
                $q->execute(); 

              } else { //elimino Stuff
                $q = Doctrine_Query::create();
                $q->delete('Stuff s');
                $q->where('s.id = ?', $request->getParameter('stuff_id'));
                $q->execute();

              } 
              break;

            case "list":

              if($this->nextAction instanceof NextAction){
               $noActionableItem  = new SomeDayMaybe();              ;
               $noActionableItem->setName($this->nextAction->getName());
               $noActionableItem->setDescription($this->nextAction->getDescription());
               $noActionableItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));

               //save attachments
               foreach($nextActionAttachments as $nexts){
                  $noActionableItem->getNoActionableItemAttachments()->add($nexts);
               }

              }else if($this->stuff instanceof Stuff){
         
               $noActionableItem = new SomeDayMaybe();
               $noActionableItem->setName($this->stuff->getName());
               $noActionableItem->setDescription($this->stuff->getDescription());
               $noActionableItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));            
    
               //save attachments
               foreach($stuffAttachments as $next){
                  $noActionableItem->getNoActionableItemAttachments()->add($next);
               }
               
              }
              
               $noActionableItem->save();

               $type = null;

            if($this->form->getValue('date')){

               $noActionItemInfo = new TicklerDate();
               $noActionItemInfo->setNoActionableItem($noActionableItem);
               $noActionItemInfo->setValue($this->form->getValue('date'));
               $noActionItemInfo->save();

               $type=null;
               $noActionItemInfo=null;
               //$noActionableItem=null;
          }

                 if($this->nextAction instanceof NextAction){// elimino el Next Action, ya fue transformado a references o SomeDayMaybe
                   $this->nextAction->delete();
                 } else if($this->stuff instanceof Stuff) {//si es un stuff se le cambia el state
                     $this->stuff->setStuffState(Doctrine::getTable('StuffState')->find(3));
                     $this->stuff->save();
                 }

                break;

            case "folder":
             if($this->nextAction instanceof NextAction){ 
               //Editando
               $noActionableItem =  new Reference();
               $noActionableItem->setName($request->getParameter('nextAction_name'));
               $noActionableItem->setDescription(str_replace("\r\n"," ",$request->getParameter('nextAction_description')));
               $noActionableItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
               $noActionableItem->setType($type->getDiscriminator());
               $noActionableItem->save();
                //save attachments
               foreach($nextActionAttachements as $nexts){
                  $noActionableItem->getNoActionableItemAttachments()->add($nexts);
               }

                $noActionableItem->save();

             } else {

               $noActionableItem =  new Reference();
               $noActionableItem->setName($this->stuff->getName());
               $noActionableItem->setDescription($this->stuff->getDescription());
               $noActionableItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));

               //save attachments 
               foreach($stuffAttachments as $nexts){
                 $noActionableItem->getNoActionableItemAttachments()->add($nexts);
               }

                 $noActionableItem->save();

               }

               //Grabar no actionable para asociarlo en un folder
               if ($request->getParameter('folder_id',-1) <> -1 ) {
                 $noActionableItemFolder = new NoActionableItemFolder();
                 $noActionableItemFolder->setNoActionableItem($noActionableItem);
                 $noActionableItemFolder->setFolder(Doctrine::getTable('Folder')->find($request->getParameter('folder_id')));
                 $noActionableItemFolder->save();
                 $noActionableItemFolder=null;
               }


              if ($this->nextAction instanceof NextAction){// elimino el Next Action, ya fue transformado a references o SomeDayMaybe

                $q = Doctrine_Query::create();
                $q->delete('NextAction s');
                $q->where('s.id = ?', $request->getParameter('nextAction_id'));
                $q->execute();

               } else {// cambio de estado el stuff

                 $stuff = Doctrine_Query::create()->from('Stuff stuff')->where('stuff.id = ?',$request->getParameter('stuff_id'))->addWhere('stuff.sfGuardUser.id = ? ', $this->getUser()->getGuardUser()->getId())->addOrderBy('id ASC')->limit(1)->execute()->getFirst();
                 $stuff->setStuffState(Doctrine::getTable('StuffState')->find(3));
                 $stuff->save();
               }

               

            break;

        }


    } else {
      
    }

 }

 
 public function executeDownload_attachment(sfWebRequest $request)
  {
  
    #Download global
    #capturar tipo de caso
    #Dependiendo el caso crear el objeto
    
    if ($request->getParameter('stuff_attachment_id', -1 ) <> -1 ) {
 
        $this->objectAttachments = Doctrine::getTable('StuffAttachment')
            ->createQuery('s')
            ->addWhere('s.Stuff.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
            ->addWhere('s.id = ?', $request->getParameter('stuff_attachment_id', -1 ))
            ->limit(1)
            ->execute();
    }

    if ($request->getParameter('next_action_attachment_id', -1 ) <> -1 ) {
       
        $this->objectAttachments = Doctrine::getTable('NextActionAttachment')
            ->createQuery('s')
            ->addWhere('s.NextAction.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
            ->addWhere('s.id = ?',$request->getParameter('next_action_attachment_id', -1 ))
            ->limit(1)
            ->execute();
        
     }

    if ($request->getParameter('project_attachment_id', -1 ) <> -1 ) {
          
        $this->objectAttachments = Doctrine::getTable('ProjectAttachment')
            ->createQuery('s')
            ->addWhere('s.Project.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
            ->addWhere('s.id = ?', $request->getParameter('project_attachment_id',-1))
            ->limit(1)
            ->execute();   
    }
    
     if ( count($this->objectAttachments) <> 1) {
         return sfView::ERROR;  
     }

     $file = sfConfig::get('sf_upload_dir').'/'.$this->objectAttachments->getFirst()->getValue();
     $this->forward404Unless(file_exists($file));

     header('Content-Description: File Transfer');
     header('Content-Type: application/octet-stream');
     header('Content-Disposition: attachment; filename='.basename($file));
     header('Content-Transfer-Encoding: binary');
     header('Expires: 0');
     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     header('Pragma: public');
     header('Content-Length: ' . filesize($file));
     ob_clean();
     flush();
     readfile($file);
	
     return sfView::HEADER_ONLY;
  	
  }
  
  public function executeTester_editer(sfWebRequest $request) {
  
    $id = $request->getParameter('id');
    
    $actionObj = Doctrine::getTable('NextAction')->find($id);
    $this->action = $actionObj;    
    
    //render tree
    $q = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id = ?',$this->getUser()->getGuardUser()->getId());
    
    $this->treeObject = Doctrine::getTable('Project')->getTree();
    //insert the custom query on the tree object
    $this->treeObject->setBaseQuery($q);
     
    $this->rootColumnName = $this->treeObject->getAttribute('rootColumnName');
    
    //end render tree
    
    //all contexts
     
      $this->contexts = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'CONTEXT')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->times = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'TIME_AVAILABLE')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->energies = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'ENERGY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;

      $this->priorities = Doctrine_Query::create()->from('Criteria criteria')->where('criteria.type = ?', 'PRIORITY')->addWhere('criteria.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute() ;   
    
    // end all contexts
  
  }
  
 private function loadMessages(){

    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
 
 }

}
