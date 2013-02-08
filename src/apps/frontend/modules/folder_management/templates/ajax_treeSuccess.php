<div id="folder-render">

 <textarea id="tree_html" rows="40" cols="50" style="display:none">
      <?php include_partial('tree',array('treeObject'=>$treeObject,'rootColumnName'=>$rootColumnName,'folders'=>$folders)) ?>  
 </textarea>
 
 <div id="tree"></div>
  
  </div>
  
  
<br/>

            	<br/>
            	<br/>


<?php include_partial('javascript-tree',array('folders'=>$folders)); ?>
