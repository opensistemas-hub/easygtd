<div>             
            	<div class="content-marker"></div>
            	<div id="content-marker-title" class="float-left"><h4>Show Actions</h4></div>
        		
        		<div class="content-header-text">to be done in</div>
                <div class="float-left">
                
                
                <select id="time_id">
                  <option value="-1">-- All --</option>
                  <?php foreach($timeCriterias as $ncriteria){?>
                  <option value="<?php echo $ncriteria->getId()?>"><?php echo $ncriteria->getValue() ?> <?php echo $ncriteria->getUnit() ?></option>
                  <?php } ?>
                </select>
                            
                </div>
            
            
            
                <div class="content-header-text">and energy needed</div>
                <div class="float-left">
                	<select id="energy_id" name="energy-criteria">
                    <option value="-1">-- All --</option>
                    <?php foreach ($energyCriterias as $ncriterias) {?>
                    <option value="<?php echo $ncriterias->getId()?>"><?php echo $ncriterias->getValue() ?></option>
                    <?php } ?>
                  </select>
                	
                	
					      </div>
					      
					      
					  <div class="content-header-text">and priority needed</div>
                <div class="float-left">
                
                <select id="priority_id" name="priority-criteria">
                 <option value="-1">-- All --</option>
                 <?php foreach ($priorityCriterias as $ncriterias) {?>
                 <option value="<?php echo $ncriterias->getId()?>"><?php echo $ncriterias->getValue() ?></option>
                <?php } ?>
                </select>
                
                
					      </div>
					      
					      
					  <div class="content-header-text">and Kind needed</div>
                <div class="float-left">
                
              <select id="type" name="type-criteria">
                <option value="-1">-- All --</option>
                <?php foreach ($typeNextActions as $type) {?>
                <option value="<?php echo $type->getDiscriminator(); ?>"><?php echo $type->getMessage() ?></option>
                <?php } ?>
              </select>
                
                
					      </div>
					      
					      
					    <div class="content-header-text">and Kind needed</div>
                <div class="float-left">
                
                   &nbsp; Done?
                <input type="checkbox" id="done_status" name="done_status" value="0"/> 
                
                
					      </div>          
					      
					      
          	
          </div>
