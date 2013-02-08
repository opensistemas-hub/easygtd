<?php $hash = md5(date('Y-m-d h:j:s').rand()); ?>
<div id="dialog-confirm-project_<?php echo $hash; ?>"><?php echo __('Are you sure you want to remove this project?') ?></div>
<table class="list">
  <tbody>
    <?php foreach ($projectsPager->getResults() as $project) { ?>
    <tr id="project-div-<?php echo $project->getId() ?>">
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php  $count_projects = $project->getProjectActions()->count() + $project->getProjectNoActionableActions()->count();
            echo $project->getName().'&nbsp;('.$count_projects.')';  ?>       
          <?php if ($project->getProjectActions()->count() > 0) { ?>
          <br/>
          <div class="project_actions" id="project_actions_<?php echo $project->getId(); ?>"></div>
          <?php  }  ?>          
        </div>     
        <div class="info_options">
          <?php echo '<a href="#show_projects_actions_id_'.$project->getId().'" id="show_projects_actions_id_'.$project->getId().'">'.image_tag('icons/+.gif').'</a>'; ?>
          <?php echo link_to(image_tag('icons/dot-green.gif', array('alt' => '')),'clarify_process/create_actionable_from_project?ref=project&project_id='.$project->getId(),array('class'=>'modal', 'title' => __('add_action'))); ?>
          <?php echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'project_management/edit?id='.$project->getId(),array('class'=>'modal', 'title' => __('edit'))); ?>
                <a title="<?php echo __('delete'); ?>" id="delete_project_url_<?php echo $project->getId(); ?>" href="javascript:void(0);"><?php echo image_tag('icons/dot-red.gif',array('class'=>'', 'alt' => '')); ?></a>

                <script type="text/javascript">
                jq('#dialog-confirm-project_<?php echo $hash; ?>').hide();
                jq('#delete_project_url_<?php echo $project->getId(); ?>').click(function(){
		      jq("#dialog-confirm-project_<?php echo $hash; ?>").dialog({
		        resizable: false,
		        title: '<?php echo __("delete"); ?> ',
		        height:180,
		        modal: true,
		        buttons: {
		          '<?php echo __("yes")?>': function() {
				                                jq.ajax({
				                                        type: "DELETE",
				                                        url: "<?php echo url_for('project_management/delete'); ?>",
				                                        data: "id=<?php echo $project->getId(); ?>",
				                                        success: function(){
				                                                           jq('#project-div-<?php echo $project->getId(); ?>').fadeOut(500);
				                                                           jq('#project-list').load('<?php echo url_for("project_management/ajax_list"); ?>', function(response, status, xhr) {
												 if (status == "success") {
												   <?php include_partial('global/modal'); ?>
												 }
											      });
                                                                                           },
				                                        error: function(){

				                                                         }
				                                        });
			  					jq(this).dialog('close');
								},
		          '<?php echo __("no") ?>': function() {
							        jq(this).dialog('close');
								}
			   }
		      });
                });
 
                //Toogle de ver acciones del proyecto.
                jq('#show_projects_actions_id_<?php echo $project->getId(); ?>').bind('click', function () {
                  if (jq('#project_actions_<?php echo $project->getId(); ?>').html().length == 0) {
                    jq('#project_actions_<?php echo $project->getId(); ?>').html('<?php echo image_tag("icons/navigation/spinner.gif"); ?>');
                    jq('#project_actions_<?php echo $project->getId(); ?>').load('<?php echo url_for("project_management/project_actions_list?project_id=".$project->getId()); ?>', function(response, status, xhr) {
                      if (status == "success") {
		        <?php include_partial('global/modal'); ?>
                        resize_blocks();
                        corner_blocks();
                       jq('#show_projects_actions_id_<?php echo $project->getId(); ?>').html('<?php echo image_tag('icons/-.gif'); ?>'); 
		      }
                    });
                  } else {
                    jq('#project_actions_<?php echo $project->getId(); ?>').html('');
                    jq('#show_projects_actions_id_<?php echo $project->getId(); ?>').html('<?php echo image_tag('icons/+.gif'); ?>'); 
                  }
                });                
                </script>        
        </div>
        <div class="clear"></div>
        </div>
        </div>
        </td>
      </tr>
    <?php }?>
    <!-- ACCIONES SIN PROYECTO INICIO -->
    <tr>
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php  $count_projects = $noProjectNextActions->count();
            echo __('no_action_project').'&nbsp;('.$count_projects.')';  ?>       
          <?php if ($noProjectNextActions->count() > 0) { ?>
          <br/>
          <div class="project_actions" id="project_actions_0"></div>
          <?php  }  ?>          
        </div>     
        <div class="info_options">
          <?php echo '<a href="#show_projects_actions_id_0" id="show_projects_actions_id_0">'.image_tag('icons/+.gif').'</a>'; ?>        
          <?php echo link_to(image_tag('icons/dot-green.gif', array('alt' => '')),'clarify_process/create_actionable_from_project?project_id=-1',array('class'=>'modal', 'title' => __('add_action'))); ?>          
        </div>
        <div class="clear"></div>
        </div>
        </div>
        </td>
      </tr>
    <!-- ACCIONES SIN PROYECTO FIN-->
  </tbody>
</table>

<div style="clear:left; text-align:center;">
    <?php  echo pager_navigation($projectsPager, url_for('project_management/index')) ?>
</div>
<br/>
<br/>

<script type="text/javascript">
jq('#dialog-confirm-project_<?php echo $hash; ?>').hide();
//Toogle de ver acciones sin proyecto.
                jq('#show_projects_actions_id_0').bind('click', function () {
                  if (jq('#project_actions_0').html().length == 0) {
                    jq('#project_actions_0').html('<?php echo image_tag("icons/navigation/spinner.gif"); ?>');
                    jq('#project_actions_0').load('<?php echo url_for("project_management/project_actions_list?project_id=-1"); ?>', function(response, status, xhr) {
                      if (status == "success") {
		        <?php include_partial('global/modal'); ?>
                        resize_blocks();
                        corner_blocks();
                       jq('#show_projects_actions_id_0').html('<?php echo image_tag('icons/-.gif'); ?>'); 
		      }
                    });
                  } else {
                    jq('#project_actions_0').html('');
                    jq('#show_projects_actions_id_0').html('<?php echo image_tag('icons/+.gif'); ?>'); 
                  }
                });
</script>

