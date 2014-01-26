<?php

namespace Modera\Bundle\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TreeController extends Controller
{
    
	public function indexAction()
    {
		return $this->render('ModeraRestBundle:Tree:index.html.twig', array());
    }
	
}
