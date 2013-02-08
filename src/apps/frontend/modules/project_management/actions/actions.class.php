<?php

/**
 * project_management actions.
 *
 * @package    EasyGtd
 * @subpackage project_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class project_managementActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->projectsPager = new sfDoctrinePager('Project',sfConfig::get('app_PAGE_SIZE_PROJECT',2));
    $this->projectsPager->setQuery(
                                  Doctrine::getTable('Project')
                                  ->createQuery('a')
                                  ->addWhere('a.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->orderBy('a.name DESC')
                                  );

    $this->projectsPager->setPage($this->getRequestParameter('page',1));
    $this->projectsPager->init();


    $this->projectState = Doctrine_Query::create()
                          ->select('*')
                          ->from('ProjectState')
                          ->execute();

    $this->noProjectNextActions = Doctrine_Query::create()
                                  ->select('*')
                                  ->from('NextAction na')
                                  ->addWhere('na.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->addWhere('na.id NOT IN (SELECT nap.next_action_id FROM NextActionProject nap WHERE nap.Project.user_id = ? )', $this->getUser()->getGuardUser()->getId())->execute();    
  }

  public function executeShow_projects_in_combobox(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->projects  = Doctrine::getTable('Project')
                                  ->createQuery('a')
                                  ->addWhere('a.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->orderBy('a.name DESC')
                                  ->execute();
    //El último proyecto agregado
    $this->projectsValue =  Doctrine::getTable('Project')
                                  ->createQuery('a')
                                  ->addWhere('a.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->orderBy('a.created_at DESC')
                                  ->execute()->getFirst();

  }

  public function executeIndex_ajax(sfWebRequest $request){
    $this->executeIndex($request);
  }


  public function executeProject_actions_list(sfWebRequest $request){
   //Si el request de proyecto es -1 entonces son las acciones sin proyecto:
   if ($request->getParameter('project_id',-1) == -1) {
     $this->nextActions = Doctrine_Query::create()
                                  ->select('*')
                                  ->from('NextAction na')
                                  ->addWhere('na.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->addWhere('na.id NOT IN (SELECT nap.next_action_id FROM NextActionProject nap WHERE nap.Project.user_id = ? )', $this->getUser()->getGuardUser()->getId())->execute();    
   } else { 
     $this->nextActions = Doctrine_Query::create()
                                  ->select('*')
                                  ->from('NextAction na')
                                  ->addWhere('na.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->addWhere('na.id IN (SELECT nap.next_action_id FROM NextActionProject nap WHERE nap.Project.id = ? )', $request->getParameter('project_id',-1))->execute();    
     }
  }

  public function executeNew(sfWebRequest $request)
  {
    $project = new Project();
    $project->setsfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
    $project->setProjectStateId(1);

    $this->form = new ProjectForm($project);
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml'); 

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ProjectForm();

    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectForm($project);
  }

  public function executeUpdate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml'); 
    $this->setTemplate('create');

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectForm($project);

    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }
    
  }

  public function executeDelete(sfWebRequest $request)
  {

    $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
    $project->delete();

    $this->redirect('project_management/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
   
    if ($form->isValid())
    {
     $project = $form->save();
    }
  }

}
