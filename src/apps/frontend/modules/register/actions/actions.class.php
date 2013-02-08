<?php

/**
 * register actions.
 *
 * @package    EasyGtd
 * @subpackage register
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request){
    $this->form = new RegisterForm();
    
    
    $invitation = CheckInvitation::getInstance()->checkHash($request->getParameter('hash'), sfConfig::get('app_INVITE_SYSTEM'));

    if ($invitation) {
    
    try {
    $this->hash_return = $request->getParameter('hash');
    if ( $request->getMethod() == sfRequest::POST )
      {
      
        $this->form->bind($request->getParameter('sf_guard_user'));
        
          if ( $this->form->isValid() ) {
                    
              $this->form->save();
              $this->getUser()->signIn($this->form->getObject());
              
              $invitation = Doctrine_Query::create()->from('InviteAFriend i')->where('i.hash=?',$request->getParameter('hash'))->execute()->getFirst();
              $invitation->setStatus(1);
              $invitation->save();
              $invitation = null;
              
              $this->redirect('@homepage');
 
            } else {
            
              $this->forward404();

            
            }
      }
    } catch(Exception $e) {
      
    }
    
    } else {
    // invitation required
    
    $this->setTemplate('invitation_required');
    
    }
    
    }
}
