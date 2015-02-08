<?php

namespace BRO\DemoBundle\Controller;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RandomController extends Controller
{
    public function indexAction($limit, $header)
    {
       $number = rand(1, $limit);
       return $this->render(
            'BRODemoBundle:Random:index.html.twig',
            array('number' => $number,
                  'header_name' => $header)
        );
        
       //return $this->render('BRODemoBundle:Default:index.html.twig', array('name' => $name));
       //return new Response('<html><body>Number: '.rand(1, $limit).'</body></html>'); 
    }
}
