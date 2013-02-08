<div id="dialog-confirm-delete-action"><?php echo __('Are you sure you want to delete this reference?') ?></div>
<a id="edit-button" ><?php echo __('edit'); ?> </a>
<input type="button" id="action-delete" value="<?php echo __('delete')?>"/>
<input type="button" id="copy-action" value="<?php echo __('Copy')?>"/>
<input type="button" id="cut-action" value="<?php echo __('Cut')?>"/>

<script type="text/javascript">


  jq('#dialog-confirm-delete-action').hide();
  jq('input:button').button();
  jq('#edit-button').button();
  
  jq('#cut-action').click(function(){
    
    cutFunctions();
    
  });  
  
  function cutFunctions() {
  
    jq('#object-action-value').val(jq('#object-id').val());
    jq('#object-action-type').val('cut');
    jq('#object-action-element').val(jq('#object-type').val());
  
  }

  //access key cut
  jq(document).bind('keydown','ctrl+x',function(){
    cutFunction();
  });  
  
  jq('#copy-action').click(function(){
    
    copyFunction();
    
  });
  
  //access key copy
  jq(document).bind('keydown','ctrl+c',function(){
    copyFunction();
  });
  
  
  function copyFunction() {
    jq('#object-action-value').val(jq('#object-id').val());
    jq('#object-action-type').val('copy');
    jq('#object-action-element').val(jq('#object-type').val());
  
  
  }
  
  jq('#action-delete').click(function(){

        deletesFunction();
     
  });
 
  jq(document).bind('keydown','del',function(){
      if ( jq('#object-type').val() == 'action') {
        deletesFunction();
        }
  });
  
  function deletesFunction(){
  
    //dialog
    jq("#dialog-confirm-delete-action").dialog({
			resizable: false,
			title: '<?php echo __("delete"); ?>',
			height:180,
			width: 400,
			modal: true,
			buttons: {
				'<?php echo __("yes")?>': function() {
          
          jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('no_actionable_item_management/delete') ?>",
                 data: "type=REFERENCE&id="+jq('#object-id').val(),
                 success: function(){
                    
                  jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la referencia');
                        } else {
                              
                              //DO NOTHING
                        
                        }
    
                 });

                 }, 
                 error: function(){
                    alert('No se ha podido eliminar la carpeta');
                 }
              });
          
          
				  jq(this).dialog('close');
				},
				'<?php echo __("no") ?>': function() {
					jq(this).dialog('close');
				}
			}
		});
    //dialog
    
  }
</script>
