<?php
class AlertasCorreo {
    static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new AlertasCorreo();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }
   /*
   @param int $id => user_id session
   */
   public function alertas($id=-1) {
      $userObj = Doctrine::getTable('SfGuardUser')->find($id);
      
      $alertObj = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.user_id=?',$id)->execute();
      $required = array();
      $actionObject = null;
      $noactionObject = null;
      $actions_types = array();
      $noaction_types = array();
      $actions = array();
      $type_action = array();
      $array = array();
      $email = null;
      $someday = null;
      $days = null;
      $scheluded = null;
      $delegate = null;
      $doasap = null;
      $this_day = null;
      $calculate_day = null;
     //capturo los datos para hacer los criterios de busquedas
     
     foreach ($alertObj as $row) {

      $array[] = $row->getValue();

      
     }
      $this_day = date('Y-m-d');
      $email = $array[0];
      $someday = $array[1];
      $days = $array[5];
      $scheluded = $array[2];
      $delegate = $array[3];
      $doasap = $array[4];
      //calculo la fecha requerida por el usuario en su panel
      $calculate_day = Fechas::getInstance()->suma_fechas($this_day,$days);

      foreach ($array as $key => $row) {
        if ($key == 0 || $key == 5) {
        
        } else {      
          if ($row) {
          switch ($key) {
            
            case 1:
              $required[] = 'TICKLER_DATE';
              break;
            case 2:
              $required[] = 'TO_DO_IN_DATE_START';
              break;
            case 3:
              $required[] = 'FOLLOW_UP_DATE';
              break;
            case 4:
              $required[] = 'DUE_DATE';
              break;      
          }  
          } else {
            //DO NOTHING
          }
        }
      }
      
     foreach ($required as $req) {
      if($req == 'TICKLER_DATE'){
        //DO NOTHING
      } else {
        $actions_types [] = $req; 
      }
      
     }
      
      foreach ($required as $re) {
         
         if($re == 'TICKLER_DATE') {
          $noaction_types[] = $re;
         } else {
          //
         }
      
      }

      //BUSCO EN LOS NEXT ACTIONS
      if (count($actions_types) > 0){
      $actionObject = Doctrine_Query::create()->from('NextActionInfo ni')->where('ni.type IN ?',array($actions_types))->addWhere('ni.value =?',$calculate_day)->addWhere('ni.NextAction.user_id=?',$id)->execute();
      
      foreach ($actionObject as $next) {
          $actions[] =  $next->getNextAction()->getName();
          $type_action[] = 'ACTION';
      }
      
      } else {
        //
      }
     
      
      
      //BUSCO LOS NO ACTIONABLE O SOMEDAYMAYBE
      if (count($noaction_types) > 0) {
      $noactionObject = Doctrine_Query::create()->from('NoActionableItemInfo na')->where('na.type IN ?',array($noaction_types))->addWhere('na.value =?',$calculate_day)->addWhere('na.NoActionableItem.user_id=?',$id)->execute();
      
      foreach ($noactionObject as $action) {
          $actions[] = $action->getNoActionableItem()->getName();
          $type_action[] = 'SOMEDAYITEM';
      }
     
      } else {
        //
      }
      
      //ENVIO EL CORREO CON LOS ITEMS
      
      $packing = array();
      
      $packing = array(
                        'actions' => $actions,
                        'type_action' => $type_action,
                        'for_email' => $email,
                        'released_date'=> $this_day,
                        'name_user'=>$userObj->getUsername(),
                        'scheluded_date' => $calculate_day
                        
                      );
                      
       //Envio el correo electronico      
      
      if ( count($actions) > 0 ) {
       
       EnviarCorreo::getInstance()->alertas($packing);               
      
      } else {
        //DO NOTHING
      }
     
   }
   
}   
