<?php

namespace Modera\Bundle\RestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Item extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'textarea');
        $builder->add('name', 'textarea');
        $builder->add('parent', 'textarea');
    }

    public function getName()
    {
        return 'item';
    }
}
