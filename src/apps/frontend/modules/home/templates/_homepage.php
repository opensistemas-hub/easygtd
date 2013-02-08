

<?php include_partial('global/mensajes')?>

	 <div id="bar-big">  
         <div id="bar-big-wrapper">      
           <div class="bar-big-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('welcome_to')?> <?php echo __('you_haven_t_started_yet_._please')?> <?php echo link_to(__('login_here'),'@sf_guard_signin',array('class'=>'','accesskey'=>'l'))?></div>
           <div class="clear"></div>
         </div>
       </div>

       <div id="principal">  

	<div id="content-biglogo" style="width:710px;margin:0 auto;">
          <img src="images/easygtd-big.gif" width="607" height="211" alt="Welcome to Easy GTD" />
        </div>
    
        <div class="normal" style="margin-left:auto; margin-right: auto; width: 620px;">

   	  <div class="content-marker"></div>
          <div class="content-element">
              <a href="<?php echo url_for('home/static_content?view=start') ?>" class="text-darkgray"><?php echo __('get_started');?>:</a>
              <?php echo __('not_familiar_with_gtd?')?>
              <?php echo __('we_can_help_you_to_realize_what_you_had_been_missing')?>.
          </div>

          <div class="content-marker"></div>
          <div class="content-element">
              <a href="<?php echo url_for('home/static_content?view=faq') ?>" class="text-darkgray"><?php echo __('faq_and_help'); ?></a>
              <?php echo __('if_you_have_a_trouble_,_we_are_ready_to_assist_you');?>.
          </div>

          <div class="content-marker"> </div>
          <div class="content-element">
              <?php echo link_to(__('sign_up'),'register/index',array('class'=>'','accesskey'=>'r')); ?>
              EasyGTD <?php echo __('is_you_easiest_way_to_manage_your_life_and_proyects'); ?>.
          </div>

          <div class="clear"></div>
 
        </div>

        <br/><br/>

</div>
