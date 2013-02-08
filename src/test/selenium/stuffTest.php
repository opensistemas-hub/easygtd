<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of stuffTest
 *
 * @author monera
 */
class stuffTest extends PHPUnit_Extensions_SeleniumTestCase {
    
    function setUp() {
        $this->setBrowser("*chrome");
        $this->setBrowserUrl("http://easygtd.localhost/");
    }

    function login()
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

    function testAddAndEdit() {
      $this->login();
      
      $this->click("capturing");

      // Quick add stuff
      for ($second = 0; ; $second++) { // Esperamos a que se abra el popup
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("name_fast")) break;
        } catch (Exception $e) {}
        sleep(1);
      }

      // Verificamos que no hay nada anterior
      $this->assertFalse($this->isTextPresent("Cosa de ejemplo"));
      $this->assertFalse($this->isTextPresent("Segunda cosa de ejemplo"));

      // Quick add stuff
      for ($second = 0; ; $second++) { // Esperamos a que se abra el popup
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("name_fast")) break;
        } catch (Exception $e) {}
        sleep(1);
      }
      sleep(2);
      $this->type("name_fast", "Cosa de ejemplo");
      $this->click("submit");
      sleep(3);
      $this->assertTrue($this->isTextPresent("Cosa de ejemplo"));

      // Normal add stuff
      $this->click("link=Agrega cosa");
      for ($second = 0; ; $second++) { // Esperamos a que se abra el popup
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("name")) break;
        } catch (Exception $e) {}
        sleep(1);
      }

      for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("description_field")) break;
        } catch (Exception $e) {}
        sleep(1);
      }
      $this->type("name", "Segunda cosa de ejemplo");
      $this->type("description_field", "Descripción de la segunda cosa de ejemplo");
      $this->click("put_inbox");
      $this->click("fancybox-close");
      for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isTextPresent("Segunda cosa de ejemplo")) break;
        } catch (Exception $e) {}
        sleep(1);
      }

      // Modify stuff
      $this->click("link=Cosa de ejemplo");
      for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("put_inbox")) break;
        } catch (Exception $e) {}
        sleep(1);
      }

      $this->type("name", "Cosa de ejemplo cambiada");
      $this->click("put_inbox");
      $this->click("fancybox-close");
      sleep(4);
      $this->assertTrue($this->isElementPresent("link=Cosa de ejemplo cambiada"));
    }
}
?>