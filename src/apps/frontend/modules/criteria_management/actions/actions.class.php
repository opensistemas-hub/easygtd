<?php

/**
 * criteria_management actions.
 *
 * @package    EasyGtd
 * @subpackage criteria_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class criteria_managementActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

    $this->nextActionCriterias = Doctrine_Query::create()->from('Criteria c')->addWhere('c.CriteriaNextActions.id  = c.id')->addWhere('c.sfGuardUser.id = ?',$this->getUser()->getGuardUser()->getId())->execute();
   
    //returns all of the criteria for a specific user
    $this->AllCriteria = Doctrine_Query::create()->from('Criteria c')->addWhere('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();

    $this->selections = array(new Energy(),new Context(),new TimeAvailable(), new Priority());
    $this->criteriasPager = new sfDoctrinePager('Criteria',sfConfig::get('app_PAGE_SIZE_CRITERIA',2));
  
    $this->filter = $request->getParameter('filter','-1');

    if($this->filter != -1){
      //added the criteria in the query sql for searching with the filter name
      $this->criteriasPager->setQuery(
              Doctrine::getTable('Criteria')
              ->createQuery('c')
              ->where("c.type = ?  ", $this->filter)
              ->innerJoin('c.sfGuardUser u WITH u.id = ?', $this->getUser()->getGuardUser()->getId())
      );
      //else build a normal query
   } else {
        $this->criteriasPager->setQuery(
              Doctrine::getTable('Criteria')
              ->createQuery('c')
              ->innerJoin('c.sfGuardUser u WITH u.id = ?', $this->getUser()->getGuardUser()->getId())
                );
   }


      
     
    $this->criteriasPager->setPage($this->getRequestParameter('page',1));
    $this->criteriasPager->init();
  }
  
  public function executeAjax_list(sfWebRequest $request) {
    $this->nextActionCriterias = Doctrine_Query::create()->from('Criteria c')->addWhere('c.CriteriaNextActions.id  = c.id')->addWhere('c.sfGuardUser.id = ?',$this->getUser()->getGuardUser()->getId())->execute();
   
    //returns all of the criteria for a specific user
    $this->AllCriteria = Doctrine_Query::create()->from('Criteria c')->addWhere('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();

    $this->selections = array(new Energy(),new Context(),new TimeAvailable(), new Priority());
    $this->criteriasPager = new sfDoctrinePager('Criteria',sfConfig::get('app_PAGE_SIZE_CRITERIA',2));
  
    $this->filter = $request->getParameter('filter','-1');

    if($this->filter != -1){
      //added the criteria in the query sql for searching with the filter name
      $this->criteriasPager->setQuery(
              Doctrine::getTable('Criteria')
              ->createQuery('c')
              ->where("c.type = ?  ", $this->filter)
              ->innerJoin('c.sfGuardUser u WITH u.id = ?', $this->getUser()->getGuardUser()->getId())
      );
      //else build a normal query
   } else {
        $this->criteriasPager->setQuery(
              Doctrine::getTable('Criteria')
              ->createQuery('c')
              ->innerJoin('c.sfGuardUser u WITH u.id = ?', $this->getUser()->getGuardUser()->getId())
                );
   }

    $this->criteriasPager->setPage($this->getRequestParameter('page',1));
    $this->criteriasPager->init();
  }

  public function executeNew(sfWebRequest $request)
  {

     $this->filter = $request->getParameter('filter','-1');

     $criteria = new Criteria();
     $criteria->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
     $this->form = new CriteriaForm($criteria);

     $this->setLayout(false);  
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CriteriaForm();
    
    $this->filter = $request->getParameter('filter','-1');
    
    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeEdit(sfWebRequest $request)
  {

    $this->filter = $request->getParameter('filter','-1');

    $this->forward404Unless($criteria = Doctrine::getTable('Criteria')->find(array($request->getParameter('id'))), sprintf('Object criteria does not exist (%s).', $request->getParameter('id')));
    
    if ($criteria->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('not_yours_!');

    $this->form = new CriteriaForm($criteria);

    $this->setLayout(false);
  }

  public function executeUpdate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  
    $this->setTemplate('create');

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($criteria = Doctrine::getTable('Criteria')->find(array($request->getParameter('id'))), sprintf('Object criteria does not exist (%s).', $request->getParameter('id')));
    $this->form = new CriteriaForm($criteria);

    if ($criteria->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('not_yours_!');
    
    $this->filter = $request->getParameter('filter','-1');
    
    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeDelete(sfWebRequest $request)
  {

    $this->forward404Unless($criteria = Doctrine::getTable('Criteria')->find(array($request->getParameter('id'))), sprintf('Object criteria does not exist (%s).', $request->getParameter('id')));

    if ($criteria->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('not_yours_!');

    $criteria->delete();


  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      
    if ($form->isValid())
    {
      //Antes de guardar necesito saber si existe un Criterio con el mismo nombre, para ello obtengo todos los criterios del tipo que tengan el mismo nombre
      $criterias = Doctrine_Query::create()->from('Criteria c')->where('c.type = ?',$this->form->getValue('type'))->addWhere('c.value = ?',$this->form->getValue('value'))->addWhere('c.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();      
      if ($criterias->count() > 0) {
        //Veo si estoy editando o no, si estoy editando tengo que ver que no sea el mismo objeto.
        if (!$form->getObject()->isNew()){ 
          //Estoy editando, veo si los objetos que están en $criterias son distintos al objeto.
          foreach ($criterias as $criteria) {
            //Si uno de los objetos coincidentes 
            if ($criteria->getId() <> $form->getObject()->getId()) throw new Exception('criteria_already_exists');
          }          
        } else {
          //En ningun caso puedo agregarlo.
          throw new Exception('criteria_already_exists');
        }
      }
      $criteria = $form->save();      
    }

  }
  
  public function executeChange_criteria(sfWebRequest $request){
  
    $this->criterias = Doctrine_Query::create()->from('Criteria c')->where('c.type = ?',$request->getParameter('type'))->addWhere('c.id <> ?',$request->getParameter('id'))->addWhere('c.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();

    $this->info = Doctrine::getTable('Criteria')->find($request->getParameter('id'));

    if ($this->info->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('this_stuff_is_not_yours_!');

    if ($this->criterias->count() < 1) throw new Exception('not_criterias_!');    
  
  }
  
  public function executeSave_change_criteria(sfWebRequest $request){
  
    $this->forward404Unless($this->found = Doctrine_Query::create()->from('NextActionCriteria na')->where('na.Criteria.id=?',$request->getParameter('criteria_id'))->addWhere('na.NextAction.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute());
    
    $update = Doctrine_Query::create()
              ->update('NextActionCriteria')
              ->set('criteria_id','?',$request->getParameter('new_criteria_id'))
              ->where('criteria_id = ?',$request->getParameter('criteria_id'))
              ->addWhere('criteria_id NOT IN (?)',$request->getParameter('new_criteria_id'));
    $update->execute();
    $update = null;
    
    
    
    $delete = Doctrine_Query::create()
              ->delete('Criteria nc')
              ->where('nc.id = ?',$request->getParameter('criteria_id'))
              ->execute();

    $delete = null;        
    
    $this->redirect('criteria_management/index');
  
  }

  public function executeDummy(sfWebRequest $request)
  {
    return sfView::NONE;
  }
  
   private function loadMessages(){
    //Load the meesages singleton into flash
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }
}
