<div class="form_reference">

<div class="content-general-with-mark">
  <h1><?php echo ($form->getObject()->isNew()) ? __('add_new_reference') : __('edit_reference'); ?></h1>
</div>

<div class="normal">
    <form id="no_actionable_form" name="no_actionable_form" enctype="multipart/form-data"  action="<?php echo url_for('no_actionable_item_management/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
      <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
      <?php endif; ?>

    <div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('value'=>$form->getObject()->getName(),'id'=>'name','class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
    <div class="clear"></div>

    <div class="etiqueta"><?php echo __('description') ?>:</div><div class="valor"><?php echo $form['description']->render(array('value'=>$form->getObject()->getDescription(),'id'=>'description_field', 'class' => 'campo_de_texto','maxlength' => 255)) ?></div>
    <div class="clear"></div>

    <div class="etiqueta"><?php echo __('attachments') ?>:</div>
    <div class="valor">
      <?php if ($form->getObject()->getNoActionableItemAttachments()->count() > 0) { ?>
            <ul>
              <?php foreach($form->getObject()->getNoActionableItemAttachments() as $noActionableItemAttachments ) { ?>
                     <li id="attachment_<?php echo $noActionableItemAttachments->getId(); ?>">
                         <?php

                          $attach = explode('_',$noActionableItemAttachments->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($noActionableItemAttachments->getValue(),$cont+1);

                          echo ($attachName);
                         ?>
                          <a id="delete_no_actionable_attachment_<?php echo $noActionableItemAttachments->getId(); ?>">[<?php echo __('delete') ?>]</a>

                     </li>
              <?php } ?>
            </ul>
      <?php } else { ?>
         <?php echo __('no_attachments')?>
      <?php } ?>
      <br/>    <br/>
      <div class="position-attachment">
                <?php echo $archivo['file'];?>
		<div id="moreUploads_no_actionable"></div>
	  <div id="moreLink" >
		  <a href="javascript:addFileInput('doc|doc|xls|txt|pdf|png|jpeg|jpg|gif|xml|ics|odt|rtf|ods|ots|xls|csv|sql','<?php echo __('not_supported_file_type'); ?>', 'moreUploads_no_actionable');"><?php echo __('add_other_file')?>.</a>
		</div>
      </div>
    </div>
    <div class="clear"></div>

  <?php echo $form->renderHiddenFields(true) ?>
  <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
  <div class="clear"></div>


</form>

</div>
</div>

<script type="text/javascript">

 <?php foreach($form->getObject()->getNoActionableItemAttachments() as $noActionableItemAttachments ) { ?>
    jq('#delete_no_actionable_attachment_<?php echo $noActionableItemAttachments->getId() ?>').click(function(){
    jq.ajax({
                 type: "POST",
                 url: "<?php echo url_for('no_actionable_item_management/delete_attachment') ?>",
                 data: "id = <?php echo $noActionableItemAttachments->getId(); ?>",
                 success: function(){

                    jq('#attachment_<?php echo $noActionableItemAttachments->getId() ?>').fadeOut(555);
                    jq('#list-no-actionable').load('<?php echo url_for("no_actionable_item_management/inbox") ?>');

                 },
                 error: function(){
                  alert('error');
                 }
              });

     });
  <?php } ?>


jq(function(){

  jq("#no_actionable_form").validate({
      invalidHandler : function() { jq.fancybox.resize(); }
  });

  jq('#no_actionable_form').ajaxForm(function() {
      if (jq('#list-no-actionable').length != 0) {
      jq('#list-no-actionable').load('<?php echo url_for("no_actionable_item_management/index") ?>', function(response, status, xhr) {
         if (status == "success") {
           <?php include_partial('global/modal'); ?>
           jq.fancybox.close();
         }
      });
      } else {
           //El mensaje y cierro el dialogo.
           jq.fancybox.close();
           <?php echo url_for("no_actionable_item_management/index") ?>
      }
      //mensajes:
      <?php if ($form->getObject()->isNew()) { ?> 
              renderMessages('<?php echo __("reference_added_successful"); ?> ','success');
      <?php } else { ?> 
              renderMessages('<?php echo __("reference_edited_successful"); ?> ','success');
      <?php } ?>
   });

 });

</script>
