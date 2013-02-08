
<?php 

$places = array(
                'menu'=>array(                                
                               
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('main_panel'))) ?>


<div id="principal">  

                <div class="content-with-shade">
                  <div class="content-general-with-mark"> 
                    <h1><?php echo __('welcome_to_the_main_panel_easygtd');?>.</h1>
               	  </div>
                </div>


<div class="normal">
<h1>
<?php echo __('easygtd_step') ?>
</h1>

<div class="steps">
  <ul>
    <li><?php echo link_to(__('Then start adding stuffs').'<br/><br/>'.image_tag('icons/navigation/inbox.png'),'@my_inbox',array('title'=>__(''),'class'=>'')); ?></li>
    <li><?php echo link_to(__('easygtd_step_2').'<br/><br/>'.image_tag('icons/navigation/clarify.png'),'@process',array('title'=>__(''),'class'=>'')); ?></li>
    <li><?php echo link_to(__('easygtd_step_3').'<br/><br/>'.image_tag('icons/navigation/next.png'),'doing_work/index',array('title'=>__(''),'class'=>'')); ?></li>  
  </ul>
<div class="clear"></div>
</div>


</div>

</div>
