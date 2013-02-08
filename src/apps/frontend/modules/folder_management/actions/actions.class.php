<?php

/**
 * folder_management actions.
 *
 * @package    EasyGtd
 * @subpackage folder_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class folder_managementActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->foldersPager = new sfDoctrinePager('Folder',sfConfig::get('app_PAGE_SIZE_FOLDER',2));
    $this->foldersPager->setQuery(
                                  Doctrine::getTable('Folder')
                                  ->createQuery('a')
                                  ->addWhere('a.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
                                  ->orderBy('a.name DESC')
                                  );
      
    $this->foldersPager->setPage($this->getRequestParameter('page',1));
    $this->foldersPager->init();
  }

  public function executeIndexAjax(sfWebRequest $request)
  {
    $this->setTemplate('indexAjax');
    $this->executeIndex($request);
  }
  
  public function executeNew(sfWebRequest $request)
  { 
    $folder = new Folder();
    $folder->setsfGuardUser($this->getUser()->getGuardUser());
    $this->form = new FolderForm($folder);    
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml'); 

    $this->forward404Unless($request->isMethod(sfRequest::POST));   
    $this->form = new FolderForm();

    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($folder = Doctrine::getTable('Folder')->find(array($request->getParameter('id'))), sprintf('Object folder does not exist (%s).', $request->getParameter('id')));
        
    try {
      if ($folder->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('this_stuff_is_not_yours_!');
      $this->form = new FolderForm($folder);
    } catch(Exception $e) {
     
    } 
    
  }

  public function executeUpdate(sfWebRequest $request)
  {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');
    $this->setTemplate('create');

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($folder = Doctrine::getTable('Folder')->find(array($request->getParameter('id'))), sprintf('Object folder does not exist (%s).', $request->getParameter('id')));        
    $this->form = new FolderForm($folder);

    try { 
      $this->processForm($request, $this->form);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }

  }

  public function executeDelete(sfWebRequest $request)
  {
   
    $this->forward404Unless($folder = Doctrine::getTable('Folder')->find(array($request->getParameter('id'))), sprintf('Object folder does not exist (%s).', $request->getParameter('id')));
    
    try {
      if ($folder->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId() ) throw new Exception('this_stuff_is_not_yours_!');
      $folder->delete();
    } catch(Exception $e) {

    }   
  }
  
  public function executeDelete_attachment(sfWebRequest $request)
  {
   
     $this->folderAttachments = Doctrine::getTable('FolderAttachment')
      ->createQuery('f')
      ->addWhere('f.Folder.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())
      ->addWhere('f.id = ?', $request->getParameter('id',-1))
      ->limit(1)
      ->execute();

     if ($this->folderAttachments->count() <> 1) {
         return sfView::ERROR;  
     }

     $this->folderAttachments->getFirst()->delete();
     return sfView::NONE;

  }
  
  
  

  protected function processForm(sfWebRequest $request, sfForm $form) 
  {  

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));       

    if ($form->isValid()) {                   
      $form->save();                 
    }  

  }
  
  public function executeMove_folder(sfWebRequest $request) {
    
    $parent = $request->getParameter('parent_id');
    $cut = $request->getParameter('children_id');
    
    if ($request->getMethod('post')) {
      
      $parent = Doctrine::getTable('Folder')->find($parent);
      $children = Doctrine::getTable('Folder')->find($cut);
      
      $children->getNode()->moveAsLastChildOf($parent);
      
    }
    
    return sfView::NONE;
    
  }
  
  
  public function executeCopy_folder(sfWebRequest $request) {
    
    $parent = $request->getParameter('parent_id');
    $cut = $request->getParameter('children_id');
    
    
    $folderParent = Doctrine::getTable('Folder')->find($cut);
    $parents = Doctrine::getTable('Folder')->find($parent);
    
    $descendants = $folderParent->getNode()->getDescendants();
    
    $size = $folderParent->getNode()->getNumberDescendants();
    
    $rootFolder = $this->newParentFolder($cut);
    
    if ($size > 0 ) {
    
    
      foreach ($descendants as $row) {
      
        $this->createChildrens($row->getId(),$rootFolder->getId());
              
      }
      
    } else {
      
        //DO NOTHING
      
    }
    
    $folderChild = Doctrine::getTable('Folder')->find($rootFolder->getId());

    $folderChild->getNode()->moveAsLastChildOf($parents);
     

    
    return sfView::NONE;
  
  
  }
  
  

  
  /*
    @param $id > id from folder to copy
  */
  private function newParentFolder($id) {
    
    $folderObj = Doctrine::getTable('Folder')->find($id);
    
    //create new folder with the params of primary folder
    
    $folderNew = new Folder();
    $folderNew->setName($folderObj->getName());
    $folderNew->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
    $folderNew->setLft($folderObj->getLft());
    $folderNew->setRgt($folderObj->getRgt());
    $folderNew->setLevel($folderObj->getLevel());
    $folderNew->save();
    
    //NEW ROOT ID WITH SAME ID OF NEW FOLDER
    
    $folder = $folderNew;
    $folder->setRootId($folderNew->getId());
    $folder->save();
    $folder = null;
    
    //GET ALL ATTACHMENT ON THE FOLDER

    foreach ($folderObj->getFolderAttachments() as $att) {
      
      $attach = new FolderAttachment();
      $attach->setValue($att->getValue());
      $attach->setFolder($folderNew);
      $attach->save();
      $attach = null;
    
    }
    
    foreach ($folderObj->getFolderNoActionables() as $action)  {

      $act = new NoActionableItem();
      $act->setName($action->getNoActionableItem()->getName());
      $act->setDescription($action->getNoActionableItem()->getDescription());
      $act->setType('REFERENCE');
      $act->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $act->save();
      
      $noActionableFolder = new NoActionableItemFolder();
      $noActionableFolder->setNoActionableItem($act);
      $noActionableFolder->setFolder($folderNew);
      $noActionableFolder->save();
      $noActionableFolder = null;
    
    }
    
    
    return $folderNew;
    
    
  
  
  }
  
  
  private function createChildrens($id,$parent) {
  
   $folderObj = Doctrine::getTable('Folder')->find($id);
    
    //create new folder with the params of primary folder
    
    $folderNew = new Folder();
    $folderNew->setName($folderObj->getName());
    $folderNew->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
    $folderNew->setLft($folderObj->getLft());
    $folderNew->setRgt($folderObj->getRgt());
    $folderNew->setLevel($folderObj->getLevel());
    $folderNew->save();
    
    //NEW ROOT ID WITH SAME ID OF PARENT
    
    $folder = $folderNew;
    $folder->setRootId($parent);
    $folder->save();
    $folder = null;
    
    //GET ALL ATTACHMENT ON THE FOLDER

    foreach ($folderObj->getFolderAttachments() as $att) {
      
      $attach = new FolderAttachment();
      $attach->setValue($att->getValue());
      $attach->setFolder($folderNew);
      $attach->save();
      $attach = null;
    
    }
    
    foreach ($folderObj->getFolderNoActionables() as $action)  {

      $act = new NoActionableItem();
      $act->setName($action->getNoActionableItem()->getName());
      $act->setDescription($action->getNoActionableItem()->getDescription());
      $act->setType('REFERENCE');
      $act->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $act->save();
      
      $noActionableFolder = new NoActionableItemFolder();
      $noActionableFolder->setNoActionableItem($act);
      $noActionableFolder->setFolder($folderNew);
      $noActionableFolder->save();
      $noActionableFolder = null;
    
    }
    
    

    
    
  
  
  
  }
  
  
  
  public function executeAjax_process(sfWebRequest $request) {
    
    //ADD NEW FOLDER >> IF EXIST LAUNCH ERROR 404 AND CATCH WITH AJAX
    try {
    
    
    
   

    if ($request->getParameter('object-kind') == 0) {

        $folderObject = Doctrine_Query::create()->from('Folder f')->where('f.name =?',$request->getParameter('folder-name'))->addWhere('f.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
    
    if (is_object($folderObject)) throw new Exception('Folder already exist');


        $folderObj = new Folder();
        $folderObj->setName($request->getParameter('folder-name'));
        $folderObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() 
    ));
        $folderObj->save();
        $treeObject = Doctrine::getTable('Folder')->getTree();
        $treeObject->createRoot($folderObj);
    
    
    }
    
    if ($request->getParameter('object-kind') == 1) {
        
        if ($request->getParameter('object-type') == 'action') throw new Exception ('You cannot add sub on reference');
        
        $objectFolder = Doctrine::getTable('Folder')->find($request->getParameter('object-id'));
        
        $folderObj = new Folder();
        $folderObj->setName($request->getParameter('folder-name'));
        $folderObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId() 
    ));
        $folderObj->save();
        $folderObj->getNode()->insertAsLastChildOf($objectFolder);
        
        $objectFolder = null;
        
    }
    
    if ($request->getParameter('object-kind') == 2) {
        
        $objectFolder = Doctrine::getTable('Folder')->find($request->getParameter('object-id'));
        
        $noActionableObj = new NoActionableItem();
        $noActionableObj->setName($request->getParameter('folder-name'));
        $noActionableObj->setType('REFERENCE');
        $noActionableObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
        $noActionableObj->save();
        
        $relationObj = new NoActionableItemFolder();
        $relationObj->setFolder($objectFolder);
        $relationObj->setNoActionableItem($noActionableObj);
        $relationObj->save();
        
        
    
    }
    
    
    
    
    return sfView::NONE;
    
    
    
    } catch (Exception $e) {
    
          $this->forward404();
    
    }
    //END ADD NEW FOLDER
     
      
    return sfView::NONE;    
  }
    
  private function loadMessages(){
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }
  
}
