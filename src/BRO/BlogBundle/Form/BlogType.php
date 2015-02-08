<?php

namespace BRO\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType {

    private $tags;
    private $user;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$tags = $em->getRepository('BROBlogBundle:Blog')->getTags();
        $builder
                //->add('slug')
                //$this->get('security.context')->getToken()->getUser()
                ->add('title')
                ->add('author','hidden', array('data' => $this->user))
                ->add('blog', null, array('label' => 'Blog Text'))
                //->add('image')
                ->add('file', 'file', array('label' => 'Image', 'required' => false))
                ->add('tags', 'choice', array(
                    'choices' => $this->tags,
                    'multiple' => true))
        /*
          ->add('tags', 'choice', array(
          'choices' => array(
          'morning' => 'Morning',
          'afternoon' => 'Afternoon',
          'evening' => 'Evening',
          ),
          'multiple' => true))
         * 
         */
        //->add('created')
        //->add('updated')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BRO\BlogBundle\Entity\Blog'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bro_blogbundle_blog';
    }

    public function __construct($form_array) {
        
        list($this->tags, $this->user) = $form_array; 
    }

}
