<?php
namespace Modera\Bundle\RestBundle\Components;

class Modera{

	$this->data = array();
	
	public function __construct(){
		$this->data = $this->readCsv();
	}
	
	public function getData(){
		return $this->data;
	}
	
	private function readCsv(){
		
		$dir = __DIR__.'/../Resources/csv';
		
		$file = fopen("$dir/data.csv", "r");
		
		$headerMatched = false;
		
		$query = '';
		
		$size = '1024';
		
		$delimiter = "|";
		
		$data = array();
		
		$result = array();
		
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
		//print '<pre>';
		//var_dump($data);
		return $data;
	}
}