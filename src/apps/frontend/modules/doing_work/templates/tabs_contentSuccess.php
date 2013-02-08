<?php include_partial('global/tab',array('actions'=>$actionsPager->getResults(),'showProject' => true,'ref' => 'doing'));?>

    <div style="clear:left; text-align:center;">
      <?php  echo pager_navigation_ajax($actionsPager, '','tab-content','getCriterias') ?>
    </div> 


