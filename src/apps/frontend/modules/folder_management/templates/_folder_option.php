<div id="dialog-confirm-folder">
<?php echo __('if_you_delete_a_folder_,_children_will_be_deleted_._are_you_sure_you_want_to_delete?'); ?>
</div>
<div id="dialog-confirm-folder-multiple">
  <?php echo __('You are deleting multiple folders, if you delete these folders, all partners will be deleted, are you sure?'); ?>
</div>
<a id="folder-edit" class="modal"> <?php echo __('edit')?> </a>
<input type="button" id="cut-folder" value="<?php echo __('Cut') ?>" />
<input type="button" id="copy-folder" value="<?php echo __('Copy') ?>" />
<input type="button" id="paste-folder" value="<?php echo __('Paste') ?>" />
<input type="button" id="folder-delete" value="<?php echo __('delete')?>"/>
<input type="button" id="folder-new-action" value="<?php echo __('new_action')?>"/>

<script type="text/javascript">

  jq('#dialog-confirm-folder-multiple').hide();
  jq('#dialog-confirm-folder').hide();
  jq('#folder-edit').button();
  jq('#folder-delete').button();
  jq('input:button').button();


  var cont = 0;
  jq('#folder-new-action').click(function(){
  
  
  
  var selected = '#'+jq('#tree').jstree('get_selected').attr('id');
  var clean_id = selected.replace('#folder_id_','');

  if ( jq(selected).next().attr('id') != "" ) {

    //if cont == 1 then the user press the button to add more that once and stop the script with return 0
    if (cont == 1) {

      return 0;

    }
    
    jq(selected).append('<li id="folder_action_temp" class="jstree-last jstree-leaf"><ins class="jstree-icon">&nbsp;</ins><img width="25" height="25" src="/images/icons/closednotepad.gif"><input type="text" id="action-folder" value=""><input id="add-new-action" type="button" value="<?php echo __("save") ?>"><input type="button" id="cancel-button" value="<?php echo __("Cancel") ?>"></li>');
    
    cont = 1;
      jq('#cancel-button').click(function(){
      
      jq('#folder_action_temp').remove();
  
      cont = 0;
      
    });
    
    jq('#add-new-action').click(function(){
      
      var nameAction = jq('#action-folder').val();
 
      jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('folder_management/ajax_process'); ?>",
                 data: "object-kind=2&folder-name="+nameAction+"&object-id="+clean_id,
                 success: function(){
                    
                   cont = 0;
                   
                   jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                      
                          alert('<?php echo __("no se ha podido cargar las carpetas") ?>');
                        } else {
                              
                              //DO NOTHING
                        
                        }
    
                 });
                 
                
                 renderMessages('<?php echo __("the_action_was_added_successfully") ?>');
                 
                 
                 }, 
                 error: function(){
                    alert('<?php echo __("Unable to add the action"); ?>');
                 }
       });

                   
    });
    
      
      
      
      

  
  }

  
  
  
  
  });

  
  
  jq('#cut-folder').click(function(){

    cutFunction();  
  
  
  });
  
  //access key copy
  jq(document).bind('keydown','ctrl+x',function(){
    cutFunction();
  });
  
  function cutFunction() {
  
    jq('#object-action-value').val(jq('#object-id').val());
    jq('#object-action-type').val('cut');
    jq('#object-action-element').val(jq('#object-type').val());
  
  }
  
  
  
  jq('#copy-folder').click(function(){

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
  
  jq('#paste-folder').click(function(){
    
    pasteFunction();
   
  });
  
    //access key paste
  jq(document).bind('keydown','ctrl+v',function(){
    pasteFunction();
  });
    
  
  function pasteFunction() {
  
   var action = jq('#object-action-type').val();
    
    var id = jq('#object-action-value').val();
    
    var type = jq('#object-action-element').val();
    
    if (action == 'cut') {
    
    if (type == 'folder') {
    
       jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('folder_management/move_folder') ?>",
                 data: "parent_id="+jq('#object-id').val()+"&children_id="+id,
                 success: function(){
                    
                   jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la carpeta');
                        } else {
                              
                              //DO NOTHING
                        
                        }
    
                 });
                 
                     renderMessages('<?php echo __("The kit was cut correctly") ?>');
                      
                 
                 }, 
                 error: function(){
                    alert('error no se puede procesar');
                 }
              });
     
     
     
     } 
     
     if (type == 'action') {
     
      jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('no_actionable_item_management/reference_move') ?>",
                 data: "parent_id="+jq('#object-id').val()+"&children_id="+id,
                 success: function(){
                    
                   jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la carpeta');
                        } else {
                              
                              //DO NOTHING
                        
                        }
    
                 });
                 
                 renderMessages('<?php echo __("The action was copied correctly") ?>');
                 
                 }, 
                 error: function(){
                    alert('error no se puede procesar');
                 }
              });
     
     }
    
    }
    //end cut method
    
    if ( action == 'copy') {
      
     if (type == 'folder') {
     
         jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('folder_management/copy_folder') ?>",
                 data: "parent_id="+jq('#object-id').val()+"&children_id="+id,
                 success: function(){
                   
                   jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la carpeta');
                        } else {
                              
                              //DO NOTHING
                        
                        }
    
                 });
                 
                    renderMessages('<?php echo __("The folder was copied correctly") ?>');
                  
                 }, 
                 error: function(){
                    alert('error no se puede procesar');
                 }
              });
      }
      
      if (type == 'action' ) {
        
        
        jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('no_actionable_item_management/copy_ajax_reference') ?>",
                 data: "no_actionable_id="+id+"&folder_id="+jq('#object-id').val(),
                 success: function(){
                    
                    jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                if (textStatus == "error") {
                    alert('error');
                } else {

                    //DO NOTHING
          
                }
      
                });
                
                 renderMessages('<?php echo __("The action was copied correctly") ?>');
                  

                 }, 
                 error: function(){
                    alert('error no se puede procesar');
                 }
              });
        
        
        
      }
     
     
     
     
     
    
    }
    //end copy method
    
 
  
  }  
 
 
 
  jq('#folder-delete').click(function(){

    deleteFunction();
    
  
  });
  
  //access key delete
  
  //ckeck type and execute
  
  
  
  jq(document).bind('keydown','del',function(){
      if ( jq('#object-type').val() == 'folder') {
        deleteFunction();
      }
  });
    
  
  function deleteFunction() {

    var multiple = jq('#multi-selected-folder').val();
    var array = new Array();
    var selected_id = jq('#object-id').val();
     

    
    array = multiple.split(',');
    
    for (var i in array) {
    
      var count = i++;  
    
    }
    
    if ( count > 1 ) { 
    
      
      //MULTIPLE
      //dialog
    jq("#dialog-confirm-folder-multiple").dialog({
			resizable: false,
			title: '<?php echo __("delete"); ?>',
			height:180,
			width: 400,
			modal: true,
			buttons: {
				'<?php echo __("yes")?>': function() {
          
          jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('folder_management/delete') ?>",
                 data: "multiple=true&folder_group="+jq('#multi-selected-folder').val(),
                 success: function(){
                    
                  jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la carpeta');
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
      
      
    
    } else {
    //SINGLE
    //dialog
    jq("#dialog-confirm-folder").dialog({
			resizable: false,
			title: '<?php echo __("delete"); ?>',
			height:180,
			width: 400,
			modal: true,
			buttons: {
				'<?php echo __("yes")?>': function() {
        
          jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('folder_management/delete') ?>",
                 data: "id="+selected_id,
                 success: function(){
                    
                  jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
                      if (textStatus == "error") {
                          alert('No se ha podido eliminar la carpeta');
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
    
    
    
    jq('#object-id').val('');
    jq('#object-type').val('')
    jq('#object-kind').val('0');
    
  
  }  

</script>
