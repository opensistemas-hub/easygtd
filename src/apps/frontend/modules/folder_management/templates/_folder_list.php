<div id="dialog-confirm"><?php echo __('Are you sure you want to remove this folder?') ?></div>
<div id="dialog-confirm-reference"><?php echo __('Are you sure you want to remove this reference?') ?></div>

<table class="list">
  <tbody> 
    <?php foreach ($foldersPager->getResults() as $folder) { ?>
    <tr id="folder-div-<?php echo $folder->getId() ?>">
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php echo $folder->getName().'&nbsp;('.$folder->getFolderNoActionables()->count().')';  ?>
          <?php if ($folder->getFolderNoActionables()->count() > 0) { ?>
          <br/>
          <ul>
            <?php foreach ($folder->getFolderNoActionables() as $noActionableItemFolders) { ?>
              <?php include_partial('global/SHOW_DETAILS', array('reference'=> $noActionableItemFolders->getNoActionableItem()));?>
            <?php  }  ?>
          </ul> 
          <?php } ?>
          </div>     
          <div class="info_options">
                <?php echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'folder_management/edit?id='.$folder->getId(),array('class'=>'modal', 'title' => __('edit'))); ?>                      
                <a title="<?php echo __('delete'); ?>" id="delete_url_<?php echo $folder->getId(); ?>" href="javascript:void(0);"><?php echo image_tag('icons/dot-red.gif',array('class'=>'', 'alt' => '')); ?></a>        
                <script type="text/javascript">
                jq('#dialog-confirm-delete').hide();
                jq('#delete_url_<?php echo $folder->getId(); ?>').click(function(){
                  jq("#dialog-confirm").dialog({
                  resizable: false,
                  title: '<?php echo __("delete"); ?> ',
                  height:180,
                  modal: true,
                  buttons: {
                    '<?php echo __("yes")?>': function() {
				                                jq.ajax({
				                                        type: "DELETE",
				                                        url: "<?php echo url_for('folder_management/delete'); ?>",
				                                        data: "id=<?php echo $folder->getId(); ?>",
				                                        success: function(){
				                                                           jq('#folder-div-<?php echo $folder->getId(); ?>').fadeOut(500);
				                                                           jq('#folder-list').load('<?php echo url_for("folder_management/ajax_list"); ?>', function(response, status, xhr) {
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
                </script>              
        </div>
        <div class="clear"></div>
        </div>
        </div>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
    
  <div style="clear:left; text-align:center;">
    <?php  echo pager_navigation($foldersPager, url_for('folder_management/index')) ?>
  </div>

 
<script type="text/javascript">
jq('#dialog-confirm').hide();
jq('#dialog-confirm-reference').hide();
</script>
    
