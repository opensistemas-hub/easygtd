<?php

/**
 * user_management actions.
 *
 * @package    EasyGtd
 * @subpackage user_management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class user_managementActions extends sfActions
{

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
     
    $emailsToInbox = Doctrine_Query::create()->from('EmailToInbox e')->where('e.user_id = ?',$this->getUser()->getGuardUser()->getId())->execute()->getFirst();
    $this->usernameEmailToInbox = '';
    try {
      if (!($emailsToInbox instanceof EmailToInbox)) throw new Exception();
      $this->usernameEmailToInbox =  preg_replace('/([^@]*).*/', '$1', $emailsToInbox->getValue());
    } catch (Exception $e) {
      //DO NOTHING
    }

  }

  public function executeUpdate(sfWebRequest $request)
  { 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($user = Doctrine::getTable('SfGuardUser')->find(array($this->getUser()->getGuardUser()->getId())), sprintf('Object user does not exist (%s).', $this->getUser()->getGuardUser()->getId()));
    $this->form = new RegisterForm($user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
      
    $form->bind($request->getParameter('sf_guard_user'));
    
    if ($form->isValid())
    {
      
      $this->form->save();
      
    }
  }
  
 public function executeAlerts(sfWebRequest $request) {

  $this->email = $this->getUser()->getGuardUser()->getUsername() ;
  $this->form = new AlertForm();
  
  $this->datas = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
  
   
    
 }
 
 public function executeProcess_alert(sfWebRequest $request) {
    $this->form = new AlertForm();
    $this->email = $this->getUser()->getGuardUser()->getId() ;
    $this->datas = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
    $this->processAlertForm($request, $this->form);

    $this->setTemplate('alerts');
 }
 
protected function processAlertForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        
    if ($form->isValid() ) {
      
      #email item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','EMAIL_ITEM')->execute()->getFirst();
      
      $emailType = new EmailItem();
      $alertItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $alertItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $alertItem->setType($emailType->getDiscriminator());
      $alertItem->setValue($this->form->getValue('email'));
      $alertItem->save();
      $alertType = null;
      $alertItem = null; 
      $query = null;
      #end email item
      
#      #someday item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','SOME_DAY_MAYBE_ITEM')->execute()->getFirst();
      
      $someType = new SomeDayMaybeItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue(($request->getParameter('someday_type'))?1:0);
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin someday item

#      #ScheludedItem item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','SCHELUDED_ITEM')->execute()->getFirst();
      
      $someType = new ScheludedItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue(($request->getParameter('scheluded_type'))?1:0);
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin ScheludedItem item

#      #DelegateItem item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','DELEGATE_ITEM')->execute()->getFirst();
      
      $someType = new DelegateItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue(($request->getParameter('delegated_type'))?1:0);
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin DelegateItem item

#      #DelegateItem item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','DELEGATE_ITEM')->execute()->getFirst();
      
      $someType = new DelegateItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue(($request->getParameter('delegated_type'))?1:0);
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin DelegateItem item

#      #DoAsap item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','DO_ASAP_ITEM')->execute()->getFirst();
      
      $someType = new DoAsapItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue(($request->getParameter('doasap_type'))?1:0);
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin DoAsap item

#      #DayScheluded item
      $query = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('ac.type=?','DAY_SCHELUDED_ITEM')->execute()->getFirst();
      
      $someType = new DayScheludedItem();
      $someItem = ($query instanceof AlertConfiguration)?$query:new AlertConfiguration();
      $someItem->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
      $someItem->setType($someType->getDiscriminator());
      $someItem->setValue($request->getParameter('time-remember'));
      $someItem->save();
      $someType = null;
      $someItem = null; 
      $query = null;
#      #fin DayScheluded item
 
      $this->getUser()->setFlash('mensajes','alert_configurated');
    
    
    }
    $this->redirect('user_management/alerts');

}
 //TODO -- NOT ENABLED YET
 public function executeMy_bookmark(SfWebRequest $request) {
  $this->bookmarks = Doctrine_Query::create()->from('Bookmark b')->where('b.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->execute();
 }
 
 public function executeAdd_to_my_bookmark(sfWebRequest $request) {
 
  $id = $request->getParameter('action_id');
  $type = $request->getParameter('type_id');
  $name = $request->getParameter('name');
 
  
  $query = Doctrine_Query::create()->from('Bookmark b')->where('b.sfGuardUser.id=?',$this->getUser()->getGuardUser()->getId())->addWhere('b.type=?',$type)->addWhere('b.item_id=?',$id)->execute();
    
    if ($query->count() == 0) {

    
    $bookObj = new Bookmark();
    $bookObj->setType($type);
    $bookObj->setItemId($id);
    $bookObj->setValue($name);
    $bookObj->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId()));
    $bookObj->save();
    $bookObj = null;
}
   
   return sfView::NONE;
  
 }
  
  public function executeEdit_user(sfWebRequest $request) {

    $this->setLayout(false);
    $this->getResponse()->setContentType('text/xml');  

    try { 
      $user = Doctrine::getTable('SfGuardUser')->find($this->getUser()->getGuardUser()->getId());  
      //La contraseña
      if ( $request->getMethod('post') ) {
        if ( $user instanceof sfGuardUser ) {
          $user->setPassword($request->getParameter('password'));
          $user->setFormatDate($request->getParameter('format_date'));
          $user->save();  
        }
      }
      //El email para inbox
      //Que sea único
      $query = Doctrine_Query::create()->from('EmailToInbox e')->where('e.value = ?',$request->getParameter('inbox_email').'@inbox.easygtd.com')->execute();
      if ($query->count() > 0) {
        if ($query->getFirst()->getSfGuardUser()->getId() <> $this->getUser()->getGuardUser()->getId()) throw new Exception("this_email_cannot_be_used");
      }
      //Si es único.
      //Borro primero
      $user->getEmailsToInbox()->delete();
      $emailToUser = new EmailToInbox();
      $emailToUser->setValue($request->getParameter('inbox_email').'@inbox.easygtd.com');
      $emailToUser->setSfGuardUser($user);
      $emailToUser->save();
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return sfView::ERROR;
    }
  } 

 
}
