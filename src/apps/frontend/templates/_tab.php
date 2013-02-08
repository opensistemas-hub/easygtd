<?php $hash = md5(date('Y-m-d h:j:s').rand()); ?>
<div id="dialog-confirm-action-reprocess_<?php echo $hash; ?>"><?php echo __('You sure you want to reprocess this action')?></div>

<?php try { ?>
  <table class="list">    
    <?php if ($actions->count() == 0) throw new Exception(''); ?>
    <tbody>
    <?php foreach ($actions as $action) { ?>
      <tr class="block-id-<?php echo $action->getId()?>">        
        <td>
          <div class="info_wrapper"> 
          <div class="info"> 
          <div class="info_status">              
            <span id="action_<?php echo $action->getId() ?>"></span>
          </div>
          <div class="info_list"> 
            <font title="<?php echo __('Contexts of this action') ?>" class="text-context">
              <?php include_component('doing_work','view_context_from_action',array( 'action'=>$action->getId() ))?>
            </font> 
            <span class="name-action">
              <?php echo $action->getName(); ?>
            </span>           
            <?php if ($showProject) include_component('doing_work','view_project_on_action',array('action'=>$action)); ?>
            <?php include_component('doing_work','view_information',array('action' => $action))?>
          </div>     
          <div class="info_options">               
            <span id="tab_options_<?php echo $action->getId() ?>">   
            <?php if (($action->getNextActionState()->getType() <> 'DONE') and ($action->getNextActionState()->getType() <> 'DELIVERED')) { ?>  
              <a id="edit_action_link_<?php echo $action->getId() ?>"  href="javascript:void(0);"><?php  echo image_tag('icons/clarify.png',array('alt'=>__('reprocess'),'title'=>__('reprocess')));?></a>
            <?php } else { ?>
              <!-- MANTENGO EL ESPACIO -->
              <span style="margin-top:8px;" >&nbsp;&nbsp;</span>     
            <?php } ?>          

            <?php if (($action->getNextActionState()->getType() <> 'DONE') and ($action->getNextActionState()->getType() <> 'DELIVERED')) { ?>
             <!-- BORRAR NO TIENE SENTIDO PARA ALGO YA COMPLETADO -->
                <span style="margin-top:8px;" ><?php echo link_to(image_tag('icons/dot-red.gif', array('alt' => '')),'clarify_process/create_no_actionable?next_action_id='.$action->getId(),array('class'=>'modal', 'title' => __('delete'),'id' => 'delete_action_url_'.$action->getId())); ?></span>
             <?php  } ?>      
            </span>
            </div>
            <div class="clear"></div>
          </div>
          </div>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  
  <script type="text/javascript">
  jq('#dialog-confirm-action-reprocess_<?php echo $hash; ?>').hide();  

  <?php foreach ($actions as $action){ ?>
    <?php if (($action->getNextActionState()->getType() <> 'DONE') and ($action->getNextActionState()->getType() <> 'DELIVERED')) { ?>   

  jq('#action_<?php echo $action->getId(); ?>').html('<input type="checkbox" id="action_checkbox_<?php echo $action->getId(); ?>" title="<?php echo __("mark_as_done");?>" />'); 
  jq('#action_checkbox_<?php echo $action->getId()?>').click(function(){
    jq.ajax({
      type: "POST",
      url: "<?php echo url_for('doing_work/mark_action_as_done') ?>",
      data: "next_action_id=<?php echo $action->getId(); ?>",
      success: function(){
        <?php if ($showProject) { ?> 
          jq('.block-id-<?php echo $action->getId()?>').fadeOut();
          corner_blocks();
        <?php } else { ?>
          jq('#edit_action_link_<?php echo $action->getId()?>').hide();
          jq('#delete_action_url_<?php echo $action->getId()?>').hide();
        <?php } ?>
      }, 
	error: function(){
	}
    });    
  });

  jq('#edit_action_link_<?php echo $action->getId()?>').click(function(){
    jq("#dialog-confirm-action-reprocess_<?php echo $hash; ?>").dialog({
      resizable: false,
      title: '<?php echo __("reprocess")?>',
      height:180,
      modal: true,
      open : function () {
                    resize_blocks();
             },  
      buttons: {
        '<?php echo __("yes")?>': function() {
          jq.ajax({
            type: "POST",
            success: function(){              
                window.location.href = '<?php echo url_for("@edit_action?type_action=edit&ref=".$ref."&action_id=".$action->getId()); ?>'; 
            }, 
            error: function(){
            }
          });
          jq(this).dialog('close');        
          },
        '<?php echo __("no") ?>': function() {
          jq(this).dialog('close');
        }
      }
    });  
  });

  <?php } else { ?>
  jq('#action_<?php echo $action->getId()?>').html('<input type="checkbox" id="action_checkbox_<?php echo $action->getId(); ?>" title="<?php echo __('mark_as_undone'); ?>"  checked />');  
  jq('#action_checkbox_<?php echo $action->getId()?>').click(function(){
    jq.ajax({
      type: "POST",
      url: "<?php echo url_for('doing_work/mark_action_as_to_do') ?>",
      data: "next_action_id=<?php echo $action->getId(); ?>",
      success: function(){                          
        <?php if ($showProject) { ?> 
          jq('.block-id-<?php echo $action->getId()?>').fadeOut();
          corner_blocks();
        <?php } else { ?>
         
        <?php } ?>
      }, 
      error: function(){
      }
    });  
  });
  <?php } ?>
 
<?php }// end foreach javascript php ?>
</script>
<?php  } catch (Exception $e) {
?> </table> 

<h5><?php echo $e->getMessage(); echo __('you_have_no_action'); ?>.</h5>

<script type="text/javascript">
  jq('#dialog-confirm-action-reprocess_<?php echo $hash; ?>').hide();
</script>
<?php } ?>
