<?php

/**
 * FollowUpTime
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class FollowUpTime extends BaseFollowUpTime
{
   public function __toString() {
    return "Follow up time";
   }
   public function getDiscriminator(){
      return "FOLLOW_UP_TIME";
   }
}
