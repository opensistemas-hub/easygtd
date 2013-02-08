  <input type="radio" name="repeat-choose" id="choose-no" value="1" checked=""/><?php echo __('no'); ?>
    <input type="radio" name="repeat-choose" id="choose-yes" value="2"/><?php echo __('yes'); ?>
    
    <div id="repeat-panel" style="position:relative;left:10px">
    

      <input type="radio" name="repeat-option" value="3" checked=""/><?php echo __('Everyday') ?><br/>
      <input type="radio" name="repeat-option" value="1" /><?php echo __('Mon - Wed - Fri'); ?><br/>
      <input type="radio" name="repeat-option" value="2" /><?php echo __('Tue - Thu'); ?><br/>
      <input type="radio" name="repeat-option" value="4" /><?php echo __('Once a week'); ?><br/>
      <input type="radio" name="repeat-option" value="5" /><?php echo __('Once a month'); ?><br/>
      <input type="radio" name="repeat-option" value="6" /><?php echo __('Once a year'); ?><br/>
      
      <?php echo __('Repeat until')?>:<br/> <input type="text" name="calendar-finish" value="" id="calendar-finish" />
      
    </div>
    
<script type="text/javascript">
//hide panel
jq('#repeat-panel').hide();
//render calendar for input
 <?php 
#calculate actual date
  list($year,$month,$date) = explode('-',date('Y-m-d'));
  ?>

    jq('#calendar-finish').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','Mar','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo $month -1?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true

		}).addClass('float-left');

jq('#choose-yes').bind('click',function(){
  
  jq('#repeat-panel').show();
  var altura =  jq('#fancybox-wrap').height();
 	jq('#fancybox-wrap').height(altura+150);  
   
  
});

jq('#choose-no').bind('click',function(){
  
  jq('#repeat-panel').hide();
  var altura =  jq('#fancybox-wrap').height();
 	jq('#fancybox-wrap').height(altura-150); 
 	
 

  
 	
 	 
  
});
</script>    
