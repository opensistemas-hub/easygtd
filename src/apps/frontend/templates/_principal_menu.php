<?php
/*
Obtengo la pagina actual y en base a eso cambio el select de cada menu
*/
$ref = $_SERVER['REQUEST_URI'];
$host = $_SERVER['SERVER_NAME'];

$ref = explode('/',$ref);
$referencia = null;
if($ref=="") {
	
} else {
	
	if(isset($ref[2])) {
	  
	  $referencia = $ref[2];  
	  
	} else {
	  
	  $referencia = null;  
	  
	}
	
	
	
}

$array = array(
                'menu' => array()   
         );

if ($sf_user->isAuthenticated()){ 


$array = array(
                'menu'=>array(
                                array('name'=>strtoupper(__('Capturing')),
                                       'url' => '@my_inbox',
                                       'select'=> ($referencia == 'inbox')?true:false,
                                       'accesskey'=>'C',
                                       'id'=>'capturing',
                                       'title'=>__('capture_help')
                                      ),      
                                      
                                array('name'=>strtoupper(__('Clarifying')),
                                       'url' => '@process',
                                       'select'=> ( ($referencia == 'clarify') or ($referencia == 'criteria_management') )?true:false,
                                       'accesskey'=>'P',
                                       'id'=>'clarify',
                                       'title'=>__('clarify_help')
                                      ),   

                                array(
                                      'name'=>strtoupper(__('Organizing')),
                                      'url' => '@project',
                                      'select'=> ( ($referencia == 'organize') or ($referencia == 'project') or ($referencia == 'someday') or ($referencia == 'folder_management') ) ? true:false,
                                      'accesskey'=>'O',
                                      'id'=>'organizing',

                                      'title'=>__('organize_help')
                                      ),                           

                                array(
                                      'name'=>strtoupper(__('Engaging')),
                                      'url' => 'doing_work/index',
                                      'select' => ($referencia == 'doing_work')?true:false,
                                      'accesskey'=>'E',
                                      'id'=>'engaging',
                                      'title'=>__('doing_work_help')
                                      ),
                                            
                              )             
              );

} 

$search = true;

?>
        <div id="header-menu">
          <?php if ( count($array['menu']) > 0 ) { ?>
            <ul>
        	<?php 
        	$cont = count($array['menu']);
        	$i = 0;
        	
        	foreach ($array['menu'] as $row) { 
        	
        	?>
        	          	  
        	  <?php if($row['select']) { ?>
        	
        	    <li class="header-selected"><?php echo link_to($row['name'],($row['url'] == 'homepage')?'@homepage':$row['url'],array('id'=>$row['id'],'class'=>'','accesskey'=>$row['accesskey'],'title'=>$row['title'])); ?></li>
        	
        	  <?php } else { ?>
       	    
                    <li><?php echo link_to($row['name'],($row['url'] == 'homepage')?'@homepage':$row['url'],array('id'=>$row['id'],'class'=>'','accesskey'=>$row['accesskey'],'title'=>$row['title'])); ?></li>
                             	    

          	<?php 
          	
          	} 
          	
          	$i++;
          	
        
          	}
          	
          	?>
        	</ul>
          <?php } ?>

        </div>
        <?php if ((isset($search)) && ($search) ) { ?>
          <?php if ($sf_user->isAuthenticated()) { ?>
            <div id="header-search">
              <?php echo form_tag('doing_work/search',array('method'=>'GET'))?>
                  <input title="<?php echo __('search_within_these_projects_,_actions_and_other') ?>" name="" class="header-search-button" type="image" src="/images/search_button.gif" />
                  <input id="search_query" name="q" type="text" class="header-search-field" value="" />
               </form>
            </div>
        <?php } ?>
        <?php } ?>
        

