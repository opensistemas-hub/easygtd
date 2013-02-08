<div id="messages">
<?php include_partial('global/mensajes'); ?>
</div>

<?php 

$places = array(
                'menu'=>array(
                                
                                
                              )             
              );
?>
<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>ucfirst( __($page) ) ))?>
  
<div id="principal">

  <div class="content-with-shade">
  <div class="content-general-with-mark">
    <h1><?php echo __($page); ?></h1>
  </div>
  </div>    

  <div class="normal">
    <?php include_partial('static',array('view'=>$page))?>
  </div>

  <br/><br/>

</div>
