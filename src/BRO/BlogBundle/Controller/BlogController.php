<?php

// src/Blogger/BlogBundle/Controller/BlogController.php

namespace BRO\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BRO\BlogBundle\Entity\Blog;
use BRO\BlogBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 */
class BlogController extends Controller {

    /**
     * Show a blog entry
     */
    public function showAction($id, $slug) {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('BROBlogBundle:Blog')->find($id);
        // testing FOS
        //$user = $this->container->get('fos_user.user_manager')->FindUserByUsername('bro');
        //var_dump($user); die;
        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository('BROBlogBundle:Comment')->getCommentsForBlog($blog->getId());

        return $this->render('BROBlogBundle:Blog:show.html.twig', array(
                    'blog' => $blog,
                    'comments' => $comments
        ));
    }

    public function newAction(Request $request) {

        $blog = new Blog();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(
                new BlogType(
                   array(
                        $em->getRepository('BROBlogBundle:Blog')->getUniTags(),
                        $this->get('security.context')->getToken()->getUser()
                   )    
                ), $blog);
        //$request = $this->getRequest();
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            //$blog->file->move(__DIR__.'/../../../../web/uploads', $entity->file->getClientOriginalName());
            //$blog->setLogo($blog->file->getClientOriginalName());
            $em->persist($blog);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('blogger-notice', 'Your blog story was successfully created!');
            
            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                'id' => $blog->getId(),
                'slug'  => $blog->getSlug())) 
            );
        }

        return $this->render('BROBlogBundle:Blog:create.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
