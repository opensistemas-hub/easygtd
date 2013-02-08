    <ul id="date_select" style="margin-left:20px;">
      <li>
        <span><?php echo __('choose_folder'); ?>&nbsp;</span>
          <select name="folder_id" id="folder_id">
            <?php foreach ($folders as $folder) { ?>
            <option value="<?php echo $folder->getId(); ?>"><?php echo $folder->getName().'&nbsp;('.$folder->getFolderNoActionables()->count().')';  ?></option>
            <?php } ?>
          </select>
          <div class="clear"></div>
      </li>
    </ul>





