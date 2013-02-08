<div class="form_no_actionable">

<?php if($nextAction != null){ ?> 

  <div class="content-general-with-mark">
    <h1><?php echo __('Change to no accionable'); ?></h1>
  </div>

<?php } ?>

<div class="normal">
<?php echo form_tag('clarify_process/save_no_actionable',array('id'=>'no_actionable_form'));?>

<?php if($nextAction != null){ ?> 
  <input type="hidden" id="next_action_id" name="next_action_id" value="<?php  echo $nextAction->getId(); ?>"/>
<?php } ?>

<?php if($stuff != null){ ?> 
  <input type="hidden" id="stuff_id" name="stuff_id" value="<?php echo $stuff->getId();  ?>"/>
<?php } ?>

  <div class="etiqueta"><?php echo __('options')?>:</div>
  <div class="valor">
    <ul>
      <li>
        <input accesskey="1" title="<?php echo __('Accesskey') ?>: <1>" type="radio" checked  id="action_delete" name="actions" value="delete"/>&nbsp;<?php echo __('delete_this_thought_-_this_is_not_my_business')?>
      </li>
      <li>
        <input accesskey="2" title="<?php echo __('Accesskey') ?>: <2>" type="radio" id="action_someday" name="actions" value="list"/>&nbsp;<?php echo __('put_into_my_list_of_someday-maybe')?>
          <ul id="date_select" style="margin-left:20px;">
            <li>
             <span style="float:left;"><?php echo __('tickler_date'); ?>&nbsp;</span>
               <?php echo $form['date']->render(array('id'=>'date','value'=>'','class'=>'fecha datepicker {minordate:true}')); ?>

             <div class="clear"></div>
           </li>
         </ul>
       </li>
       <li>
         <input accesskey="3" title="<?php echo __('Accesskey') ?>: <3>"  type="radio" id="action_reference" name="actions" value="folder"/>&nbsp;<?php echo __('save_as_reference')?>
         <ul>
           <li>
             <span id="folder-choose"></span>
           </li>
         </ul>
       </li>
    </ul>
  </div> 
   
  <div class="clear"></div>  

  <br/>
  <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
  <div class="clear"></div>  

</form>

</div>
</div>


<script type="text/javascript">

resize_blocks();
corner_blocks();


jq('#date_select').hide();
jq('#folder-choose').hide();
jq('#folder-choose').load('<?php echo url_for("clarify_process/folder_view_ajax") ?>');

jq('#action_delete').click(function(){
    jq('#date_select').hide();
    jq('#folder-choose').hide();
    jq.fancybox.resize();
});

jq('#action_reference').click(function(){
    jq('#date_select').hide();
    jq('#folder-choose').show();
    jq.fancybox.resize();
});

jq('#action_someday').click(function (){

   jq('#date_select').show();
   jq('#folder-choose').hide();
   jq.fancybox.resize();

   jq(function () {
                  jq.validator.addMethod("minordate", function(value) {
	                                                               var today = "<?php echo date('Y-m-d')?>";
      	                                                               var cont = true
                                                                       if (value != '' && value < today) {
                                                                                                         cont = false;
                                                                       }
      	                                                               return cont;
	 	  	  	  	  	  	  	       },
                                                                       "<?php echo '<br/>'.__('The date canoot be minor to this date')?>");
		              jq("#no_actionable_form").validate({});
                  });

});

<?php list($year,$month,$date) = explode('-',date('Y-m-d')); ?>

    jq('input.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo $month-1?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true

		}).addClass('float-left');


jq('#no_actionable_form').ajaxForm({

                                    beforeSubmit: function() {
                                                            //DO NOTHING
                                                           },
                                    success: function() {
                                                      <?php if (is_object($nextAction)){ ?>
 							  renderMessages('<?php echo __("action_transformed_into_no_actionable"); ?> ','success');
                                                          resize_blocks();
                                                          jq.fancybox.close();                                                          
                                                          jq('.block-id-<?php echo $nextAction->getId() ?>').fadeOut(500);
                                                      <?php } else { ?>
                                                         window.location.href = '<?php echo url_for("@".$ref.""); ?>';
                                                      <?php } ?>
                                                      }
                                    }); 

</script>
