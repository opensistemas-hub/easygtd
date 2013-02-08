<?php
/*Usage

include_partial('global/tooltip',array('id'=>'jeca','url'=>'doing_work/tabs','text'=>array('tooltip'=>'tooltip','content'=>'link')));

*/

?>
<a <?php echo (is_null($id))?'':'id="'.$id.'"'; ?> class="tooltip-show" href="<?php echo (is_null($url))?'#':url_for($url);?>" onmouseover="showtip(event, '<?php echo $text['tooltip']?>');" onmouseout="hidetip();"><?php echo html_entity_decode($text['content'])?>.</a><br>


<div id="mktipmsg" class="mktipmsg" ></div>

