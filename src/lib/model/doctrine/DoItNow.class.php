<?php

/**
 * DoItNow
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class DoItNow extends BaseDoItNow
{

    public function  getMessage() {
        return "done_now_-_take_less_than_2_minutes";
    }
    public function getDiscriminator(){
        return "DO_IT_NOW";
    }
}