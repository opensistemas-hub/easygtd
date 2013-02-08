<div class="form_criteria">

<div class="content-general-with-mark">
  <h1><?php echo ($form->getObject()->isNew()) ? __('add_new_criteria') : __('edit_criteria'); ?></h1>
</div>

<div class="normal">
  <form id="form_criteria" action="<?php echo url_for('criteria_management/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>

   <div class="etiqueta"><?php echo __('type')?>:</div><div class="valor"><?php echo $form['type']->render(array('id'=>'type')); ?></div>
   <div class="clear"></div>  

   <div class="etiqueta"><?php echo __('value')?>:</div><div class="valor"><?php echo $form['value']->render(array('id'=>'value_text', 'class' => 'campo_de_texto required')) ?></div>
   <div class="clear"></div>  

   <?php echo $form->renderHiddenFields(false) ?>

   <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
   <div class="clear"></div>  

  </form>

</div>
</div>

<script type="text/javascript">

jq(function(){

  jq('#form_criteria').validate({
      invalidHandler : function() { jq.fancybox.resize(); }
  });    

  jq('#form_criteria').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",
        // success identifies the function to invoke when the server response 
        // has been received
        success:   function(responseXML) {
          var status = jq('status', responseXML).text(); 
          if (status == 'success') {
            if (jq('#criteria-list').length != 0) {
              jq('#criteria-list').load('<?php echo url_for("criteria_management/ajax_list") ?>', function(response, status, xhr) {
                if (status == "success") {
                  <?php include_partial('global/modal'); ?>
                  corner_blocks();          
                } 
              });
            }
            //mensajes:
            <?php if ($form->getObject()->isNew()) { ?> 
              renderMessages('<?php echo __("criteria_added_successful"); ?> ','success');
            <?php } else { ?> 
              renderMessages('<?php echo __("criteria_edited_successful"); ?> ','success');
            <?php } ?>
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
