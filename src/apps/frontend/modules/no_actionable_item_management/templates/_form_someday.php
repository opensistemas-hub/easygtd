<div class="form_someday_maybe">

<div class="content-general-with-mark">
  <h1><?php echo ($form->getObject()->isNew()) ? __('add_new_someday_maybe') : __('edit_someday_maybe'); ?></h1>
</div>

<div class="normal">
  <form id="someday_maybe_form" name="someday_maybe_form" enctype="multipart/form-data"  action="<?php echo url_for('no_actionable_item_management/'.($form->getObject()->isNew() ? 'create_someday_maybe' : 'update_someday_maybe').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    
<div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('value'=>$form->getObject()->getName(),'id'=>'name','class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('description')?>:</div><div class="valor"><?php echo $form['description']->render(array('value'=>$form->getObject()->getName(),'id'=>'description','class'=>'campo_de_texto')) ?></div>
<div class="clear"></div>


<div class="etiqueta"><?php echo __('tickler_date'); ?>:&nbsp;</div>
  <div class="valor">
     <?php echo $form['date']->render(array('id'=>'date','value'=>'','onFocus'=>'blur()','class'=>'fecha datepicker {minordate:true}')); ?>
  </div>
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
  
jq(function(){

 <?php list($year,$month,$date) = explode('-',date('Y-m-d')); ?>

    jq('input.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','Mar','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo $month-1?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true
		}).addClass('float-left');

  jq("#someday_maybe_form").validate({
    invalidHandler : function() { jq.fancybox.resize(); }
  });

  jq.validator.addMethod("minordate", function(value) {
	   var today = "<?php echo date('Y-m-d')?>";
     var cont = true
     if (value != '' && value < today) {
       cont = false;
     }
     return cont;
	 	 },
     "<?php echo '<br/>'.__('The date canoot be minor to this date')?>");

     jq('#someday_maybe_form').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  "xml",
        // success identifies the function to invoke when the server response
        // has been received
        success:   function(responseXML) {
           var status = jq('status', responseXML).text();
           if (status == 'success') {
             if (jq('#info_list').length != 0) {          
               jq('#info_list').load('<?php echo url_for("no_actionable_item_management/someday_maybe_ajax") ?>', function(response, status, xhr) {
                   <?php include_partial('global/modal'); ?>
                   corner_blocks();
               });
             }
             //mensajes:
             <?php if ($form->getObject()->isNew()) { ?>
               renderMessages('<?php echo __("someday_maybe_added_successful"); ?> ','success');
             <?php } else { ?>
               renderMessages('<?php echo __("someday_maybe_edited_successful"); ?> ','success');
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
