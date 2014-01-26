<?php
namespace Modera\Bundle\RestBundle\Component;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Modera{
	/* parse data recursively */
	
	public static function parseCsv(&$data, $childs = array()){
				
		$response = array();
		
		foreach($data as $key => $row){
			
			$result = array();
		
			if(count($childs)>0){
			
				if(array_key_exists($key, $childs)){
					
					$result['text'] = $row['name'];
					$result['id'] = $key;
					
					if(isset($data[$key]['children']) && count($row['children'])>0){
						$result['children'] = Modera::parseCsv($data, $row['children']) ;
						$result['expanded'] = true;
						
					}else{
						$result['leaf'] = true;
					}
					
					unset($data[$key]);
					
				}
			}else{
			
				if(!isset($row['parent']) || $row['parent'] == 0){
				
					$result['text'] = $row['name'];
					$result['id'] = $key;
					
					if(isset($row['children']) && count($row['children'])>0){
						// RE-Set level because it is first level item
						$result['expanded'] = true;
						$result['children'] = Modera::parseCsv($data, $row['children']);
					}else{
						$result['leaf'] = true;
					}
					// remove item from collection
					unset($data[$key]);
				}
			}
			if(count($result)>0)
				$response[] = $result;
		}
		
		return $response;
			
	}
	
	// reads data into the list/array
	public static function readCsv(){
		
		$dir = __DIR__.'/../Resources/csv';
		
		if(!file_exists("$dir/data.csv")){
			die("$dir/data.csv file does not exist, please check the file!");
		}
		
		
		$file = fopen("$dir/data.csv", "r");
		
		
		$size = '1024';
		
		$delimiter = "|";
		
		$data = array();
		
		// read data from file
		while (list($node_id, $parent_id, $node_name) = fgetcsv($file, $size, $delimiter)) {
			
			if(isset($data[$node_id]))
				$data[$node_id] = array('name' => $node_name, 'parent' => $parent_id);
			else
				$data[$node_id]['name'] = $node_name;
			
			if(!empty($parent_id)){
			
				if(isset($data[$parent_id])){
					if(!isset($data[$parent_id]['children'])){
						$data[$parent_id]['children'] = array();
					}
					
					$data[$parent_id]['children'][$node_id] = array('name'=> $node_name);
				
				}else{
					$data[$parent_id] = array();
					
					$data[$parent_id]['children'] = array();
					
					$data[$parent_id]['children'][$node_id] = array('name'=> $node_name);
				}
			}
		}
		
			
		fclose($file);

		return $data;
	}
}