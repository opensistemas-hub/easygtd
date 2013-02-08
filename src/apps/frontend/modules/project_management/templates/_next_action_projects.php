
<?php if(!is_null($nextActionProjects)){?>

<li id="list_next_action_project" style="padding:5px; margin-left:70px;">
  <ul class="float-left">
      <?php foreach ($nextActionProjects as $nextActionProject) { ?>

                    <li id="next_action_project_<?php echo $nextActionProject->getId(); ?>">
                         <?php

                           echo image_tag('icons/+.gif',array('class'=>'', 'alt' => ''));
                           echo $nextActionProject->getNextAction()->getName();
                          ?>    
                     </li>

     <?php } ?>
  </ul> 
  <div class="clear"></div>
</li>
 <?php } ?>
