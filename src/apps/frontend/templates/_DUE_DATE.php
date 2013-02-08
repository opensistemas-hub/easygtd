<?php try {
        if (strlen($value) > 0) { 
          echo '<li title="'.$value.'">';
          echo image_tag('icons/agenda.gif');
          echo format_date($value,$sf_user->getGuardUser()->getFormatDate()); 
          echo '</li>';
        }
      } catch (Exception $e) { 

      }?>
