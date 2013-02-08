<?php

/**
 * calendar actions.
 *
 * @package    EasyGtd
 * @subpackage calendar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class calendarActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeExport(sfWebRequest $request)
  {
    $icalId = $request->getParameter("hash_calendar");
    //Busco el usuario:
    $user = Doctrine_Query::create()->from('SfGuardUser u')->where('MD5(CONCAT(u.username,u.created_at,u.id)) = ?', $icalId)->execute()->getFirst(); 
    $this->forward404Unless($user);
    //Obtengo Todas las NextActions con que tengan una fecha relacionada:
    $status = "('TO_DO','NOTIFICATED','DELIVERED','DONE')";
    $queryActions = Doctrine_Query::create()->select('DISTINCT n.id')->from('NextAction n')->where('n.NextActionState.type IN '.$status)->addWhere('n.sfGuardUser.id = ?', $user->getId());
    //En el caso de un DoASAP, DELEGATED O Scheduled
    $queryActions->addWhere('n.Informations.type IN (?,?,?)', array('DUE_DATE','FOLLOW_UP_DATE','TO_DO_IN_DATE_START'));     
    $queryActions->groupBy('n.id');
    $v = new sfiCalCalendar();                          // initiate new CALENDAR
    foreach ($queryActions->execute() as $nextAction) {
      $e = new sfiCalEvent();                             // initiate a new EVENT
      $e->setProperty( 'categories', 'EasyGTD' );                   // catagorize

      $fechas = $nextAction->getNextActionDatas(new DueDate());
      $fechas = array_merge($fechas, $nextAction->getNextActionDatas(new FollowUpDate()));
      $fechas = array_merge($fechas, $nextAction->getNextActionDatas(new ToDoInDateStart()));

      //El array de Contextos
      $contextos = array();
      foreach ($nextAction->getNextActionCriteriasDatas(new Context()) as $contexto) {
        $contextos[] = $contexto->getValue();  
      }
      
      if (is_object($fechas[0])) { 
        try {          
          $timestamp = strtotime($fechas[0]->getValue());
          $e->setProperty( 'dtstart',  date('Y', $timestamp) , date('m', $timestamp), date('d', $timestamp) , date('h', $timestamp), date('j', $timestamp), 00 );  // 24 dec 2006 19.30
        } catch (Exception $e) {

        }
      } 
      $e->setProperty( 'duration', 0, 0, 1 );                    // 3 hours
      if ($fechas[0] instanceof DueDate) {
        $e->setProperty( 'summary', 'PLAZO: '.$nextAction->getName());    // describe the event
      }
      if ($fechas[0] instanceof FollowUpDate) {
        $e->setProperty( 'summary', 'REVISAR: '.$nextAction->getName());    // describe the event
      }

      $e->setProperty( 'description', $nextAction->getName().'  '.$nextAction->getDescription() );    // describe the event
      $e->setProperty( 'location', implode(',',$contextos) );                     // locate the event - Context
      $v->addComponent( $e );                        // add component to calendar
    }
    echo str_replace(array("SFICALEVENT"),array("VEVENT"),$v->createCalendar());     
    /* alt. production */

    //$v->returnCalendar();                       // generate and redirect output to user browser

    return sfView::NONE;
  }
}

