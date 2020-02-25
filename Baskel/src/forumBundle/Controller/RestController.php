<?php

namespace forumBundle\Controller;

use forumBundle\Entity\Postscomments;
use forumBundle\Entity\Postsforum;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
class RestController extends Controller
{
    /**
     * @Rest\Get("post/all")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('forumBundle:Postsforum')->findAll();
        if ($posts === null) {
            return new View("No posts.", Response::HTTP_NO_CONTENT);
        }
        return $posts;
    }
    /**
     * @Rest\Get("post/category/all")
     */
    public function categoryListAction(){
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('forumBundle:Category')->findAll();
        if ($c === null) {
            return new View("No posts.", Response::HTTP_NO_CONTENT);
        }
        return $c;
    }
    /**
     * @Rest\Post("post/add")
     */
    public function addAction(Request $request)
    {
        //dump($request);
        if($request->isMethod("post")){
        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('AppBundle:User')->find($request->get('user'));
        $category= $em->getRepository('forumBundle:Category')->find($request->get('category'));
        $post = new Postsforum();
        $post->setCategoryId($category);
        $post->setDescription($request->get('desc'));
        $post->setIduser($user);
        $post->setPosteddate(new \DateTime());
        $post->setSubject($request->get('subject'));
        $post->setViews(0);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
            return new View("Insert Successfully", Response::HTTP_OK);
        }
        return new View("Method not authorized.", Response::HTTP_BAD_REQUEST);
    }
    /**
     * @Rest\Post("post/comment/add")
     */
    public function addCommentAction(Request $request)
    {
        if($request->isMethod("post")) {
            $com = new Postscomments();
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('forumBundle:Postsforum')->find($request->get("idPost"));
            $user = $em->getRepository('AppBundle:User')->find($request->get("idUser"));
            if ($request->get("Description")) {
                $com->setCommentaire($request->get("Description"));
                $com->setIduser($user);
                $com->setPostedon(new \DateTime());
                $com->setIdpost($post);
                $em = $this->getDoctrine()->getManager();
                $em->persist($com);
                $em->flush();
                return new View("Insert Successfully", Response::HTTP_OK);
            }
        }
        return new View("Method not authorized.", Response::HTTP_BAD_REQUEST);

    }
    /**
     * @Rest\Get("/post/comment/delete/{id}")
     */
    public function viewsingleCommentDeleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $Com = $em->getRepository('forumBundle:Postscomments')->find($id);
        $em->remove($Com);
        $em->flush();
        return "comment deleted";
        //dump($Com->getIdPost()->getId());
        //return new Response("");
    }
    /**
     * @Rest\Get("/post/delete/{id}")
     */
    public function deleteAction($id)
    {
        $post=$this->getDoctrine()->getRepository("forumBundle:Postsforum")->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return "comment deleted";
        //var_dump($id);
        // return new Response($id);
    }
    /**
     * @Rest\Post("post/update")
     */
    public function updateAction(Request $request)
    {
        if($request->isMethod("post")){
            $em = $this->getDoctrine()->getManager();
            $post= $em->getRepository('forumBundle:Postsforum')->find($request->get('idPost'));
            $post->setDescription($request->get('desc'));
            $post->setPosteddate(new \DateTime());
            $post->setSubject($request->get('subject'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            return new View("updated Successfully", Response::HTTP_OK);
        }
        return new View("Method not authorized.", Response::HTTP_BAD_REQUEST);
    }
    /**
     * @Rest\Get("/post/views/{id}")
     */
    public function addViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post= $em->getRepository('forumBundle:Postsforum')->find($id);
        $post->setViews($post->getViews()+1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
        return new View("views updated", Response::HTTP_OK);
    }

}
