<div class="form_stuff">

<div class="content-general-with-mark">
  <h1><?php echo (!$edits)?__('add_new_stuff'): __('edit_stuff')?></h1>
</div>

<div class="normal">
  <form id="stuff_form" name="stuff_form" enctype="multipart/form-data" action="<?php echo url_for('stuff_management/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>

  <div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('value'=>$form->getObject()->getName(),'id'=>'name','class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
  <div class="clear"></div>  

  <div class="etiqueta"><?php echo __('description') ?>:</div><div class="valor"><?php echo $form['description']->render(array('value'=>$form->getObject()->getDescription(),'id'=>'description_field', 'class' => 'campo_de_texto','maxlength' => 255)) ?></div>
  <div class="clear"></div>  

  <div class="etiqueta"><?php echo __('attachments') ?>:</div>
  <div class="valor">
    <?php if ($form->getObject()->getStuffAttachments()->count() > 0) { ?>
            <ul>
              <?php foreach($form->getObject()->getStuffAttachments() as $stuffAttachment ) { ?>
                     <li id="attachment_<?php echo $stuffAttachment->getId(); ?>">
                         <?php 
                        
                          $attach = explode('_',$stuffAttachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($stuffAttachment->getValue(),$cont+1);
                                                    
                          echo ($attachName);
                         ?>
                          <a id="delete_stuff_attachment_<?php echo $stuffAttachment->getId(); ?>">[<?php echo __('delete') ?>]</a>

                                          
                     </li>               
              <?php } ?>
            </ul>
    <?php } else { ?>
         <?php echo __('no_attachments')?>
    <?php } ?>
    <br/>    <br/>
    <div class="position-attachment">
      <?php echo $archivo['file']->render(array("class" => "required:{required:false,accept:'doc|doc|xls|txt|pdf|png|jpeg|jpg|gif|xml|ics|odt|rtf|ods|ots|xls|csv|sql',messages:{accept:'".__('not_supported_file_type')."'}}"));?>               
      <div id="moreUploads_stuff"></div>
      <div class="clear"></div>
      <div id="moreLink">
        <a href="javascript:addFileInput('doc|doc|xls|txt|pdf|png|jpeg|jpg|gif|xml|ics|odt|rtf|ods|ots|xls|csv|sql','<?php echo __('not_supported_file_type'); ?>', 'moreUploads_stuff');"><?php echo __('add_other_file')?>.</a>
      </div>
    </div>
  </div>
  <div class="clear"></div>  

  <?php echo $form->renderHiddenFields(false) ?>
  <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
  <div class="clear"></div>  

  </form>

</div>
</div>



<script type="text/javascript">

  <?php foreach($form->getObject()->getStuffAttachments() as $stuffAttachment ) { ?>
    jq('#delete_stuff_attachment_<?php echo $stuffAttachment->getId() ?>').click(function(){
     jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('stuff_management/delete_attachment') ?>",
                 data: "id=<?php echo $stuffAttachment->getId(); ?>",
                 success: function(){
                    
                    jq('#attachment_<?php echo $stuffAttachment->getId() ?>').fadeOut(555);
                    jq('#list-stuff').load('<?php echo url_for("stuff_management/inbox") ?>');

                 }, 
                 error: function(){

                 }
              });

     }); 
  <?php } ?>

jq(function(){
	
  jq("#stuff_form").validate({
      invalidHandler : function() { jq.fancybox.resize(); }
  });

  jq('#stuff_form').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 
           if (status == 'success') {
             if (jq('#list-stuff').length != 0) {
               jq('#list-stuff').load('<?php echo url_for("stuff_management/inbox") ?>', function(response, status, xhr) {
                   <?php include_partial('global/modal'); ?>
                   corner_blocks();                                          
               });
             } 
             if (jq('#clarify-content').length != 0) {
               setTimeout("window.location.href = '<?php echo url_for('@process'); ?>';", 2000);                                                                      
             } 
             //mensajes:
             <?php if ($form->getObject()->isNew()) { ?> 
               renderMessages('<?php echo __("stuff_added_successful"); ?> ','success');
             <?php } else { ?> 
               renderMessages('<?php echo __("stuff_edited_successful"); ?> ','success');
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
