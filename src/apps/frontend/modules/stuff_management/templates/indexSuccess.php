<?php 

$places = array(
                'menu'=>array(                                
                                array('name'=>__('Capturing'),'url' => null)
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('stuff')))?>

<div id="principal">               

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('manage_all_your_thoughts_before_processing');?></h1>
                </div>
                </div>


<div id="list-stuff" class="list-stuff normal">

<?php

if ( count($stuffsPager) > 0 ){ ?>
  <?php
  //PARSE THE URL FOR THE PAGINATOR
  $urls = null;
  $order = (strlen($string_order) > 0)?$string_order:null ; 
  $type = (strlen($string_type) > 0)?$string_type:null ;
  
  $nameType = ($type == 'created_at' && !(is_null($type)))?'DATE':'NAME';
  $orderType = (!is_null($order))?$order:'';  
  
  $urls = '?field='.$nameType.'&order='.$orderType;
  
  include_partial('stuff_inbox',array('stuffsPager'=>$stuffsPager,'urls'=>$urls));
  
  
  } ?>

</div>

  <div class="normal">
    <p>
      <h1><?php echo __('configuration_email_extraction'); ?></h1>    
      <?php try { ?>
        <?php if (!is_object($emailToInbox)) throw new Exception(); ?>
        <?php echo __('import_from_email_account', array('%1' => $emailToInbox->getValue())); ?>
      <?php } catch (Exception $e) { ?>
        <?php echo link_to(__('configure_email_account'), '@my_settings', array('class' => 'modal') ); ?>
      <?php } ?>
    </p>
  </div>
 
</div>

<?php if ($stuffOlder) { ?>
    <script type="text/javascript">
      renderMessages("<?php echo __('stuff_are_older'); ?>","warning");
    </script>
<?php } 
