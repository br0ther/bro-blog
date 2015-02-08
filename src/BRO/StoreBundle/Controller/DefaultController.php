<?php

/*
  namespace BRO\StoreBundle\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;

  class DefaultController extends Controller
  {
  public function indexAction($name)
  {
  return $this->render('BROStoreBundle:Default:index.html.twig', array('name' => $name));
  }
  }
 * 
 */

namespace BRO\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BRO\StoreBundle\Entity\Product;
use BRO\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    private $counter;

    public function indexAction($name) {
        return $this->render('BROStoreBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction() {
        $category = new Category();
        $category->setName('Main Products');

        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');
        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();
        return new Response(
                'Created product id: ' . $product->getId()
                . ' and category id: ' . $category->getId()
        );
    }

    public function getAction($id) {
        $product = $this->getDoctrine()->getRepository('BROStoreBundle:Product')->find($id);

        // lazy loading via Proxy 
        $category = $product->getCategory();
        if (!$category) {
            throw $this->createNotFoundException(
                    'No category found for id ' . $id
            );
        } else {
            echo get_class($category);
            $categoryName = $category->getName();
        }

        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }

        //return new Response('Product found ' . var_dump($product));
        return new Response('Product found: ' . $product->getName() . '. It\'s category: ' . $categoryName);
    }

    public function get_joinAction($id) {
        $product = $this->getDoctrine()
                ->getRepository('BROStoreBundle:Product')
                ->findOneByIdJoinedToCategory($id);
        
        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }
        
        $category = $product->getCategory();

        if (!$category) {
            throw $this->createNotFoundException(
                    'No category found for id ' . $id
            );
        } else {
            echo get_class($category);
            $categoryName = $category->getName();
        }
      
        //return new Response('Product found ' . var_dump($product));
        return new Response('Product found: ' . $product->getName() . '. It\'s category: ' . $categoryName);
    }

    public function updateAction($id, $name) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('BROStoreBundle:Product')->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }
        $product->setName($name);
        $em->flush();
        return $this->redirect($this->generateUrl('bro_get_product', array('id' => $id)));
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('BROStoreBundle:Product')->find($id);
        $em->remove($product);
        $em->flush();
        return new Response('Product removed: ' . $product->getName());
    }

}
