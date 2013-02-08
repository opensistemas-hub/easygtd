<div style="background-color:#e7e2e2">
<div class="content-marker"></div>
            	<div id="content-marker-title" class="float-left"><h4><?php echo __('details')?>.</h4></div>
            	<br/>
            	<br/>
            	<br/>
            	<br/>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
  <tbody>
    <?php foreach($NextActions as $value): ?>
    <tr>
      <th><h2><?php echo __('title')?>:</h2></th>
      <td><h2 ><?php echo $value->getName() ?><h2></td>
    </tr>
    <tr>
      <th><h2><?php echo __('description_notes')?>:</h2></th>
      <td><h2 >
      <?php 
      if ($value->getDescription()){
        
        echo $value->getDescription();
      
      }else{
      
        echo __('this_action_do_not_have_description').'.';
      
      }
      
       ?></h2></td>
    </tr>  
    <tr>
        <th><h2><?php echo __('attachments')?>:</h2></th>
        <?php if(count($value->getNextActionAttachments())){?>
        <td>
          <ul>
              <?php foreach($value->getNextActionAttachments() as $nextActionAttachment ) { ?>
                    
                         <li id="attachment_<?php echo $nextActionAttachment->getId(); ?>">
                         <h2 >
                         <?php
                          $attach = explode('_',$nextActionAttachment->getValue());
                        $cont = strlen($attach[0]);
                        $attachName = substr($nextActionAttachment->getValue(),$cont+1);
                                                    
                        echo link_to($attachName,'clarify_process/download_attachment?ref=action&id='.$nextActionAttachment->getId(), array('target' => '_blank'));
                          
                         ?>
                         </h2>
                         
                     </li>
                        
                                     
               <?
               }
                ?>
          </ul> 
        </td>
        <?php }else{?>
        <td><h2 ><?php echo __('this_action_do_not_have_attachment')?></h2></td>
        <?php } ?>
    </tr>
    <?php endForeach; ?>
  </tbody>
</table>

&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>&nbsp;<br/>

&nbsp;<br/>&nbsp;<br/>

&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>

</div>
<h1 class="float-left">
<?php // echo link_to(__('return'),'doing_work/index'); ?>
<h1>


