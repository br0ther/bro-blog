<?php

namespace BRO\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BRO\TaskBundle\Entity\Task;
use BRO\TaskBundle\Form\Type\TaskType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BROTaskBundle:Default:index.html.twig', array('name' => $name));
    }
    
public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        $form = $this->createForm(new TaskType(), $task);
        
        // better to store form in separate class
        /*
        $form = $this->createFormBuilder($task)
            ->add('task', 'text', array('required' => false))
            ->add('dueDate', 'date')
            //->add('category', new CategoryType())    
            ->add('save', 'submit', array('label' => 'Create Post'))
            ->add('saveAndAdd', 'submit', array('label' => 'Save and Add'))    
            ->getForm();
        */
       //var_dump($form);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            //echo 'form submitted!';
            // save it to db!!!
            return $this->redirect($this->generateUrl('bro_task_homepage'));
        }
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            return $this->redirect($this->generateUrl('bro_new_task'));
        }
        
        return $this->render('BROTaskBundle:Default:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
            
}
