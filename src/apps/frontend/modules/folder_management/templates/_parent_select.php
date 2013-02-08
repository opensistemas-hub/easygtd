<select id="<?php echo $come_from ?>" name="<?php echo $come_from ?>">
              <option value="-1"><?php echo __('choose_a_folder');?></option>
              <?php 
              $select = '';
              foreach ($treeObject->fetchRoots() as $root) {
                $options = array(
                'root_id' => $root->$rootColumnName
              );
              foreach ($treeObject->fetchTree($options) as $node) {
              
                //$select = ($node['root_id'] == $node['id']) ? 'selected' : '';
                   
              ?>
              
              <option <?php echo $select?> value="<?php echo $node['id'] ?>"><?php echo str_repeat('-', $node['level']) . $node['name'];?></option>
                <?php 
               
               }
              }
              ?>
              <option value="root"><?php echo __('~On a root level'); ?></option>
</select>
              
