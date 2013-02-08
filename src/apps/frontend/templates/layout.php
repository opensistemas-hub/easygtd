<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="shortcut icon" href="/images/favicon.ico" />

 <?php include_http_metas(); ?>
 <?php include_metas(); ?>
 <?php include_title(); ?>
 <?php include_stylesheets() ?>
 <?php include_javascripts() ?>
 <!--[if IE]>
   <?php echo stylesheet_tag('ie')?>
 <![endif]--> 

</head>
<body>

<div id="wrapper">

    <div id="app-top-settings">
      <?php if ($sf_user->isAuthenticated()) {
              echo __('welcome').'&nbsp;'; 
              echo $sf_user->getUserName(); 
              echo "&nbsp;|&nbsp;";
              echo link_to(__('Criterias'),'criteria_management/index', array('class'=>'','title' => __('criterias_help')));        
              echo "&nbsp;|&nbsp;";
              echo link_to(__('settings'),'@my_settings', array('class' => 'modal','title' => __('settings_help'))); 
              echo "&nbsp;|&nbsp;";
              echo link_to(__('logout'),'@sf_guard_signout',array('class'=>'','accesskey'=>'l', 'title' => __('logout_help')));
            } else {
              echo __('you_haven_t_started_yet_._please');
              echo link_to(__('login_here'),'@sf_guard_signin',array('class'=>'','accesskey'=>'l')); 
            }
       ?>
      </div>
      <div class="clear"></div>

  <div id="app-top">
    <div id="header">
      <div id="header-logo"></div>
      <?php  include_partial('global/principal_menu')?>
      <div class="clear"></div>
    </div>
  </div>  
    
  <div id="content">       
    <?php echo $sf_content; ?>
    <div class="clean"></div>
  </div>

  <div class="footer">
    <a href="http://support.easygtd.com" target="blank">Soporte</a>&nbsp;|&nbsp;<?php echo link_to(__('conditions'),'home/static_content?view=site_conditions'); ?>
  <br/>  <br/>
  &copy; <?php echo date('Y'); ?> EasyGTD. EasyGTD es un producto para implementar la metodología GTD, la metodología GTD es propiedad de su creador David Allen. <br/> EasyGTD es un producto Open Source</div>
  
</div>


<script type="text/javascript">


function resize_blocks() {

  // LOGO & SEARCH width: 135px;
  var menuWidth = jq('#header').width() - jq('#header-logo').width() - jq('#header-search').width() - 20;
  jq('#header-menu').width(menuWidth);
  jq('#header-menu ul').width(menuWidth);
  jq('#header-menu ul li').width((menuWidth - 20 )/4);

  if (jq('#focus').length != 0) {
    var panelWidth = jq('#principal').width() - jq('#focus').width() - 1;
    jq('#todo_list').width(panelWidth);
    jq('#focus .content-with-shade').corner("8px left");      
    jq('#todo_list .content-with-shade').corner("8px right");     
  }
}

function corner_blocks(){
  jq('#app-top').corner("8px");
  jq('#bar-big-wrapper').corner("8px").parent().css('padding','1px').corner("round 8px");
  jq('#principal').corner("8px");
  if (jq('#focus').length == 0) {
    jq('.content-with-shade').corner("8px");    
  }

  jq('.info').each(function () {
    jq(this).corner("8px").parent().corner("8px");
  });


  //link en header logo
  jq('#header-logo').click(function(){
    location.href='<?php echo url_for("@homepage")?>';  
  }); 
}

jq(function(){

  resize_blocks();
  corner_blocks();

  jq(window).bind('resize', function () { 
    resize_blocks();
  });

  <?php include_partial('global/modal'); ?>  

});



</script>
</body>
</html>
