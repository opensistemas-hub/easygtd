<h4><?php echo __('Send invitations to your friends so they can join EasyGTD') ?></h4>
<br/><br/>
<?php echo ($limit-$remaining)?> <?php echo __('invitations remaining') ?>
<div id="wating_for_send"></div>
<?php echo form_tag('user_management/invite_a_friend',array('id'=>'invite_form')); ?>
<input type="text"  name="invite" class="defaultText  {email:true,messages:{email:'<?php echo  __('Not correspond to a valid email') ?>'}}" id="invite_text" title="<?php echo __('e.g. someone@example.com') ?>" />
<input class="type-button" title="<?php echo __('Only with the mail from a friend you can send an invitation to register on the site'); ?>" type="submit" value="<?php echo __('Send')?>" />
</form>

<script type="text/javascript">
defaultText();
jq('#invite_form').ajaxStart(function(){

  renderMessages('<?php echo __("Sending mail, wait a minute ...") ?>','success','wating_for_send');

});



jq('form#invite_form').ajaxForm({
    beforeSubmit: function() {
        return jq("#invite_form").validate().form();
    },
    success: function() {

        renderMessages('<?php echo __("Invitation sent") ?>','success','wating_for_send');

        jq('#invite-forms').load('<?php echo url_for("user_management/invite_a_friend") ?>');
    }
});

  

</script>
