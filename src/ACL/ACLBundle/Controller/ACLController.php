<?php

namespace ACL\ACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ACL\ACLBundle\Entity\User;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

use ACL\ACLBundle\Entity\UsuariosRoles;

use Elearn\ElearnBundle\Entity\CursoUsuarios;

class ACLController extends Controller
{

}
