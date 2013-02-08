<?php if ($sf_user->isAuthenticated()) { ?>

<?php
   echo image_tag('icons/review.gif')?><a href="<?php echo url_for('doing_work/export_to_ics') ?>"><?php echo __('export_to_ics') ?></a> 

<?php } ?>


