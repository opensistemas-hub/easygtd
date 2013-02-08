<div class="form_saved_search">

  <div class="content-general-with-mark">
    <h1><?php echo __('new_saved_search')?></h1>
  </div>

   <div class="normal">
    <form id="saved_search_form" name="saved_search_form" enctype="multipart/form-data" action="<?php echo url_for('doing_work/saveSavedSearch') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
      <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
      <?php endif; ?>

      <div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('value'=>$form->getObject()->getName(),'id'=>'name','name'=>'name_saved_search', 'class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
      <div class="clear"></div>

      <?php echo $form->renderHiddenFields(false) ?>
      <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
      <div class="clear"></div>


       <input name="type_id" type="hidden" id="type_id" value="<?php echo $type_to_action ?>" />
       <input name="context_id" type="hidden" id="context_id"       value="<?php echo $contexto ?>" />
       <input name="time_id" type="hidden" id="time_id"           value="<?php echo $time ?>" />
       <input name="energy_id" type="hidden" id="energy_id"         value="<?php echo $energy ?>" />
       <input name="priority_id" type="hidden" id="priority_id"       value="<?php echo $priority ?>" />
       <input name="done" type="hidden" id="done" value="<?php echo $doneStatus ?>" />
       <input name="project_id" type="hidden" id="project_id"      value="<?php echo $projectId ?>" />
       <input name="due_today" type="hidden" id="due_today"       value="<?php echo $dueToday ?>" />
       <input name="only_date" type="hidden" id="only_date"       value="<?php echo $onlyDate ?>" />
     </form>
    </div>

  </div>

<script type="text/javascript">

jq("#saved_search_form").validate({});

jq('#saved_search_form').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 
           if (status == 'success') {
             //mensajes:
             renderMessages('<?php echo __("saved_search_successful"); ?> ','success'); 
             //Actualizo el listado
             var selected = new Array();
             jq('#saved_search_list .selected').each(function() {
               selected.push(jq(this).attr('id')); 
             });
             jq('#saved_searchs').load('doing_work/show_saved_search_list', function (response, status, xhr) { 
               if (status == 'success') {
                 for (var i = 0; i < selected.length;i++){
                   jq('#' + selected[i] ).addClass('selected');
                 }
               }
             });            
             jq.fancybox.close();
           }
           if (status == 'error') {
             var message = jq('message', responseXML).text(); 
             renderMessages(message,'error');
           } 
        }
    });
         

</script>
