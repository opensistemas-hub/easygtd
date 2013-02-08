<div id="actions-discriminator">

<div id="advance-panel"></div>
  <div id="panel-criterias" class="close-panel">
    <?php  include_partial('show_criterias',array('contextCriterias'=>$contextCriterias,'timeCriterias'=>$timeCriterias,'energyCriterias'=>$energyCriterias,'priorityCriterias'=>$priorityCriterias,'typeNextActions'=>$typeNextActions));?>
  </div>
</div>    

<script type="text/javascript">
jq('#advance-panel').html("");
jq('#advance-panel').html("<img src=\"/images/icons/+.gif\" alt='' \/><a title=\"<?php echo __('Show search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('show_advance_panel') ?></a>");
jq('#panel-criterias').hide();


jq('#advance-panel').click(function(){
  
  if (jq('#panel-criterias').hasClass('close-panel')) {
  
    jq('#panel-criterias').show();
    jq('#panel-criterias').removeClass('close-panel');
    jq('#panel-criterias').addClass('open-panel');
    jq('#advance-panel').html('');
    jq('#advance-panel').html("<img src=\"/images/icons/-.gif\" alt='' \/><a title=\"<?php echo __('Hide the search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('hide_advance_panel') ?></a>");
    
  } else {
  
    jq('#panel-criterias').hide();
    jq('#panel-criterias').addClass('close-panel');
    jq('#panel-criterias').removeClass('open-panel');
    jq('#advance-panel').html('');
    jq('#advance-panel').html("<img src=\"/images/icons/+.gif\" alt='' \/><a title=\"<?php echo __('Show search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('show_advance_panel') ?></a>");
  
  
  }

    resize_blocks();
    corner_blocks();
  
});
 
</script>

