<?php

try {
  if (is_null($results)) throw new Exception('Search some value.');
  if (count($results) == 0 ) throw new Exception('No Results');
  ?>


  
<table class="list">
  <tbody> 
  <?php
    foreach ($results->getResults() as $row) {?>
      <tr>
        <td>
          <div class="info_wrapper"> 
            <div class="info"> 
              <div class="info_list"> 
                <?php
                  switch ($row->getType()) {
                    case 'PROJECTS':
                      $urls = 'project_management/index';
                      $type='project';
                    break;
                    case 'STUFFS':
                      $urls = 'stuff_management/index?found='.$row->getItemId();
                      $type='stuff';
                    break;
                    case 'SOMEDAYS':
                      $urls = 'no_actionable_item_management/some_day_maybe';  
                      $type='some day maybe';
                    break;
                    case 'REFERENCES':
                      $urls = 'no_actionable_item_management/reference';  
                      $type='reference';
                    break;
                    case 'NEXT_ACTIONS':
                      $urls = 'doing_work/index?found='.$row->getItemId();
                      $type='action';
                    break;        
                  } 
                ?>
              <?php echo link_to($row->getValue(),$urls) ?>
              <?php
                switch ($type) {
                  case 'project':
                    echo '('.__('projects').')';
                  break;
                  case 'stuff':
                    echo '('.__('stuff').')';
                  break;
                  case 'some day maybe':
                    echo '('.__('Some day item').')';
                  break;
                  case 'reference':
                    echo '('.__('references').')';      
                  break;
                  case 'action':
                    echo '('.__('actions').')';
                  break;  
                };
              ?>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </td>
      </tr>
  <?php }  ?> 
  </tbody>
</table>

 <div class="paginator">
   <?php  echo pager_navigation($results, url_for('doing_work/search?'.html_entity_decode($url).'q='.$query.''),'search_content','ajax=false') ?>
 </div>

  
  
  <?php
} catch (Exception $e) {?>

<h5>  <?php echo __($e->getMessage()); ?> </h5>


  <?php
}


?>
