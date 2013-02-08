<h1>Create a new action for <strong><?php echo $projects->getFirst()->getName() ?></strong> project<br/> </h1>
<div id="errors">
<?php echo $form['name']->renderError(); ?>
<?php echo $form['delegate_to']->renderError();?>
</div>
<div id="actionable">
  <?php include_partial('doing_work/form_next_action', array('form' => $form, 'stuff' => $stuff,'typeNextActions' => $typeNextActions, 'type' => $type, 'contexts' => $contexts, 'times' => $times, 'priorities' => $priorities, 'energies' => $energies, 'projects' => $projects,'show_attachments' => true)); ?>
</div>

<script type="text/javascript">
  $('project_id').value = <?php echo $projects->getFirst()->getId(); ?>
</script>
