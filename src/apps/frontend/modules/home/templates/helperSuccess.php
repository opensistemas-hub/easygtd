<div style="background-color:#fff">
<div class="content-marker"></div>
            	<div id="content-general-with-mark" class="float-left"><h3><?php echo __('help')?>.</h3></div>
            	<br/>
            	<br/>
            	<br/>
            	<br/>
<?php 
switch ($code){
      case 1:
        $content=__('why_is_this_being_done?').'<br/>'.__('what_are_the_key_standards_to?').'<br/>'.__('what_rules_do_we_play_by?').'<br/>';
        break;
     case 2:
        $content=__('you_expect_from_your_project?');
        break;
      case 3:
        $content=__('what_are_all_the_things_that_occur_to_me_about_this?').'<br/>'. __('what_is_the_current_reality?').'<br/>'.__('what_do_i_know?').'<br/>'.__('what_do_i_do_not_know?').'<br/>'.__('what_ought_i_consider?').'<br/>'.__('what_have_not_i_considered').'?';
        break; 
         
        case 4:
        $content=__('the_project_was_developed_in_the_future_or_immediately?');        
        break;
        
        case 5:
        $content=__('you_can_add_actions_that_need_your_project_or_other_projects_within_the_same');
        break;
        
        case 6:
          $content =__('You can add from any part of the site easy task, and these without leaving what you were doing');
        break;
        
        case 7:
          $content = include_partial('static',array('view'=>'email_configuration','lang'=>'es'));
          break;
    
    }            	
?>
            	
<?php echo html_entity_decode($content);?>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
</div>
