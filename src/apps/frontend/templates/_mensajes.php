<?php
   $numero = date("U") - rand(12324,89032);
   $exito_id =  date("U") - rand(12324,89032);
   $informacion_id =  date("U") - rand(12324,89032);
   $error_id =  date("U") - rand(12324,89032);
?>

<div id="mensajes_<?php echo $numero; ?>">
<?php
/*
 *
 * Muestra los mensajes del Singleton Mensajes
 */

/**
 * Si vienen mensajes en el flash los junto y los limpio.
 * 
 */

if (is_object($sf_user->getFlash('mensajes'))) {
	Mensajes::getInstance()->mezclar($sf_user->getFlash('mensajes'));
} 

if (count(Mensajes::getInstance()->getExitos()) > 0 ) {
    echo '<div class="exito" id="exito_'.$exito_id.'">';
	echo '<a class="float-right" id="cerrar_'.$exito_id.'" class="cerrar"><img src="/images/icons/-.gif"/></a>';
    echo '<ul>';
    foreach (Mensajes::getInstance()->getExitos() as $id => $mensaje){
       echo '<li style="font-size:14px;">'.__($mensaje).'</li>';
    }
    echo '</ul></div><br/>';
    ?>
    <script language="JavaScript" type="text/javascript">

       jq('#cerrar_<?php echo $exito_id; ?>').click(function(){
          jq('#exito_<?php echo $exito_id; ?>').fadeOut(500);
       });
    </script>
    <?php

}

if (count(Mensajes::getInstance()->getErrores()) > 0 ) {
    echo '<div class="error-global" id="error_'.$error_id.'">';
	echo '<a class="float-right" id="cerrar_'.$error_id.'" class="cerrar"><img src="/images/icons/-.gif"/></a>';
	echo '<ul>';
    foreach (Mensajes::getInstance()->getErrores() as $id => $mensaje){
       if (Mensajes::getInstance()->errorYaMostrado($id) != true) {
       	echo '<li style="font-size:14px;"> '.__($mensaje).' </li>';
        Mensajes::getInstance()->notificarErrorMostrados($id);
       }
    }
    echo '</ul></div><br/>';
    ?>
    <script language="JavaScript" type="text/javascript">

       jq('#cerrar_<?php echo $error_id; ?>').click(function(){
          jq('#error_<?php echo $error_id; ?>').fadeOut(500);
       });

       
    </script>
    <?php
}

if (count(Mensajes::getInstance()->getInformaciones()) > 0 ) {
    echo '<div class="informacion" id="informacion_'.$informacion_id.'">';
    echo '<a class="float-right" id="cerrar_'.$informacion_id.'" class="cerrar"><img src="/images/icons/-.gif"/></a>';
    echo '<ul>';
    foreach (Mensajes::getInstance()->getInformaciones() as $id => $mensaje){
       echo '<li style="font-size:14px;"> '.__($mensaje).' </li>';
    }
    echo '</ul></div>';
    ?>
    <script language="JavaScript" type="text/javascript">


       jq('#cerrar_<?php echo $informacion_id; ?>').click(function(){
          jq('#informacion_<?php echo $informacion_id; ?>').fadeOut(500);
       });

       
    </script>
    <?php
}

?>
</div>


<script language="JavaScript" type="text/javascript">
<?php if (Mensajes::getInstance()->getLimpiar() == true) {  ?>

   jq('#mensajes_<?php echo $numero;?>').fadeOut(500):

<?php } ?>
</script>
