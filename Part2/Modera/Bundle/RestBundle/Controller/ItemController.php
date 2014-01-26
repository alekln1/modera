<?php
// src/Modera/Bundle/RestBundle/Controller/ItemController.php
namespace  Modera\Bundle\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Modera\Bundle\RestBundle\Component\Modera;

use Modera\Bundle\RestBundle\Entity\Item;

class ItemController extends Controller{

	/*
	*  @Method("POST")
	*/
	public function newAction(Request $request)
    {
		$data = Modera::readCsv();
		
		$response = array('success'=>true);
		
		$o = $request->request->all();
		
		if(isset($o['id']) && isset($o['name'])){
			
			if(array_key_exists($o['id'], $data)){
			
				$response = array('success'=>false, 'message' => 'item with current id all reade exists in a list!');
				
			}else{
			
				$id = $o['id'];
				
				$data[$id] = array();
				
				$data[$id]['name'] = $o['name'];
					
				if(isset($o['parent'])){
				
					if(!isset($data[$o['parent']])){
						$response = array('success'=>false, 'message' => 'Parent item with current id:'. $o['parent'].', does not exists');
					}else{
						$data[$id]['parent'] = $o['parent'];
						if(!isset($data[$o['parent']]['children']))
							$data[$o['parent']]['children'] = array();
						
						$data[$o['parent']]['children'][$id] = $data[$id];
						
					}
				}
				
				// return data if succeed only
				if($response['success'])
					$response['item'] = $data[$id];
			}
		}else{
			$response['success'] = false;
		}
		
		
	   
	   return new Response($this->prepareOutput($response));
        
    }
	
	/*
	*  @Method("PUT")
	*/
	public function editAction($id, Request $request)
    {	// do some edit action
       //TODO: update action
		$data = Modera::readCsv();
		
		$response = array('success'=>true);
		
		if(isset($data[$id])){
		
			$o = $request->request->all();
			
			if(isset($o['name']))
				$data[$id]['name'] = $o['name'];
				
			if(isset($o['parent'])){
				$data[$id]['parent'] = $o['parent'];
			}
			
			$response['item'] = $data[$id];
			
		}else{
			$response['success'] = false;
		}
		
		
	   
	   return new Response($this->prepareOutput($response));
    }
	
	/*
	*  @Method("DELETE")
	*/
    public function removeAction($id)
    {
        //TODO: delete action
		$response = array('success'=>true);
		
		$data = Modera::readCsv();
		
		if(isset($data[$id])){
		
			unset($data[$id]);
			
			//$response['children'] = Modera::parseCsv($data);
		
		}else{
			
			$response['success'] = false;
		}
		
		return new Response($this->prepareOutput($response));
		
    }
	

	/*
	*  @Method("GET")
	*/
	public function allAction()
    {	// get all the items
		$result = array();
		
		$data = Modera::readCsv();
		
		$result = Modera::parseCsv($data);
		
		return new Response($this->prepareOutput(array('success'=>true, 'children' => $result)));
		
    }
	
	// prepare data output depends on format type
	private function prepareOutput($data){
		
		$format = $this->getRequest()->get('_format');
		
		$serializer = new \Symfony\Component\Serializer\Serializer(array(), array(
				'json' => new \Symfony\Component\Serializer\Encoder\JsonEncoder(),
				'xml' => new \Symfony\Component\Serializer\Encoder\XmlEncoder()
		));
		// set default format
		if(empty($format)){
			$format = 'json';
		}
		return $serializer->encode($data, $format);
	}
	
    /*
	*  @Method("GET")
	*/
    public function getAction($id){
	
		$data = Modera::readCsv();
		
		if(isset($data[$id])){
		
			$response = array('success'=>true, 'item' => $data[$id]);
		
		}else{
		
			$response = array('success' =>false, 'message' => 'no such item exists in a list');
		}
		
        return new Response($this->prepareOutput($response));
    }
}