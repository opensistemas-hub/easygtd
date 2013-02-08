<div id="bar-big">
  <div id="bar-big-wrapper">
  <div id="bar-big-left">
  <a accesskey="0" href="<?php echo url_for('homepage')?>"><?php echo image_tag('bar-big-home.gif',array('class'=>'float-left ico-home', 'alt' => "big-home")) ?></a>
  <div class="bar-big-to"></div>
  <?php foreach ($places['menu'] as $place) { ?>        	
    <div class="bar-big-text">
      <?php           
        if(!(is_null($place['url']))) {             
          echo link_to($place['name'],$place['url'], array('class' => ''));
        } else {
          echo $place['name'];             
        }    
      ?>
    </div>
    <div class="bar-big-to"></div>
  <?php } ?>  

    </div>

    <div id="bar-big-text-right">
      <?php include_partial('global/sidebar'); ?>
    </div>

    <div class="clean"></div>
  </div>
</div>
