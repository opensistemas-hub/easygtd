<div class="content-marker"></div>
            	<div id="content-marker-title" class="float-left"><h4><?php echo __('details')?>.</h4></div>
            	<br/>
            	<br/>
            	<br/>
            	<br/>
<table>
<tr><th><h1><?php echo __('name'); ?>:</h1></th>
<td>
<h2 >
<?php echo $action->getName();?>
</h2>
</td>
</tr>
<tr><th><h1><?php echo __('description'); ?>:</h1></th>
<td><h2 >
<?php echo $action->getDescription();?>
</h2>
</td>
</tr>
<?php

  if(!is_null($type)){

?>
<tr><th><h1><?php echo $type;?>:</h1></th>
<td>
<h2 >
<?php

  foreach( $action->getInformations() as $row ){
    echo $row->getValue();
  }

?>
</h2>
</td>
</tr>
<?php

  }

?>
</table>
