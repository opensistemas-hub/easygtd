<div class="form_import_stuff">

<div class="content-general-with-mark">
  <h1><?php echo __('import_a_file_with_thoughts_to_add_it_to_your_inbox');?></h1>
</div>

<div class="normal">
    <p><?php echo link_to(__('Download a example'),'home/static_content?file=import_csv.txt', array('target' => 'blank')); ?></p>    	

<form id="stuffs_import_form" name="stuffs_import_form"  enctype="multipart/form-data" action="<?php echo url_for('stuff_management/process_import'); ?>" method="post" >

  <div class="etiqueta"><?php echo __('Upload a .txt or CSV file and transform into stuff');?>:</div>
  <div class="valor"><input type="file" name="stuffs_import_file" value="" class="required:{required:true,accept:'txt|csv|xls',messages:{accept:'<?php echo __('not_supported_file_type'); ?>'}}" /></div>
  <div class="clear"></div>  

  <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('import')?>" /></div>
  <div class="clear"></div>  

</form>

</div>
</div>

<script type="text/javascript">

jq(function(){
	
  jq("#stuffs_import_form").validate({
      invalidHandler : function() { jq.fancybox.resize(); }
  });

  jq('#stuffs_import_form').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",
        // success identifies the function to invoke when the server response 
        // has been received
        success:   function(responseXML) {
          var status = jq('status', responseXML).text(); 
          if (status == 'success') {
            if (jq('#list-stuff').length != 0) {
              jq('#list-stuff').load('<?php echo url_for("stuff_management/inbox") ?>', function(response, status, xhr) {
                if (status == "success") {
                  <?php include_partial('global/modal'); ?>
                  corner_blocks();               
                } 
              });
            }
            renderMessages('<?php echo __("stuff_imported"); ?> ','success');
            jq.fancybox.close();             
          }
  
          if (status == 'error') {
            var message = jq('message', responseXML).text(); 
            renderMessages(message,'error');
          } 
        }
  });

});

</script>

