<?php

namespace BRO\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use BRO\BlogBundle\Entity\Enquiry;
use BRO\BlogBundle\Form\EnquiryType;

class PageController extends Controller {

    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();

        /*
          $blogs = $em->createQueryBuilder()
          ->select('b')
          ->from('BROBlogBundle:Blog',  'b')
          ->addOrderBy('b.created', 'DESC')
          ->getQuery()
          ->getResult();
         */

        $total_blogs = $em->getRepository('BROBlogBundle:Blog')->getTotalBlogs();
        $blogs_per_page = $this->container->getParameter('bro_blog.max_blogs_on_page');
        $last_page = ceil($total_blogs / $blogs_per_page);
        $previous_page = $page > 1 ? $page - 1 : 1;
        $next_page = $page < $last_page ? $page + 1 : $last_page;

        //dle:Job')->getActiveJobs($category->getId(), $jobs_per_page, ($page - 1) * $jobs_per_page));
        $blogs = $em->getRepository('BROBlogBundle:Blog')
                ->getLatestBlogs($blogs_per_page, ($page - 1) * $blogs_per_page);
        return $this->render('BROBlogBundle:Page:index.html.twig', array(
                    'blogs' => $blogs,
                    'last_page' => $last_page,
                    'previous_page' => $previous_page,
                    'current_page' => $page,
                    'next_page' => $next_page,
        ));
    }

    public function aboutAction() {
        return $this->render('BROBlogBundle:Page:about.html.twig');
    }

    public function contactAction() {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            //$form->bindRequest($request);
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contact enquiry from symblog')
                        ->setFrom('enquiries@symblog.co.uk')
                        ->setTo($this->container->getParameter('bro_blog.emails.contact_email'))
                        ->setBody($this->renderView('BROBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);
                //Make sure you also change all “setFlash” calls with the following search/replace action: “setFlash” -> “getFlashBag()->add”.
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
        }
        return $this->render('BROBlogBundle:Page:contact.html.twig', array('form' => $form->createView())
        );
    }

    public function sidebarAction() {
        $em = $this->getDoctrine()
                ->getManager();

        $tags = $em->getRepository('BROBlogBundle:Blog')
                ->getTags();

        $tagWeights = $em->getRepository('BROBlogBundle:Blog')
                ->getTagWeights($tags);

        $commentLimit = $this->container
                ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BROBlogBundle:Comment')
                ->getLatestComments($commentLimit);

        return $this->render('BROBlogBundle:Page:sidebar.html.twig', array(
                    'latestComments' => $latestComments,
                    'tags' => $tagWeights
        ));
    }

}
