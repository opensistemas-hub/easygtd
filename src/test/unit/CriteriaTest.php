<?php
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');
 
$t = new lime_test(1);
$t->ok(Doctrine::getTable('Criteria')->findAll()->count() > 0);




