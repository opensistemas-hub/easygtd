<?php try {
        if (strlen($value) > 0) { 
          echo '<li title="'.$value.'">';
          echo image_tag('icons/agenda.gif');
          echo format_datetime($value,$sf_user->getGuardUser()->getFormatDate().' HH:mm'); 
          echo '</li>';
        }
      } catch (Exception $e) { 
        echo $e->getMessage();
      }?>
