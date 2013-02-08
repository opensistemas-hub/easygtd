<?php

$places = array(
                'menu'=>array(
                              array('name'=>__('Organizing'),'url'=>'@project'),
                              array('name'=>__('some_day_items'),'url'=>null)
                )
                );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('some_day_items'))) ?>
              
<div id="principal">

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('items_you_should_do_some_day');?>.</h1>
                </div>
                </div>

<div class="normal" id="info_list">
  <?php include_partial('some_day_list',array('somedayPager'=>$somedayPager))?>
</div>

</div>
