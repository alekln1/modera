<?php

			$file = fopen('data.csv', "r");
			$headerMatched = false;
			$query = '';
			$size = '1024';
			$delimiter = "|";
			$data = array();
			$result = array();
			
			function doItAll(&$data, $childs = array(), $level = '')	{
				
				$response = "<div>";
				
				foreach($data as $key => $row){
					if(count($childs)>0){
						if(array_key_exists($key, $childs)){
						
							$response .= $level . $row['name'] . '<br/>';
							
							if(isset($data[$key]['childs']) && count($row['childs'])>0){
								
								$response .= doItAll($data, $row['childs'], '-' . $level);
							}
							
							unset($data[$key]);
							
						}
					}else{
					
						if(!isset($row['parent']) || $row['parent'] == 0){
						
							$response .= $row['name'] . '<br/>';
					
							if(isset($row['childs']) && count($row['childs'])>0){
								// RE-Set level because it is first level item
															
								$response .= doItAll($data, $row['childs'], '-' . $level);
							
							}
							// remove item from collection
							unset($data[$key]);
						}
					}
					
				}
				$response .= "</div>";
				
				return $response;
			}
			
			// read data from file
			while (list($node_id, $parent_id, $node_name) = fgetcsv($file, $size, $delimiter)) {
				
				if(isset($data[$node_id]))
					$data[$node_id] = array('name' => $node_name, 'parent' => $parent_id);
				else
					$data[$node_id]['name'] = $node_name;
				
				if(!empty($parent_id)){
				
					if(isset($data[$parent_id])){
						if(!isset($data[$parent_id]['childs'])){
							$data[$parent_id]['childs'] = array();
						}
						
						$data[$parent_id]['childs'][$node_id] = array('name'=> $node_name);
					
					}else{
						$data[$parent_id] = array();
						
						$data[$parent_id]['childs'] = array();
						
						$data[$parent_id]['childs'][$node_id] = array('name'=> $node_name);
					}
				}
			}
			

			
			fclose($file);
			// print out result
			print doItAll($data);
?>