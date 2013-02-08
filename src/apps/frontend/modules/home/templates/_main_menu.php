<li><?php echo link_to('home','@homepage'); ?></li>

<li><?php echo link_to('Inbox','stuff_management/index', array('accesskey' => sfConfig::get('app_INBOX'),'title' => sfConfig::get('app_MSG_INBOX'))); ?></li>

<li><?php echo link_to('Capture stuff','stuff_management/new', array('accesskey' => sfConfig::get('app_CAPTURE'),'title' => sfConfig::get('app_MSG_CAPTURE'))); ?></li>

<li><?php echo link_to('Criterias','criteria_management/index', array('accesskey' => sfConfig::get('app_CRITERIA'),'title' => sfConfig::get('app_MSG_CRITERIA'))); ?></li>

<li><?php echo link_to('Project','project_management/index', array('accesskey' => sfConfig::get('app_PROJECT'),'title' => sfConfig::get('app_MSG_PROJECT'))); ?></li>

<li><?php echo link_to('Process','clarify_process/start', array('accesskey' => sfConfig::get('app_PROCESS'),'title' => sfConfig::get('app_MSG_PROCESS'))); ?></li>

<li><?php echo link_to('Doing Work','doing_work/index', array('accesskey' => sfConfig::get('app_DOING_WORK'),'title' => sfConfig::get('app_MSG_DOING_WORK'))); ?></li>

<li><?php echo link_to('Done','doing_work/list_next_actions_done', array('accesskey' => sfConfig::get('app_DONE'),'title' => sfConfig::get('app_MSG_DONE'))); ?></li>

<li><?php echo link_to('My Folders','folder_management/index', array('accesskey' => sfConfig::get('app_FOLDER'),'title' => sfConfig::get('app_MSG_FOLDER'))); ?></li>

<li><?php echo link_to('References','no_actionable_item_management/reference', array('accesskey' => sfConfig::get('app_REFERENCE'),'title' => sfConfig::get('app_MSG_REFERENCE'))); ?></li>

<li><?php echo link_to('Some Day Maybe','no_actionable_item_management/some_day_maybe', array('accesskey' => sfConfig::get('app_SOMEDAY'),'title' => sfConfig::get('app_MSG_SOMEDAY'))); ?></li>

<li><?php echo link_to('Calendar','doing_work/show_calendar', array('accesskey' => sfConfig::get('app_CALENDAR'),'title' => sfConfig::get('app_MSG_CALENDAR'))); ?></li>
