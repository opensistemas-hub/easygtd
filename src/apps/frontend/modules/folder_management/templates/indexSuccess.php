<?php include_partial('global/mensajes'); ?>
<?php 

$places = array(
                'menu'=>array(
                                
                                array('name'=>__('Organizing'),'url' => '@project'),
                                array('name'=>__('references'),'url' => null)
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('references'))) ?>

<div id="principal">               

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('manage_your_references');?></h1>
                </div>
                </div>
          
<div id="list-folder" class="normal">

<?php if (count($foldersPager) > 0) {
        include_partial('folder_list',array('foldersPager'=>$foldersPager)); 

      } else { ?>

       <h5><?php echo __('no_folders_found')?></h5>
<?php } ?>
  
</div>

</div>
