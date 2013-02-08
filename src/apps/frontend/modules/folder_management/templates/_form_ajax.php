<?php echo form_tag('folder_management/ajax_process',array('id'=>'form_ajax'));?>
<div id="messages_folder"></div>
<span id="text-show"></span>
  <input class="quick-work defaultText" title="<?php echo __('add_new_folder')?>" type="text" id="folder-name" name="folder-name" value=""/>

  <input class="hidden-text" type="text" id="object-id" name="object-id" value=""/>
  <input class="hidden-text" type="text" id="object-kind" name="object-kind" value=""/>
  <input class="hidden-text" type="text" id="object-type" name="object-type" value=""/>
  <input class="hidden-text" type="text" id="object-action-value" name="object-action-value" value=""/>
  <input class="hidden-text" type="text" id="object-action-type" name="object-action-type" value=""/>
  <!-- action or folder on object-action-element -->
  <input class="hidden-text" type="text" id="object-action-element" name="object-action-type" value=""/>
  <input type="hidden" value="" id="multi-selected-folder" name="multi-selected-folder" />
  <input type="submit" value="<?php echo __('save') ?>">
</forn>

<div id="folder-panel"><?php include_partial('folder_option')?></div>
<div id="action-panel"><?php include_partial('action_option')?></div>

<script type="text/javascript">
//hide element with class hidden-text
jq('input.hidden-text').hide();

jq('#form_ajax').ajaxForm({
  error:function() {
    //alert('<?php echo __("this_folder_already_exist") ?>');
  },
  success:function(){

    
    jq('#folder_content').load('<?php echo url_for("folder_management/ajax_tree")?>',{limit:25},function(responseText, textStatus, req){
      
      if (textStatus == "error") {
          
          alert('<?php echo __("It was not possible to upload folders")?>');
        
        } else {

          jq('#folder-name').val('');
           
        
        }
    
    });
      jq('#folder-choose').load('<?php echo url_for("clarify_process/folder_view_ajax") ?>');
  }
});
  
  jq('#folder-name').click(function(){
    
    //CLEAN TEXT FIELD
    jq('#folder-name').val('');
    
  });
  

  
</script>
