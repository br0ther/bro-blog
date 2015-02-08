<?php

namespace BRO\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BRO\BlogBundle\Entity\Comment;
use BRO\BlogBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(new CommentType(
                array(
                        $this->get('security.context')->getToken()->getUser()
                   ) 
                ), $comment);

        return $this->render('BROBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    public function createAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment  = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(
                array(
                        $this->get('security.context')->getToken()->getUser()
                   )                 
                ), $comment);
        //$form->bindRequest($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // TODO: Persist the comment entity
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                'id' => $comment->getBlog()->getId(),
                'slug'  => $comment->getBlog()->getSlug())) .    
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('BROBlogBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
                    ->getManager();

        $blog = $em->getRepository('BROBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}