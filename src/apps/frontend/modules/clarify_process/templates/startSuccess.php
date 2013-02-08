<?php include_partial('global/mensajes'); ?>

<?php 
$places = array(
                'menu'=>array(                                
                                array('name'=>__('process'),'url' => null)
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('process'))) ?>

<div id="principal">  

                <div class="content-with-shade">
            	<div class="content-general-with-mark">        
            	  <h1><?php echo __('details from stuff'); ?></h1>
                </div>
                </div>


 
    <?php if ($stuffs->count() > 0 ) { ?>   
    <div class="normal" id="clarify-content">  
      <h1>
        <?php echo __('processing'); ?> <br/>    
        <?php echo image_tag('play-small.gif',array('height'=>'10px', 'alt' => '>')) ?><b><i><?php echo $stuffs->getFirst()->getName();?></i></b>
      </h1>

      <div id="form_clarify">
        <div class="normal">
          <div class="etiqueta"><?php echo __('is_actionable?') ?>:</div>    
          <div class="valor">
            <input accesskey="y" title="<?php echo __('Accesskey') ?>: <Y>" type="radio" id="yes" name="action" value="1" checked />&nbsp;<?php echo __('yes');?>&nbsp;
            <input accesskey="n" title="<?php echo __('Accesskey') ?>: <N>" type="radio" id="no" name="action" value="2" />&nbsp;<?php echo __('no');?>&nbsp; 
          </div>
          <div class="clear"></div> 
        </div> 
      </div>

      <span id="process_form"></span>

      <script type="text/javascript">
        jq(function(){  
                     jq.get('<?php echo url_for("clarify_process/create_actionable?ref=process&stuff_id=".$stuffs->getFirst()->getId()) ?>', function(data) {
                     jq('#process_form').html(data);
                     }); 

                     jq('#no').click(function(){
                                               jq('#process_form').load('<?php echo url_for("clarify_process/create_no_actionable?ref=process&stuff_id=".$stuffs->getFirst()->getId()) ?>');
                                               });

                     jq('#yes').click(function(){  
                                                jq('#process_form').load('<?php echo url_for("clarify_process/create_actionable?ref=process&stuff_id=".$stuffs->getFirst()->getId()) ?>'); 
                                                });
                     });
      </script>
  </div>   
    <?php } else { 
    include_partial('start_process_empty');
          } ?>

</div> 
