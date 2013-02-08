<?php

/**
 * home actions.
 *
 * @package    EasyGtd
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  $this->places = array(
                  'menu'=>array(
                                'name'=>'Access',
                                'url'=>null
                                )
                );
  if ($this->getUser()->isAuthenticated()) {  
    //LOAD "NONE" CRITERIAS FOR EACH USER && INDEX_SEARCH VALUES
    LoadDefaultData::getInstance()->loadDefaultCriteria($this->getUser()->getGuardUser()->getId(),$this->getUser()->getCulture());
    LoadDefaultData::getInstance()->loadDefaultFolder($this->getUser()->getGuardUser());
  } 
  $this->user = $this->getUser();          
  }
  
  public function executeAccount(){

  }

  public function executeShow_register(sfWebRequest $request){
    $this->form = new UserRegisterForm();
    $this->setTemplate('user_register');
  }
  
  public function executeSave_register(sfWebRequest $request){
    
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form=  new UserRegisterForm();
    $this->processFormRegister($request, $this->form);
  
  }
  
  protected function processFormRegister(sfWebRequest $request, sfForm $form)
  {
  
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    
    try{

        if(!is_null($this->form->getValue('email'))){
        $q = Doctrine::getTable('User')->findByEmail($this->form->getValue('email'));
        if(count($q) > 0) throw new Exception('This email already exist');
        }
    } catch (Exception $e){
      
      $error = new sfValidatorError(new sfValidatorPass(), $e->getMessage());
      $errorSchema = new sfValidatorErrorSchema(new sfValidatorPass(), array('name' => $error));
      $form->getErrorSchema()->addError($errorSchema);
    
    }
    if ($form->isValid())
    {
     try{
          
         
          $user = new User();
          $user->setName($this->form->getValue('name'));
          $user->setEmail($this->form->getValue('email'));
          $user->setPassword(md5($this->form->getValue('password')));
          $user->save();
          
          
          $this->getUser()->setAuthenticated(true);  
          $this->getUser()->setAttribute('id',$user->getId());
          $this->getUser()->setAttribute('name',$user->getName());
          $this->getUser()->setAttribute('email',$user->getEmail()); 
      
          
                              
          Mensajes::getInstance()->agregarExito('the_user_has_been_created');
          $this->loadMessages();
          $this->redirect('home/index');
     
     } catch (Exception $e){
        
        $this->redirect('home/user_register');    
     }
    }
    $this->setTemplate('user_register');
  
  }

  public function executeShow_login(sfWebRequest $request){
      $this->form = new loginForm();   
      

      $this->setTemplate('login');
  }

  public function executeLogin(sfWebRequest $request){

      //a search a user with a email filter for get a specific user

      $authenticates = new DoctrineAuthenticator();
      if($request->isMethod('post')){
          
          $user = Doctrine_Query::create()->from('User u')->where('u.email=?',$request->getParameter('email'))->addWhere('u.password=?',md5($request->getParameter('password')))->execute()->getFirst();
          
          
         try{
            if (!($user instanceof User)) throw new Exception('username_or_password_is_incorrect');
           $logon = $authenticates->authenticate($request, $this->getUser());
           $this->getUser()->setAttribute('id',$user->getId());
           $this->getUser()->setAttribute('name',$user->getName());
           $this->getUser()->setAttribute('email',$user->getEmail()); 
           //Usuario autenticado
           
           $this->redirect('@localized_homepage');

            } catch (Exception $e) {
              Mensajes::getInstance()->agregarError($e->getMessage());
              $this->loadMessages();
              $this->redirect('home/show_login');
            }


         }
      

    $this->redirect('home/show_login');        
  }

  public function executeLogout(sfWebRequest $request){


       
	$this->getUser()->setAttribute('name','');
	$this->getUser()->setAttribute('email','');
        $this->getUser()->setAttribute('id','');
        $this->getUser()->setAuthenticated(false);

    	$this->redirect('home/show_login');
 	
  }
  
  public function executeHelper(sfWebRequest $request) {
    
    $this->code = $request->getParameter('id');
    
        
  }
  
  public function executeStatic_content(sfWebRequest $request) {
    
    //THIS ACTION HAVE STATIC CONTENT
    $this->page = $request->getParameter('view');
    $this->setTemplate('static_content');
    
    //RENDER EXAMPLE UPLOAD FILE TO STUFFS
    $this->example = null;
    
    if ($request->getParameter('file')) {
    
      $file = sfConfig::get('sf_app_module_dir').'/home/content_static/'.$request->getParameter('file');
      // Adding the file to the Response object
      $this->getResponse()->clearHttpHeaders();
      $this->getResponse()->setHttpHeader('Pragma: public', true);
      $this->getResponse()->setContentType(MimeContent::mime_content_type($file));
      $this->getResponse()->sendHttpHeaders();
      $this->getResponse()->setContent(readfile($file));

      return sfView::NONE;
    
    }
  
  }
    
  public function executeTester(sfWebRequest $request) {
      
#    $this->getResponse()->addHttpMeta('cache-control', 'no-cache,must-revalidate');
#        $this->getResponse()->addHttpMeta('expires', '0');
  }
  
  public function executeRemaining(sfWebRequest $request) {
    //CARGA CONTENIDO DE CUANTOS ELEMENTOS QUEDAN EN EL INBOX
    $this->actions = Doctrine_Query::create()->from('Stuff s')->where('s.User.id=?',$this->getUser()->getAttribute('id'))->addWhere('s.StuffState.id=?',1)->execute();
  
  }
    
  private function loadMessages(){
    //Load the meesages singleton into flash
    $this->getUser()->setFlash('mensajes',Mensajes::getInstance());
  }
 
  
  
}
