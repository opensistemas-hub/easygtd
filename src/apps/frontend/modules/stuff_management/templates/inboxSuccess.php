<?php
# Esta vista es usada en la actualizacion de ajax para la lista de stuff-- No eliminar

if ( count($stuffsPager) > 0 ) {
  include_partial('stuff_inbox',array('stuffsPager'=>$stuffsPager,'urls'=>null));
} else {
  include_partial('empty_inbox_msg');
}

?>
