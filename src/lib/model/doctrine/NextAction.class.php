<?php

/**
 * NextAction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EasyGtd
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class NextAction extends BaseNextAction
{
  public function getAttachments() {
    return $this->getNextActionAttachments();
  }

  public function getNextActionDatas(NextActionInfo $type){
    $datas = array();
    foreach ($this->getInformations() as $info){
      if (strcmp(get_class($info),get_class($type)) == 0) {
        $datas[] = $info;
      }
    }
    return $datas;
  }

 //NextActionCriterias
  public function getNextActionCriteriasDatas(Criteria $type){
    $datas = array();
    foreach ($this->getNextActionCriterias() as $info){
      if (strcmp(get_class($info->getCriteria()),get_class($type)) == 0) {
        $datas[] = $info->getCriteria();
      }
    }
    return $datas;
  }

}
