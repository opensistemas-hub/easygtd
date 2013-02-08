<?php echo form_tag('stuff_management/quick',array('id'=>'stuff_form_add'));?>
<span id="message_done"><?php echo image_tag('icons/ok.png',array('height'=>'10px','width'=>'10px', 'alt' => 'OK'));?></span>
<input accesskey="f" size="25" type="text" class="float-left defaultText" title="<?php echo __('add_stuff_to_my_inbox')?>" name="name" id="name_fast"  />
<input type="image" src="/images/icons/dot-big-green.gif" class="float-left" style="width:17px; height:17px; border:0px;" name="submit" />
<?php
echo link_to(image_tag('icons/dot-big-blue-question.gif',array('style' => 'width:20px; height:20px','alt' => 'Question')),url_for('home/helper?id=6'),array('class'=>'modal','title'=>__('help')));
?>
</form>




<script type="text/javascript">
//CLEAN THE DEFAULT  VALUE FROM FORM TEXT TAG
jq(function(){

jq('#message_done').hide();

<?php
// CASE: IF THIS PARTIAL (__quick_thoughts.php) IS LOADED FROM PROCESS URL THE LOAD THAT CONTENT USING AJAX
$ref = $_SERVER['REQUEST_URI'];
$host = $_SERVER['SERVER_NAME'];

$ref = explode('/',$ref);
$referencia = null;
$include = null;


if (isset($ref[2])) {

  $referencia = $ref[2];
  $array = explode('?',$referencia);
  if (count($array)>1) {
  list($link,$demas)= explode('?',$referencia);
  } else {
    $link = $referencia;
  }
  $referencia = $link;

}

?>
//load reference
var reference = '<?php echo $referencia; ?>';




jq('#stuff_form_add').ajaxForm(function() { 

jq('#message_done').show().fadeOut(1500);

  jq('#list-stuff').load('<?php echo url_for("stuff_management/inbox") ?>');

if ( reference == 'process' ) {
   jq('#content').load('<?php echo url_for(@process); ?>');
} else {
  //DO NOTHING
}

  renderMessages('<?php echo __("stuff_added_successful")?>','success');
  jq('#name_fast').val('');
  
   

});

});
</script>

