<?php if (count($foldersPager) > 0) {
        include_partial('folder_list',array('foldersPager'=>$foldersPager)); 

      } else { ?>

       <h5><?php echo __('no_folders_found')?></h5>

<?php } ?>
  
