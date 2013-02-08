<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://easygtd.localhost/");
  }

  function testLogin()
  {
    $this->open("/");
    $this->click("link=ingresa aquí");
    $this->waitForPageToLoad(30000);
    $this->type("signin_username", "fmonera@opensistemas.com");
    $this->type("signin_password", ".user.");
    $this->click("//input[@value='Entrar']");
    $this->waitForPageToLoad(30000);
    $this->assertTrue($this->isTextPresent("Bienvenido fmonera@opensistemas.com"));
  }
}
?>