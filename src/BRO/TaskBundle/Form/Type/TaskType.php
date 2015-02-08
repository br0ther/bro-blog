<?php

namespace BRO\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('task')
                //->add('dueDate', null, array('widget' => 'single_text'))
                ->add('dueDate', 'date')
                ->add('category', new CategoryType())
                ->add('save', 'submit');
    }

    public function getName() {
        return 'task';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BRO\TaskBundle\Entity\Task',
            'cascade_validation' => true,
        ));
    }

}
