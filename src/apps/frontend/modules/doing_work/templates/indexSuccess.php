<?php include_partial('global/mensajes'); ?>
<?php 

$places = array(
                'menu'=>array(                                
                                array('name'=>__('DOING_WORK'),'url' => null)
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('DOING_WORK'),'tabs_doing_work'=>true)) ?>

<div id="principal">  

  <div id="focus">
    <div id="saved_searchs"></div>      
  </div>

  <div id="todo_list">
    <div class="content-with-shade">
      <div class="content-general-with-mark" style="z-index:999;">
        <h1><?php echo __('show_actions') ?>.</h1>
      </div>
    </div>

    <div class="normal"> 
           	
      <div id="criterias">
        <?php include_component('doing_work','view_criterias')?>
      </div>

      <div id="tabs-context"></div>

      <br/><br/>
    </div>
  </div>
  <div class="clear"></div>

</div>

<script type="text/javascript">

//Variables de filtro: -1 es comodín - todos los valores.
var type = -1; 
var context = -1; 
var time = -1; 
var energy = -1; 
var priority = -1; 
var done = 0;
var dueToday = 0;
var onlyDate = 0;
var projectId = -1;
var searchId = -1;
var page = 1;


function getCriterias(page) {  
  
  jq("#tabs-context").html('<?php echo image_tag("icons/navigation/spinner.gif"); ?>');
  if (page == null){
   page = 1;
  }
 
  var exactDate = 0;
  if (jq('#focus_today').hasClass('selected')) exactDate = 1;
  jq('#tabs-context').load('doing_work/tabs_content?done=' + done + '&project_id=' + projectId + '&page='+ page + '&only_date=' + onlyDate + '&due_today=' + dueToday + '&context_id=' + context + '&time_id=' + time + '&energy_id=' + energy + '&priority_id=' + priority + '&type_id=' + type + '&exact_date=' + exactDate + '&timezone_offset=' + new Date().getTimezoneOffset() , function(response, status, xhr) {
         if (status == "success") {
           resize_blocks();
           corner_blocks();
           <?php include_partial('global/modal'); ?>                
           jq.fancybox.close();
         } 
      });   
}

    
jq('#time_id').bind('propertychange change',function(){  
  time = jq('#time_id').val();
});

jq('#energy_id').bind('propertychange change',function(){
  energy = jq('#energy_id').val();
});

jq('#priority_id').bind('propertychange change',function(){  
  priority = jq('#priority_id').val(); 
});

jq('#done_checkbox').bind('click',function(){
  if (jq('#done_checkbox').attr('checked')) {
    done = 1;
  } else {
    done = 0;
  } 
});

jq('#context_id').bind('propertychange change',function(){
  context = jq('#context_id').val();
});   

jq('#search_next_actions').bind('click',function(){
  getCriterias();  
}); 

function actualizaSpan(){
    
}

function activeToday(){
  jq('.saved_search_link').each(function () {
                jq(this).removeClass("selected");
  });
  jq('#focus_today').addClass('selected');
  type = -1;
  dueToday = Math.round((new Date()).getTime() / 1000);
  //Actualiza el valor del formulario en fecha
  jq('#due_date').val(Math.round(dueToday) * 1000);  
  onlyDate = 0;
  //SPAN
  actualizaSpan(); 
  getCriterias();    
}

function activeNextActions(){
  jq('.saved_search_link').each(function () {
                jq(this).removeClass("selected");
  });
  jq('#focus_next_actions').addClass('selected');
  type = -1;
  dueToday = Math.round(jq('#due_date').val() / 1000);
  onlyDate = 0;
  getCriterias();
}

//Excepcióin para el selector de fechas:
function onDueDateChange() {
  //Due Date toma el valor del input
  dueToday = Math.round(jq('#due_date').val() / 1000);
  if (jq('#focus_today').hasClass('selected')) {
      //Activo el next Actions ícono.
      jq('.saved_search_link').each(function () {
                jq(this).removeClass("selected");
      });

      jq('#focus_next_actions').addClass('selected');
      type = -1;
      onlyDate = 0;
    }

  //SPAN
  actualizaSpan();   
}
  

function activeDelegated(){
  jq('.saved_search_link').each(function () {
                jq(this).removeClass("selected");
  });
  jq('#focus_delegated').addClass('selected');
  type = "DELEGATED"; 
  dueToday = Math.round(jq('#due_date').val() / 1000);
  onlyDate = 0;
  getCriterias();
}

function activeScheduled(){
  jq('.saved_search_link').each(function () {
                jq(this).removeClass("selected");
              });
  jq('#focus_scheduled').addClass('selected');
  type = -1; //todos los tipos mientras tenga alguna fecha.
  dueToday = Math.round(jq('#due_date').val() / 1000);
  onlyDate = 1;
  getCriterias();
}

//Cargo la palabra de búsqueda
searchId = '<?php echo $searchId; ?>';

function loadSavedSearch() { 
  //Cargo el panel de búsquedas guardadas
  jq('#saved_searchs').load('doing_work/show_saved_search_list', function (response, status, xhr) { 
    if (status == "success") {
      //Por defecto cargo el active Today & todos los proyectos!
      if (searchId == -1) {
        activeToday();
      } else {
        //No marco ningún foco, porque estoy buscando un ID
        jq('#tabs-context').load('doing_work/tabs_content?search_id=' + searchId + 'project_id=' + projectId + '&page='+ page + '&only_date=' + onlyDate + '&due_today=' + dueToday +'&context_id=' + context + '&time_id=' + time + '&energy_id=' + energy + '&priority_id=' + priority + '&type_id=' + type , function(response, status, xhr) {
          if (status == "success") {
            corner_blocks();
            <?php include_partial('global/modal'); ?>                       
          } 
        });
      }
    }
  });
}

loadSavedSearch();       

</script>
<!--
<?php //NO BORRAR ESTA SECCION, SE USA PARA QUE EL ARCHIVO DE MENSAJES TENGA EL VALOR DE LOS TIPOS: 

 echo __('done_now_-_take_less_than_2_minutes');
 echo __('delegated');
 echo __('do_as_soon_as_i_can');
 echo __('put_into_my_calendar');

 echo __('TIME_AVAILABLE');
 echo __('ENERGY');
 echo __('PRIORITY');
 echo __('CONTEXT');

?>
-->
