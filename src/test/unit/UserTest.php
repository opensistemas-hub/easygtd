<?php
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');
 
$t = new lime_test(1);
$t->ok(Doctrine::getTable('User')->findAll()->count() > 0);




