<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

class CuentaNoActivaController extends Controller
{
  public function noActivaAction()
  {
    return new Response("Cuenta no activa");
  }
}
