<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('modera_rest_homepage', new Route('/', array(
    '_controller' => 'ModeraRestBundle:Default:index',
)));

$collection->add('modera_rest_tree', new Route('/tree', array(
    '_controller' => 'ModeraRestBundle:Tree:index',
)));

return $collection;

