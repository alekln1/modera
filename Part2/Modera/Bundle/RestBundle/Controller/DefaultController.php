<?php

namespace Modera\Bundle\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Modera\Bundle\RestBundle\Component\Modera;

class DefaultController extends Controller
{

    public function indexAction()
    {
		$data = Modera::readCsv();
		
		$response = $this->parseCsv($data);
		
        return $this->render('ModeraRestBundle:Default:index.html.twig', array('menu' => $response));
    }
	
	// parse csv to html format
	private function parseCsv(&$data, $childs = array(), $level = ''){
				
		$response = "<div>";
		
		foreach($data as $key => $row){
		
			if(count($childs)>0){
			
				if(array_key_exists($key, $childs)){
					
					$response .= $level . $row['name'] . '<br/>';
					
					if(isset($data[$key]['children']) && count($row['children'])>0){
						
						$response .=  $this->parseCsv($data, $row['children'], '-' . $level) ;
					}
					
					unset($data[$key]);
					
				}
			}else{
			
				if(!isset($row['parent']) || $row['parent'] == 0){
				
					$response .= $row['name'] . '<br/>';
			
					if(isset($row['children']) && count($row['children'])>0){
						// RE-Set level because it is first level item
						
						$response .= $this->parseCsv($data, $row['children'], '-' . $level);
					
					}
					// remove item from collection
					unset($data[$key]);
				}
			}
			
		}
		
		$response .= "</div>";
		
		return $response;
			
	}
	/*
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
	}*/
}
