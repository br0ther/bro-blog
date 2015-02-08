<?php

namespace BRO\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use BRO\BlogBundle\Entity\Blog;

class BlogAdmin extends Admin {

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'created'
    );
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        
        // get the current Image instance
        $image = $this->getSubject();
        
        $options = array('required' => false);

        if ($image && ($webPath = $image->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $options['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }
        
        $formMapper
                ->add('title', 'text', array('label' => 'Blog Title'))
                ->add('author') //'entity', array('class' => 'Acme\DemoBundle\Entity\User'))
                ->add('blog')
                ->add('tags')
                //->add('image')
                ->add('file', 'file', $options)    
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('title')
                ->add('author')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('title')
                ->add('created')
                ->add('author')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array()
                    //'edit' => array(),
                    //'delete' => array(),
                    )
                ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('title')
                ->add('author') //'entity', array('class' => 'Acme\DemoBundle\Entity\User'))
                ->add('blog')
                ->add('tags')
                //->add('file', 'file', array('label' => 'Blog Image', 'required' => false))  
                ->add('webPath', 'string', array('template' => 'BROBlogBundle:BlogAdmin:list_image.html.twig'))
        ;
    }
    
    public function prePersist($image) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        if ($image->getFile()) {
            $image->hook_setUpdated();
        }
    }

}
