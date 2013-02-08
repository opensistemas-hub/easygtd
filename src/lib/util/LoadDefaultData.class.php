<?php
#function loadNoneCriterias() => carga los criterios NONE para cada usuario nuevo
class LoadDefaultData {

static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new LoadDefaultData();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }
/*loadNoneCriterias
*charge NONE criterias on a User
*@param int $user_id =>   id session from user
*/

public function loadDefaultCriteria($user_id = -1,$culture = 'en') {

  $culture = $culture;
  $extension = 'en';
  
  switch ($culture) {
  
    case 'es':
      $extension = 'ES';
      break;
    case 'en':
      $extension = 'EN';
      break;
    default:
      $extension = 'EN';
      break;
  
  }
  
  $cont = Doctrine_Query::create()->from('Criteria c')->where('c.sfGuardUser.id=?',$user_id)->execute();

  // IF EXIST 1 CRITERIA, THEN STOP THE FUNCION
  if ( count($cont) > 0 ) {
  
    return false;
  
  }
  
   if (Doctrine_Query::create()->from('TimeAvailable ctx')->where('ctx.value = ?','2')->addWhere('ctx.sfGuardUser.id = ? ', $user_id)->addWhere('ctx.type = ?','TIME_AVAILABLE')->limit(1)->execute()->getFirst() instanceof TimeAvailable) {
      //Do NOTHING 
    } else {
    
    $times = sfConfig::get('app_CRITERIAS_TIME');
    
    foreach ($times as $key => $time):

      $tTimeAvailable = new TimeAvailable();
      $tTimeAvailable->setValue($time);         
      $tTimeAvailable->setSfGuardUser(Doctrine_Query::create()->from('SfGuardUser sfguarduser')->where('id = ?',$user_id)->limit(1)->execute()->getFirst());         
      $tTimeAvailable->save();
      
      endForeach;
      
    }


    
      $energys = sfConfig::get('app_CRITERIAS_ENERGY_'.$extension);
      
      foreach ($energys as $energy):
      
      
      if (Doctrine_Query::create()->from('Energy ctx')->where('ctx.value = ?',$energy)->addWhere('ctx.sfGuardUser.id = ? ', $user_id)->limit(1)->execute()->getFirst() instanceof Energy) {
      
      } else { 
      
        $eEnergy = new Energy();
        $eEnergy->setValue($energy);         
        $eEnergy->setSfGuardUser(Doctrine_Query::create()->from('SfGuardUser sfguarduser')->where('id = ?',$user_id)->limit(1)->execute()->getFirst());         
        $eEnergy->save();
         
      }
      
      endForeach;
    
      $prioritys = sfConfig::get('app_CRITERIAS_PRIORITY_'.$extension);
      
      foreach ($prioritys as $priority):
      
       if (Doctrine_Query::create()->from('Priority ctx')->where('ctx.value = ?',$priority)->addWhere('ctx.sfGuardUser.id = ? ', $user_id)->limit(1)->execute()->getFirst() instanceof Priority) {
       
       } else {
                
          $pPriority = new Priority();
          $pPriority->setValue($priority);         
          $pPriority->setSfGuardUser(Doctrine_Query::create()->from('SfGuardUser sfguarduser')->where('id = ?',$user_id)->limit(1)->execute()->getFirst());         
          $pPriority->save();
      
      }
      
      endForeach;
    
    
      $contexts = sfConfig::get('app_CRITERIAS_CONTEXT_'.$extension);
      
      foreach ($contexts as $context):

        if (Doctrine_Query::create()->from('Context ctx')->where('ctx.value = ?',$context)->addWhere('ctx.sfGuardUser.id = ? ', $user_id)->limit(1)->execute()->getFirst() instanceof Context) {
        
        } else {
        
        $cPriority = new Context();
        $cPriority->setValue($context);         
        $cPriority->setSfGuardUser(Doctrine_Query::create()->from('SfGuardUser sfguarduser')->where('id = ?',$user_id)->limit(1)->execute()->getFirst());         
        $cPriority->save();

        }
      
      endForeach;
}

/*
Carga datos por cada usuario para hacer el buscador con sus datos
Casos:
1.Proyectos:
  1.1-Cargar todos los proyectos de un usuario
  1.2-Tomar los nombres de los proyectos he ingresarlos a la base de datos
  1.3-Revisar que no se vuelvan a indexar nuevamente dicho proyecto

-----
@param object User => objeto del usuario al cual se quiere realizar la actividad
**/
public function load_index_search(SfGuardUser $user) {
  #Project Search
  $projectObj = Doctrine_Query::create()->from('Project p')->where('p.sfGuardUser.id=?',$user->getId())->execute();
  //Borra elementos que están en el index, pero no existen el los proyectos.
  Doctrine_Query::create()->from('ProjectIndexSearch i')->where('i.item_id NOT IN (SELECT p.id FROM Project p WHERE p.sfGuardUser.id=?)',$user->getId())->addWhere('i.sfGuardUser.id=?',$user->getId())->execute()->delete();  
      
  foreach ($projectObj as $project) {
    $projectType = new ProjectIndexSearch();
    $query = Doctrine_Query::create()->from('ProjectIndexSearch i')->where('i.item_id=?',$project->getId())->execute();
    #si existe no agregar nuevamente  
    if (count($query) > 0) {
    
    } else { 
  
      $indexSearchObject = new ProjectIndexSearch();
      $indexSearchObject->setSfGuardUser($user);
      $indexSearchObject->setItemId($project->getId());      
      $indexSearchObject->setValue($project->getName());
      $indexSearchObject->save();
      $indexSearchObject = null;
    
    }
      
    $query = null;
    $projectType = null;
  }
  
  $projectObj = null;
  #End project Search
  
  
  #NextAction Search
  $nextActionObj = Doctrine_Query::create()->from('NextAction na')->where('na.sfGuardUser.id=?',$user->getId())->execute();
  //Borra elementos que están en el index, pero no existen el los NextActions.
  Doctrine_Query::create()->from('NextActionIndexSearch i')->where('i.item_id NOT IN (SELECT p.id FROM NextAction p WHERE p.sfGuardUser.id=?)',$user->getId())->addWhere('i.sfGuardUser.id=?',$user->getId())->execute()->delete();
      
  foreach ($nextActionObj as $next) {
    $nextActionType = new NextActionIndexSearch();
    $query = Doctrine_Query::create()->from('NextActionIndexSearch i')->where('i.item_id=?',$next->getId())->execute();
    #si existe no agregar nuevamente  
    if (count($query) > 0) {
    
    } else { 
  
      $indexSearchObject = new NextActionIndexSearch();
      $indexSearchObject->setSfGuardUser($user);
      $indexSearchObject->setItemId($next->getId());
      $indexSearchObject->setValue($next->getName());
      $indexSearchObject->save();
      $indexSearchObject = null;
    
    }
  
  
    
    $query = null;
    $nextActionType = null;
  }
  
  $nextActionObj = null;
  #End NEXT ACTION Search
  
  
  #Stuff Search
  $StuffObj = Doctrine_Query::create()->from('Stuff s')->where('s.StuffState.id = 1 AND s.sfGuardUser.id=?',$user->getId())->execute();
  //Borra elementos que están en el index, pero no existen el los Stuff.
  Doctrine_Query::create()->from('StuffIndexSearch i')->where('i.item_id NOT IN (SELECT p.id FROM Stuff p WHERE p.StuffState.id = 1 AND p.sfGuardUser.id=?)',$user->getId())->addWhere('i.sfGuardUser.id=?',$user->getId())->execute()->delete();
      
  foreach ($StuffObj as $stuff) {
    $stuffType = new StuffIndexSearch();
    $query = Doctrine_Query::create()->from('StuffIndexSearch i')->where('i.item_id=?',$stuff->getId())->execute();
    #si existe no agregar nuevamente  
    if (count($query) > 0) {
    
    } else { 
  
      $indexSearchObject = new StuffIndexSearch();
      $indexSearchObject->setSfGuardUser($user);
      $indexSearchObject->setItemId($stuff->getId());
      $indexSearchObject->setValue($stuff->getName());
      $indexSearchObject->save();
      $indexSearchObject = null;
    
    }
  
  
    
    $query = null;
    $stuffType = null;
  }
  
  $stuffObj = null;
  #End Stuff Search
  
  
  #Someday Search
  $somedayObj = Doctrine_Query::create()->from('SomeDayMaybe ni')->where('ni.sfGuardUser.id=?',$user->getId())->execute();
  //Borra elementos que están en el index, pero no existen el los SomeDayItem
  Doctrine_Query::create()->from('SomeDayIndexSearch i')->where('i.item_id NOT IN (SELECT p.id FROM SomeDayMaybe p WHERE p.sfGuardUser.id=?)',$user->getId())->addWhere('i.sfGuardUser.id=?',$user->getId())->execute()->delete();
      
  foreach ($somedayObj as $some) {
    $someType = new SomeDayIndexSearch();
    $query = Doctrine_Query::create()->from('SomeDayIndexSearch i')->where('i.item_id=?',$some->getId())->execute();
    #si existe no agregar nuevamente  
    if (count($query) > 0) {
    
    } else { 
  
      $indexSearchObject = new SomeDayIndexSearch();
      $indexSearchObject->setSfGuardUser($user);
      $indexSearchObject->setItemId($some->getId());
      $indexSearchObject->setValue($some->getName());
      $indexSearchObject->save();
      $indexSearchObject = null;
    
    }
  
  
    
    $query = null;
    $someType = null;
  }
  
  $somedayObj = null;
  #End Someday Search
  
  
  
  #Reference Search
  $referenceObj = Doctrine_Query::create()->from('Reference ni')->where('ni.sfGuardUser.id=?',$user->getId())->execute();
  //Borra elementos que están en el index, pero no existen el los Reference.
  Doctrine_Query::create()->from('ReferenceIndexSearch i')->where('i.item_id NOT IN (SELECT p.id FROM Reference p WHERE p.sfGuardUser.id=?)',$user->getId())->addWhere('i.sfGuardUser.id=?',$user->getId())->execute()->delete();
      
  foreach ($referenceObj as $ref) {
    $referenceType = new ReferenceIndexSearch();
    $query = Doctrine_Query::create()->from('ReferenceIndexSearch i')->where('i.item_id=?',$ref->getId())->execute();
    #si existe no agregar nuevamente  
    if (count($query) > 0) {
    
    } else { 
  
      $indexSearchObject = new ReferenceIndexSearch();
      $indexSearchObject->setSfGuardUser($user);
      $indexSearchObject->setItemId($ref->getId());
      $indexSearchObject->setValue($ref->getName());
      $indexSearchObject->save();
      $indexSearchObject = null;
    
    }
  
  
    
    $query = null;
    $referenceType = null;
  }
  
  $referenceObj = null;
  #End Someday Search


}// Fin load_index_search

  public function loadDefaultFolder(SfGuardUser $user) {
    //Crea una carpeta si el usuario no la tiene:
    $folders = Doctrine_Query::create()->from('Folder f')->where('f.sfGuardUser.id=?',$user->getId())->orderBy('f.name DESC')->execute();  
    if ($folders->count() == 0) {
      $folder = new Folder();
      $folder->setSfGuardUser($user);
      $folder->setName($user->getUsername());
      $folder->save();
      $folder = null;
    }
    
  }


}
