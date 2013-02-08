<ul id="focus_project_list">
        <li><?php echo link_to(__('add_new_project'), 'project_management/new',array('class'=>'modal add first', 'title' => __('add_new_project')));?></li> 
        <li><a class="focus_project" id="all_projects" href="javascript:void(0);"><?php echo __('all_projects'); ?></a></li>   
        <?php if ($projects->count() > 0) { ?>
          <?php foreach($projects as $project) { ?>
            <li><a class="focus_project" id="project_<?php echo $project->getId(); ?>" href="javascript:void(0);"><?php echo $project->getName(); ?></a></li>     
          <?php } ?>
        <?php } ?>  
</ul>

<script type="text/javascript">

jq('#all_projects').bind('click',function(){  
  projectId = -1;
  jq('.focus_project').each(function () {
      jq(this).removeClass('selected');
  });   
  jq(this).addClass('selected');
  getCriterias();  
});

<?php foreach($projects as $project) { ?>
  jq('#project_<?php echo $project->getId(); ?>').bind('click',function(){  
    projectId = <?php echo $project->getId(); ?>;
    jq('.focus_project').each(function () {
      jq(this).removeClass('selected');
    });    

    jq(this).addClass('selected');
    getCriterias();  
  });
<?php } ?>

if (projectId == -1) { 
  jq('#all_projects').addClass('selected'); 
} else {
  jq('#project_' + projectId).addClass('selected'); 
}

</script>
