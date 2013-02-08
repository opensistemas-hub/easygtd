<?php foreach($criterias as $nextActionCriteria){  ?>   
  <?php if (strlen($nextActionCriteria->getCriteria()->getValue()) > 0) { ?> 
    <?php if ($nextActionCriteria->getCriteria()->getType() != 'CONTEXT') { ?> 
      <li <?php echo 'title="'.__($nextActionCriteria->getCriteria()->getType()).': '.__($nextActionCriteria->getCriteria()->getValue()).'"'; ?>>
        <?php 
              switch ($nextActionCriteria->getCriteria()->getType()) {  
 
                case 'TIME_AVAILABLE':
                     echo image_tag('icons/clock.gif');
                     break;

                case 'ENERGY':
                     echo image_tag('icons/energy.gif');
                     break;

                case 'PRIORITY':
                     echo image_tag('icons/priority1.gif');
                     break;

              }

              echo '<span>' ; 
              echo __($nextActionCriteria->getCriteria()->getValue()) ;
              echo '</span>';

        ?>     
      </li>                           
    <?php } ?>
  <?php } ?>
<?php } ?>
