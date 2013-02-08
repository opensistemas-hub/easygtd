<?php
class DoctrineAuthenticator extends Authenticator{
    public function authenticate(sfWebRequest $request, myUser $user){
    


        $q = Doctrine_Query::create();
        $q->from('User user');
        $q->where('user.email = ? and user.password = ?', array($request->getParameter('email'),md5($request->getParameter('password'))));
        $q->limit(1);

        $users = $q->execute();

       if($users->count() <> 1){
            $user->setAuthenticated(false);
     	    return $user;
        } 
        
        $user->setAuthenticated(true);
           
        return $user;

    }
}
