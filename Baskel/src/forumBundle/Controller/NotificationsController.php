<?php

namespace forumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificationsController extends Controller
{
    /**
     * @Route("/display")
     */
    public function displayAction()
    {

        /*$data = array(
            'my-message' => "My custom message",
            'body' => "test"
        );
        $pusher = $this->get('mrad.pusher.notificaitons');
        $channel = 'notifications';
        $pusher->trigger($data, $channel);*/


// or you can keep the channel pram empty and will be broadcasted on "notifications" channel by default
        //$notifications = $pusher->trigger($data);

        $notifications = $this->getDoctrine()->getManager()->getRepository('forumBundle:Notifications')->findBy([],array('date' => 'DESC'));
        //dump($notifications);
        return $this->render('@forum/Notifications/display2.html.twig', array('notifications' => $notifications));

    }

}
