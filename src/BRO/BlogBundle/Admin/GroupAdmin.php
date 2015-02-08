<?php

namespace BRO\BlogBundle\Admin;

//use FOS\UserBundle\Model\UserManagerInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\UserBundle\Admin\Model\GroupAdmin as Admin;

class GroupAdmin extends Admin {

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper) {
        parent::configureFormFields($formMapper);
        
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {

        parent::configureListFields($listMapper);

    }
    
    
}
