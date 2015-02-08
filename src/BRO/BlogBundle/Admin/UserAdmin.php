<?php

namespace BRO\BlogBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;

use Sonata\AdminBundle\Form\FormMapper;
//use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
//use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as Admin;

class UserAdmin extends Admin {

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper) {
        parent::configureFormFields($formMapper);
        /*
          $formMapper
          ->with('General')
          ->add('username')
          ->add('email')
          ->add('plainPassword', 'text')

          ->end()
                  
//          ->with('Groups')
//          ->add('groups', 'sonata_type_model', array('required' => false))
//          ->end()
          
          ->with('Management')
          ->add('roles', 'sonata_security_roles', array( 'multiple' => true))
          ->add('locked', null, array('required' => false))
          ->add('expired', null, array('required' => false))
          ->add('enabled', null, array('required' => false))
          ->add('credentialsExpired', null, array('required' => false))
          ->add('last_login', 'datetime')
          ->end()
          ;
          */
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {

        parent::configureListFields($listMapper);
        /*
          $listMapper
          ->addIdentifier('username')
          ->add('email')
          ->add('last_login', 'datetime')
          ;
          */
    }
    
    
    public function preUpdate($user) {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    
      public function setUserManager(UserManagerInterface $userManager)
      {
      $this->userManager = $userManager;
      }
     
    public function getUserManager() {
        return $this->userManager;
    }
    
    
    
}
