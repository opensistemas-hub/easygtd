<div id="dialog-confirm"><?php echo __('Are you sure you want to remove this criteria?') ?></div>
<div id="dialog-reasign-confirm"><?php echo __('if_you_want_to_delete_a_criteria_with_action_,_you_need_to_asociate_all_actions_with_this_criteria_a_new_criteria_._are_you_sure_to_continue'); ?></div>
 
<table class="list">
  <tbody> 
    <?php foreach ($criteriasPager->getResults() as $criteria) { ?>
    <tr id="criteria-div-<?php echo $criteria->getId() ?>">
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php echo __($criteria->getType());  ?>: 
          <?php $unit = ($criteria->getUnit() == 'NULL') ? "" : ucwords(strtolower(__($criteria->getUnit()))); 
                echo $criteria->getValue(); ?>
          </div>     
          <div class="info_options">
            <?php $check= false;
            //recorre el array generado con el tipo de criterio y cuantas veces esta repetido
            foreach($TypeCriteriaCount as $key => $row){
             if($row['value'] == $criteria->getType() && $row['count'] > 1  ){
               //valida si el criterio esta repetido en tipo y si tiene mas de uno en cuanto a tipo permite eliminarlo sino pregunta para pasar de un tipo al otro
               foreach ($criteria->getCriteriaNextActions() as $d){
                 if ($d->getCriteria()->getId()==$criteria->getId()) {
                   $check = true;
                 } else {
                   //DO NOTHING
                 }
               }
               //if check == true means what that criteria had a action
               if ($check) {
                 //asks if you want to change all partners to a new context                         
                 ?>
                 <?php                        
                 echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'criteria_management/edit?id='.$criteria->getId(),array('class'=>'modal', 'id' => 'edit_url_'.$criteria->getId() , 'title' => __('edit'))); ?>                      
                 <a title="<?php echo __('delete'); ?>" id="delete_reasign_url_<?php echo $criteria->getId(); ?>" href="javascript:void(0);"><?php echo image_tag('icons/dot-red.gif',array('class'=>'', 'alt' => '')); ?></a>
                 <script type="text/javascript">
                   jq('#delete_reasign_url_<?php echo $criteria->getId(); ?>').click(function(){
		         jq("#dialog-reasign-confirm").dialog({
                           resizable: false,
                           title: '<?php echo __("delete"); ?>',
		           height:180,
		           modal: true,
		           buttons: {
			       '<?php echo __("yes")?>': function() {
				                                jq.ajax({
				                                        type: "DELETE",
				                                        url: "<?php echo url_for('criteria_management/dummy'); ?>",
				                                        data: "id=-1",
				                                        success: function(){
                                                                                   jq(this).dialog('close');
				                                                           location.href='<?php echo url_for('criteria_management/change_criteria?type='.$criteria->getType().'&id='.$criteria->getId().'&filter='.$filter); ?>'
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
                 </script>
            <?php } else { ?>            
              <?php echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'criteria_management/edit?id='.$criteria->getId(),array('class'=>'modal', 'id' => 'edit_url_'.$criteria->getId(), 'title' => __('edit') ));?>                      
              <a title="<?php echo __('delete'); ?>" id="delete_url_<?php echo $criteria->getId(); ?>" href="javascript:void(0);"><?php echo image_tag('icons/dot-red.gif',array('class'=>'', 'alt' => '')); ?></a>        
                <script type="text/javascript">
                jq('#delete_url_<?php echo $criteria->getId(); ?>').click(function(){
		jq("#dialog-confirm").dialog({
		  resizable: false,
		  title: '<?php echo __("delete"); ?>',
		  height:180,
		  modal: true,
		  buttons: {
			   '<?php echo __("yes")?>': function() {
				                                jq.ajax({
				                                        type: "DELETE",
				                                        url: "<?php echo url_for('criteria_management/delete') ?>",
				                                        data: "id=<?php echo $criteria->getId(); ?>&filter=<?php echo $filter ?>",
				                                        success: function(){
				                                                           jq('#criteria-div-<?php echo $criteria->getId() ?>').fadeOut(500);
				                                                           jq('#criteria-list').load('<?php echo url_for("criteria_management/ajax_list"); ?>', function(response, status, xhr) {
												 if (status == "success") {
												   <?php include_partial('global/modal'); ?> 
                                                                                                 corner_blocks();              
												 } 
											      });								
                                                                                           }, 
				                                        error: function(){
				                                                         alert('error no se puede procesar');
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
                </script>

            <?php }            
           }
        }
        ?>
        </div>
        <div class="clear"></div>
        </div>
        </div>
      </td>      
    </tr>
    <?php } ?>
  </tbody>
</table>
    
  <div style="clear:left; text-align:center;" class="paginator">
    <?php  echo pager_navigation($criteriasPager, url_for('criteria_management/index?filter='.$filter)) ?>
  </div>

 
<script type="text/javascript">

jq('#dialog-confirm').hide();
jq('#dialog-reasign-confirm').hide();
    

</script>
    
