<?php 
$places = array(
                'menu'=>array(
                              array('name'=>__('search_results'),'url'=>null),
                              
                             )
                );
$check = null;
$url = '&';  
$check[0] = (strlen($types['project']) > 0)?true:false;
$check[1] = (strlen($types['next_action']) > 0)?true:false;
$check[2] = (strlen($types['stuff']) > 0)?true:false;
$check[3] = (strlen($types['someday']) > 0)?true:false;
$check[4] = (strlen($types['reference']) > 0)?true:false;

foreach ($types as $link) {
  if (strlen($link) == 0) {
    //DO NOTHING
  } else {
    $url .= strtolower($link).'_type=true&';
  }
}

?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('search'),'helper'=>false))?>

<div id="principal"> 

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('search_within_these_projects_,_actions_and_other');?>.</h1>
                </div>
                </div>

<div class="normal">
  <div id="search-fields">

    <?php echo form_tag('doing_work/search',array('method'=>'GET'));?>    
    
   <input type="text campo_de_texto" value="<?php echo $query?>" name="q" />&nbsp;<input type="submit" value="<?php echo __('search')?>" /></div>
   <div class="clear"></div>   
 
    </form>
  </div>
  <div id="search_content" class="normal">
    <?php include_partial('search',array('results'=>$results,'query'=>$query,'url'=>$url)); ?>
  </div>
  <div class="clear"></div>
  <br/><br/>
</div>
</div>
