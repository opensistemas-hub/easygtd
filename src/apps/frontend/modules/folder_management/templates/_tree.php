<?php 

  function getLi($folder) {
    
    $out = '<li id="folder_id_'.$folder->getId().'"><img width="25" height="25" src="/images/icons/folder.gif" /> ' .'<a id="folder_id_'.$folder->getId().'">'. $folder->getName().'</a>';
    
    //SHOW NO ACTIONABLE ITEMS RELATED
		if ($folder->getFolderNoActionables()->count() > 0) {
		
		  $out .= '<ul>';
		
		  foreach ($folder->getFolderNoActionables() as $FolderNoActionRel) {
		
		    $out .= '<li id="action_id_'.$FolderNoActionRel->getNoActionableItem()->getId().'"><img width="25" height="25" src="/images/icons/closednotepad.gif" /><a id="action_id_'.$FolderNoActionRel->getNoActionableItem()->getId().'">'.$FolderNoActionRel->getNoActionableItem()->getName().'</a></li>';
		
		  }	
		
		  $out .= '</ul>';
		
		}
    
    		return $out;
    
  }
  
  function justLi($folder) {
    
    $out = '<li id="folder_id_'.$folder->getId().'">'.'<a id="folder_id_'.$folder->getId().'">'. $folder->getName().'</a>';
    
    return $out;
        
  } 

//Here we store the level of the last item we printed out
		$lastLevel = 0;
		
		//Outer list item
#		$html = '<ul class="mktree">';
    $html = null;		
		//Iterating all tree roots
		foreach ( $treeObject->fetchRoots () as $root ) {
			$options = array ('root_id' => $root->$rootColumnName );
			
			//Iterating tree from a current root
			foreach ( $treeObject->fetchTree ( $options ) as $node ) {
				 
				//If we are on the item of the same level, closing <li> tag before printing item
				if (($node ['level'] == $lastLevel) and ($lastLevel > 0)) {
					$html .= '</li>';
				}
				
				//If we are printing a next-level item, starting a new <ul>
				if ($node ['level'] > $lastLevel) {
					$html .= '<ul>';
				}
				
				//If we are going to return back by several levels, closing appropriate tags 
				if ($node ['level'] < $lastLevel) {
					$html .= str_repeat ( "</li></ul>", $lastLevel - $node ['level'] ) . '</li>';
				}
				
				//Priting item without closing tag
				$html .= (isset($clean))?justLi ($node):getLi ( $node );
				
				//Refreshing last level of the item
				$lastLevel = $node ['level'];
			}
			
		//$this->renderText ( $html );
		}
#		$html .= "</ul>";
		
		echo $html;
		
		?>
