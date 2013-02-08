<?php
#TYPE: PARTIAL
#DESCRIPTION: JAVASCRIPT TO RENDER CALENDAR WITH DATA

#The calendar is done with JQuery
#do not delete any tag with "jq"

$array_calendar = array();
$contador = 0;
$total = 0;
foreach($calendar as $key => $criteria){
 
if($criteria->getValue()!="" && preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/',$criteria->getValue())){
//parse the dates
    list($year,$month,$day) = explode('-',$criteria->getValue());
    $tmp = $month;
   // $fecha = $year.'-'.(($tmp >=10)?$tmp:'0'.$tmp).'-'.$day.'';
   $fecha = $year.'-'.$tmp.'-'.$day.'';
 }
 
if($criteria->getValue()!="" && preg_match('/^\d{1,2}\:\d{1,2}$/',$criteria->getValue())){
//parse the times
  list($hour,$minutes) = explode(':',$criteria->getValue());
  $hora = $hour.':'.$minutes;
} 
 

$array_calendar[$criteria->getNextAction()->getId()]['name']=$criteria->getNextAction()->getName();
 
if ($criteria->getType()=='TO_DO_IN_DATE_END'){
  $array_calendar[$criteria->getNextAction()->getId()]['end']=$fecha; 
  }

if ($criteria->getType()=='TO_DO_IN_DATE_START'){
  $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
 
  }

if ($criteria->getType()=='TO_DO_IN_HOUR_START'){
  $array_calendar[$criteria->getNextAction()->getId()]['time']=$hora; 
 
  }

if ($criteria->getType()=='TO_DO_IN_HOUR_END'){
  $array_calendar[$criteria->getNextAction()->getId()]['time_end']=$hora; 
 
  }     

if ($criteria->getType()=='DUE_DATE'){
  $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
 
  }  
  
if ($criteria->getType()=='FOLLOW_UP_DATE'){
  $array_calendar[$criteria->getNextAction()->getId()]['start']=$fecha; 
 
  }
  
if ($criteria->getType()=='FOLLOW_UP_TIME'){
  $array_calendar[$criteria->getNextAction()->getId()]['time']=$hora; 
 
  }  

if ($criteria->getType()=='DELEGATED_TO'){
  $array_calendar[$criteria->getNextAction()->getId()]['delegated']=$criteria->getValue(); 
 
  }




}

$total = count($array_calendar);
?>

<script type="text/javascript">


jq(document).ready(function() {
jq('#calendar_message').hide();		
	jq('#calendar').fullCalendar({
    theme: false,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		editable: true,
	  eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {

       

        if (!confirm("<?php echo __('are_you_sure_about_this_change')?>?")) {
            //retorna a la posicion anterior
            revertFunc();
        } else {
        

        
          dropFunction(event.id,dayDelta);
          
        }

    },
		disableResizing: true,
		weekends: true,
		weekMode: 'fixed'
		<?php echo (count($array_calendar) > 0)?',':'';?>


<?php if (count($array_calendar) > 0){?>

 events: [
<?php foreach ($array_calendar as $index => $row){?>
    
        {
            id     : <?php echo $index?>,
            title  : "<?php echo $row['name']; ?><?php echo (isset ( $row['delegated'] ) )? ' '.__('delegate_to').' '.$row['delegated'] :''; ?>",
            <?php if ( isset( $row['delegated'] )): ?>
            
            className: 'delegated',
            
            <?php endIf; ?>
            start  : "<?php echo $row['start']; ?><?php echo (isset($row['time']))?' '.$row['time'].':00':'' ?>"<?php echo (isset($row['end']))?',':''?>
            <?php 
              
              if (isset($row['end'])) {
              ?>
             end    : "<?php echo $row['end'].' '?><?php echo (isset($row['time_end']))?$row['time_end'].':00':'' ?>"
              <?php
              
              }
            
            ?>
        }
        <?php
          $contador++;
          echo ($contador < $total)?',':'';         
        ?>
    
<?php }//end foreach => $array_calendar ?>
],
eventClick: function(event,jsEvent) {

  loadInformation(event.id,jsEvent);

}

<?php }//end if => if count > 0 
?>
,dayClick: function(date, allDay, jsEvent, view) {
  addNewEvent(date,jsEvent);
}

	});


});

function dropFunction(id_event,days) {

    var event = id_event;
    var days_number = days;
    
    jq.ajax({
         type: "POST",
         url: "<?php echo url_for('doing_work/drop_dates');?>",
         data: "id="+event+"&days="+days_number,
         success: function(msg){
           //location.href="<?php echo url_for('@calendar') ?>";
           
           renderMessages('<?php echo __("Action edited correctly") ?>','success','calendar_message');
           jq('#calendar_message').css('margin-left','-900px');
          },
         error: function(){
            alert('no es posible realizar la operacion');
          }
       });
    
}

function loadInformation(id_event,jsEvent) {
  //alert('Event id ='+id_event);
  jq('#close-me').show();
  
  jq('#details_form').css("position","absolute").css("top",jsEvent.pageY-285).css("left",jsEvent.pageX-200).css("width","600px").css("z-index",1000);
  
  jq('#close-me').css("position","absolute").css("top",(jsEvent.pageY-290)).css("left",(jsEvent.pageX+350)).css("z-index",1001);  
 
  jq('#details_form').load('doing_work/show_details?action_id='+id_event);
  
}

function addNewEvent(date,jsEvent) {
  
  var final_date;
  final_date =jq.fullCalendar.formatDate( date, "yyyy-MM-dd");
  jq('#close-me').show();

  jq('#details_form').css("position","absolute").css("top",jsEvent.pageY-285).css("left",jsEvent.pageX-200).css("width","800px").css("z-index",1000);
  
  jq('#close-me').css("position","absolute").css("top",(jsEvent.pageY-260)).css("left",(jsEvent.pageX+350)).css("z-index",1001);  
 
  <?php 
#    echo remote_function(array(
#    'update' => 'details_form',
#    'url' => 'doing_work/form_calendar',
#    'with' => "'date='+final_date"
#    ));
  ?>
jq('#details_form').load('<?php echo url_for("doing_work/form_calendar"); ?>?date='+final_date);
  
  
}
</script>
