<?php
namespace Modera\Bundle\RestBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;


use Symfony\Component\Validator\Constraints as Assert;

class Item 
{
	/**
     * @Assert\NotBlank()
     */
	public $id;
	/**
     * @Assert\NotBlank()
     */
    public $name;
	public $parent;
	
    
}
