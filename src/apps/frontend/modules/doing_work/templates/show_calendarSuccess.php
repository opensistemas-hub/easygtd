<?php 
echo javascript_include_tag('app/fullcalendar-'.$culture.'.min.js');
include_partial('calendar_process',array('calendar'=>$calendar))
?>

<div id="messages">
<?php include_partial('global/mensajes'); ?>
</div>

<?php 
$places = array(
                'menu'=>array(
                              array('name'=>__('Organizing'),'url'=>'@project'),
                              array('name'=>__('calendar'),'url'=>null)
                )
                );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('calendar'),'helper'=>false))?>
<div class="block-float-left">
<div class="content-marker"></div>
            	<div id="content-marker-title"><h3><?php echo __('manage_your_scheduled_events_through_the_calendar');?>.</h3></div>
</div>            	
            	<br/>
            	<br/>
            	<br/>
            	<br/>


<div id="calendar_message" align="center"></div>
<br/><br/>
<div id="render-calendar" style="position: relative; margin-left: 25px;">
  
  <?php include_partial('calendar')?>

</div>

<div id="details_form" style="z-index:8;"></div>
<span class="float-right" ><?php echo image_tag('icons/close.png',array('style'=>'z-index:9','id'=>'close-me')) ?></span>
<span id="loading" class="float-left"><?php echo __('loading')?>...</span>

</div><!-- end navigation bar -->
<script type="text/javascript">

jq('#loading').hide();
jq('#close-me').hide();
 
 jq('#close-me').click(function(){

  jq('#details_form').html('');
  jq('#close-me').hide();

 });
  
</script>

