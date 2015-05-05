<?php

namespace AppBundle\Utils;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router   = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $this->security->getToken()->getUser();

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('admin_cursos'));
        }
        elseif ($this->security->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('perfil_tus_cursos'));
        }elseif($this->security->isGranted('ROLE_SUPER_ADMIN')){
            $response = new RedirectResponse($this->router->generate('admin_cursos'));
        }

        if(!$this->security->isGranted('ROLE_SUPER_ADMIN')){
          if($user->getIsActive() == null){
            //exit("Inactivo");
            $response = new RedirectResponse($this->router->generate('acl_no_activo'));
          }
        }

        return $response;
    }
}
