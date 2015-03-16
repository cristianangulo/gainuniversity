<?php

namespace ACL\ACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        exit("<h1>Portada</h1>");
        return $this->redirect($this->generateUrl('login'));
    }
}
