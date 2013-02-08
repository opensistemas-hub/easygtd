<?php
abstract class Authenticator{
    abstract function authenticate(sfWebRequest $request, myUser $user);
}
