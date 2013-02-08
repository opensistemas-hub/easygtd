<h1>Edit an action</h1>
<div id="errors">
<?php echo $form['name']->renderError(); ?>
<?php echo $form['delegate_to']->renderError();?>
</div>
<div id="actionable">
  <?php include_partial('doing_work/form_next_action', array('form' => $form, 'stuff' => $stuff,'typeNextActions' => $typeNextActions, 'type' => $type, 'contexts' => $contexts, 'times' => $times, 'priorities' => $priorities, 'energies' => $energies, 'projects' => $projects, 'show_attachments' => true, 'nextAction' => $nextAction)); ?>
</div>
