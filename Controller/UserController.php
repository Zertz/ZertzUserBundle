<?php

namespace Zertz\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;

class UserController extends Controller
{
    /**
     * @Route("/connect", name="connect")
     */
    public function connectAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('me'));
        }
        
        return $this->render('ZertzUserBundle:User:connect.html.twig');
    }
    
    /**
     * @Route("/me", name="me")
     * @Secure(roles="ROLE_USER")
     */
    public function meAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $owner = $em->getRepository('ZertzOwnerBundle:Owner')->findOneByUser($this->getUser());
        
        $dogowners = $em->getRepository('ZertzOwnerBundle:OwnerDog')->findBy(array(
            'owner' => $owner,
            'confirmed' => true
        ));
        
        $handler = $em->getRepository('ZertzHandlerBundle:Handler')->findOneByUser($this->getUser());
        
        $teamhandlers = $em->getRepository('ZertzHandlerBundle:TeamHandler')->findBy(array(
            'handler' => $handler,
            'confirmed' => true
        ));
        
        return $this->render('ZertzUserBundle:User:me.html.twig', array(
            'owner' => $owner,
            'dogowners' => $dogowners,
            'handler' => $handler,
            'teamhandlers' => $teamhandlers,
        ));
    }
}
