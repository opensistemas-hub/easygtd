<?php echo form_tag('no_actionable_item_management/save_new_reference',array('name'=>'add_new_reference','id'=>'add_new_reference','enctype'=>'multipart/form-data')); ?>
<div id="errors">
<?php
echo $form['name']->renderError();
 ?>
</div>
<div class="content-marker"></div>
            	<div id="content-marker-title" class="float-left"><h4><?php echo __('add_new_reference')?>.</h4></div>
            	<br/>
            	<br/>
            	<br/>
            	<br/>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
<tr>
<th><?php echo __('name')?></th>
<td><?php echo $form['name']->render(array('class'=>'required','title'=>__('the_name_is_required'))) ?></td>
</tr>
<tr>
<th><?php echo __('description')?></th>
<td><?php echo $form['description']->render() ?></td>

</tr>
<tr>
  <th><?php echo __('folder')?></th>
  <td>
    <select id="folder_id" name="folder_id" title="<?php echo __('choose_some_folder')?>" validate="required:true">
      <option value="">--<?php echo __('choose_some_folder')?>--</option>
      <?php 
        foreach ($folders as $key => $folder)
        {
          ?>
           <option value="<?php echo $folder->getId() ?>"><?php echo $folder->getName(); ?></option>
          <?php
        }
       ?>
    </select>
  </td>
</tr>
<tr>
        <th><?php echo __('attachments')?></th>
        <td id="no_actionable_attachments">
        
          <div>
            <input type="file" name="attach" onchange="setBlock();" />
<div id="moreUploads"></div>
<div id="moreLink2" style="display:none;">


<a href="javascript:addFileInput();"><?php echo __('add_other_file')?>.</a>
</div>
          </div>
        </td>
</tr>
<tr>
  <td colspan="2"> <input type="submit" value="<?php echo __('add_new_reference')?>" /> </td>
</tr>
</table>
<div id="actualiza"></div>
</form>

<script type="text/javascript">

jq(function () {


    jq.metadata.setType("attr", "validate");

		jq("#add_new_reference").validate();  
  
});
</script>

