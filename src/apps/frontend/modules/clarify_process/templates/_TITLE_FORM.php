<?php
#partial
#just render the title new action en startSuccess.php
?>
<h1>
<?php

  if ($reference == 'clarify' || $reference == 'doing' || $reference == 'project') {
    //SO NOTHING
  } else {
    echo '<h3>'.__('new_action').'</h3>';
  }
  

 ?>
 </h1>
 <br/>
