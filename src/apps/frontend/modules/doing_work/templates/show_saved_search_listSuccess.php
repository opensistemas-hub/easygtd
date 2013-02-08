<div class="content-with-shade">
  <div class="content-general-with-mark" style="z-index:999;">
    <h1><?php echo __('search') ?></h1>
  </div>
</div>

<ul id="saved_search_list">
      <li><a class="today first saved_search_link" id="focus_today" href="#tabs-context"><?php echo __('today'); ?></a></li>
      <li><a class="next_actions saved_search_link" id="focus_next_actions" href="#tabs-context"><?php echo __('next_actions'); ?></a></li>
      <li><a class="delegated saved_search_link" id="focus_delegated" href="#tabs-context"><?php echo __('delegated_todo'); ?></a></li>
      <li><a class="scheduled saved_search_link" id="focus_scheduled" href="#tabs-context"><?php echo __('scheduled'); ?></a></li>     
</ul> 

<div class="content-general-with-mark" style="z-index:999;">
    <h1><?php echo __('saved_searchs') ?></h1>
</div>

<div class="saved_search_menu">
    <select name="saved_search_menu" id="saved_search_menu" onchange="activeSavedSearch();";>
      <option value="-1"><?php echo __('choose_saved_search') ;?></option>
      <?php foreach($savedSearches as $savedSearch) { ?>        
          <?php $title = "/images/icons/navigation/next_actions.png";
                foreach($savedSearch->getInformations() as $savedSearchInfo) { 
                  switch ($savedSearchInfo->getType()) {
                    case 'DUE_TODAY_FOCUS':
                      if ($savedSearchInfo->getValue() == 1) { 
                        $title = "/images/icons/navigation/today.png";
                      } 
                    break;

                    case 'ONLY_DATE_FOCUS':
                      if ($savedSearchInfo->getValue() == 1) { 
                        $title = "/images/icons/navigation/scheduled.png";
                      }
                    break;

                    case 'TYPE_FOCUS': 
                      if ($savedSearchInfo->getValue() == 'DELEGATED') { 
                        $title = "/images/icons/navigation/delegated.png";
                      }
                    break;
                  } //End switch
                } //End foreach
               ?>
               <option value="saved_search_<?php echo $savedSearch->getId(); ?>" title="<?php echo $title; ?>"><?php echo $savedSearch->getName(); ?></option>
      <?php } ?>
    </select>
    <div id="delete_saved_search">
      <div id="dialog-confirm-delete-saved-search"><?php echo __('Are you sure you want to remove this saved search?') ?></div>
      <a class="delete_saved_search" style="float: right;" title="<?php echo __('delete_saved_search'); ?>" id="delete_saved_search_img" href="javascript:void(0)" ><?php echo image_tag('icons/dot-red.gif',array('style' => 'height: 16px;', 'alt' => ''));?></a>      
      <div class="clear"></div>
      <br/>
    </div>   
</div>


<script type="text/javascript">

jq('#focus_today').bind('click',function(){
  activeToday();
});

jq('#focus_next_actions').bind('click',function(){
  activeNextActions();
});

jq('#focus_delegated').bind('click',function(){
  activeDelegated();
});

jq('#focus_scheduled').bind('click',function(){
  activeScheduled();
});


jq("#delete_saved_search").hide();
jq('#dialog-confirm-delete-saved-search').hide();
jq("#saved_search_menu").msDropDown();

function activeSavedSearch() {
  getDataFromSavedSearch();
  getCriterias();
  if (jq("#saved_search_menu").val() != '-1') {
    jq("#delete_saved_search").show();
    //Activo el botón de borrar:
    jq('#delete_saved_search_img').click(function(){
      jq("#dialog-confirm-delete-saved-search").dialog({
   	resizable: false,
	title: '<?php echo __("delete")?>',
	height:180,
	modal: true,
        open : function () {
                    resize_blocks();
                  },        
	buttons: {
	  '<?php echo __("yes")?>': function() {
            jq.ajax({
              type: "delete",
              url: "<?php echo url_for('doing_work/delete_saved_search') ?>",
              data: "id=" + jq('#saved_search_menu').val(),
              success: function(){
                //Actualizo el listado
                loadSavedSearch()
                //mensaje
                renderMessages('<?php echo __("saved_search_deleted"); ?>','success'); 
                }, 
              error: function(){
                renderMessages('<?php echo __("saved_search_deleted_error"); ?>','error'); 
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
  }
}

function getDataFromSavedSearch() {
//Itero para las búsquedas guardadas.
<?php foreach($savedSearches as $savedSearch) { ?>
  if (jq("#saved_search_menu").val() == 'saved_search_<?php echo $savedSearch->getId(); ?>') {
    <?php foreach($savedSearch->getInformations() as $savedSearchInfo) {
                  switch ($savedSearchInfo->getType()) {
                    case 'DUE_TODAY_FOCUS': ?>
                        <?php if ($savedSearchInfo->getValue() == 1 ) { ?> dueToday = Math.round((new Date()).getTime() / 1000); 
                                jq('#due_date').val(dueToday * 1000); 
                        <?php } ?>; 
                        <?php if ($savedSearchInfo->getValue() == 0 ) { ?> dueToday = 0; jq('#due_date').val(); <?php } ?> 
                        <?php if ($savedSearchInfo->getValue() > 1 ) { ?> dueToday = <?php echo $savedSearchInfo->getValue(); ?>; 
                                jq('#due_date').val(dueToday * 1000); 
                        <?php } ?> 
                        <?php
                    break;

                    case 'ONLY_DATE_FOCUS': ?>
                        onlyDate = '<?php echo $savedSearchInfo->getValue() ?>'; 
                        <?php
                    break;

                    case 'TYPE_FOCUS': ?>
                        type = '<?php echo $savedSearchInfo->getValue() ?>'; 
                        <?php
                    break;

                    case 'CONTEXT_FOCUS': ?>
                        jq('#context_id').val('<?php echo $savedSearchInfo->getValue() ?>'); 
                        context = jq('#context_id').val();
                      <?php
                    break;

                    case 'DONE_FOCUS': 
                      if ($savedSearchInfo->getValue() == 1) { ?>
                          jq('#done_checkbox').attr('checked', 'checked'); 
                            done = 1;
                      <?php } else { ?> 
                          jq('#done_checkbox').removeAttr('checked'); 
                          done = 0;
                      <?php }                                        
                    break;

                    case 'ENERGY_FOCUS': ?>
                        jq('#energy_id').val('<?php echo $savedSearchInfo->getValue() ?>'); 
                        energy = jq('#energy_id').val();
                      <?php
                    break;

                    case 'PRIORITY_FOCUS': ?>
                        jq('#priority_id').val('<?php echo $savedSearchInfo->getValue() ?>'); 
                        priority = jq('#priority_id').val();
                      <?php
                    break;

                    case 'PROJECT_FOCUS': ?>
                        projectId = '<?php echo $savedSearchInfo->getValue() ?>';
                      <?php
                    break;

                    case 'TIME_FOCUS': ?>
                        jq('#time_id').val('<?php echo $savedSearchInfo->getValue() ?>'); 
                        time = jq('#time_id').val();
                      <?php
                    break;
                  } 
    } ?>
  }
<?php } ?>
}


</script>
