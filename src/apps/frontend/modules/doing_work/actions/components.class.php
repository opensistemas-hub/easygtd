<?php
class doing_workComponents extends sfComponents
{

   public function executeShow_projects_with_actions(){
     $this->actions = Doctrine_Query::create()->from('NextAction n')->where('n.NextActionProjects.Project.id = ?', $this->project->getId())->addWhere('n.NextActionState.type <> ?','DONE')->addWhere('n.NextActionCriterias.Criteria.id IN ('.implode(",",$this->criterias).')' )->groupBy('n.id')->having('COUNT(n.NextActionCriterias.Criteria.id) = '.count($this->criterias))->execute();
   }
   
   public function executeView_context_from_action() {
   
    $action = $this->action;
    
    $this->criterias = Doctrine_Query::create()->from('NextActionCriteria nc')->where('nc.NextAction.id=?',$action)->addWhere('nc.Criteria.type=?','CONTEXT')->execute();
    $this->actionId = $this->action;
   
   }
   
   public function executeView_information() {   
     $this->informations = Doctrine_Query::create()->from('NextActionInfo info')->where('info.NextAction.id = ?', $this->action->getId())->execute();
   }
   
   public function executeView_project_on_action() {
     try {
       $nextActionProjects = $this->action->getNextActionProjects();
       if ($nextActionProjects->count() < 1) throw new Exception(); 
       $this->project = $nextActionProjects->getFirst();
     } catch (Exception $e) {
       return sfView::NONE;
     }
   }
   
   public function executeView_criterias() {
   
    $this->contextCriterias = Doctrine_Query::create()->from('Context c')->where('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();
    $this->timeCriterias = Doctrine_Query::create()->from('Criteria c')->where('c.type = ?','TIME_AVAILABLE')->andWhere('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();
    $this->energyCriterias = Doctrine_Query::create()->from('Criteria c')->where('c.type = ?','ENERGY')->andWhere('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();
    $this->priorityCriterias = Doctrine_Query::create()->from('Criteria c')->where('c.type = ?','PRIORITY')->andWhere('c.sfGuardUser.id = ?', $this->getUser()->getGuardUser()->getId())->execute();
    $this->typeNextActions = array(new Delegated(),new DoASAP(),new Scheduled(),new DoItNow());
    //retorno session actual


   }

}
