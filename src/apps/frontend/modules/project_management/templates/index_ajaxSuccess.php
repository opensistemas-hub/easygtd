<?php if (count($projectsPager) > 0) {
      include_partial('projects_list',array('projectsPager'=>$projectsPager,'noProjectNextActions' => $noProjectNextActions));
      } else { ?>
 <h5><?php echo __('no_project_found')?></h5>
<?php } ?>







