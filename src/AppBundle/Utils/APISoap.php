<?php

namespace AppBundle\Utils;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Entity\Admin\Cursos\CursoUsuarios;
use AppBundle\Utils\Encoder;

class APISoap
{
    private $passWS;
    private $userWS;
    private $em;
    private $encoder;
    private $mailer;

    public function __construct(EntityManager $em, Encoder $encoder, \Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->passWS = "5FZ2Z8QIkA7UTZ4BYkoC==";
        $this->userWS = 'gain';
        $this->em = $em;
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->twig = $twig;

    }

    public function registroUsuario($userWS, $passWS, $nombre, $email)
    {
      if($this->userWS != $userWS || $this->passWS != $passWS){
        return null;
      }

      $usuario = $this->em->getRepository("AppBundle:ACL\Usuarios")->findOneByEmail($email);

      if(!$usuario){

        $role = $this->em->getRepository("AppBundle:ACL\Roles")->find(2);
        $rand = rand(1,9999);

        $usuario = new Usuarios();
        $usuario->setNombre($nombre);
        $usuario->setUsername($email);
        $usuario->setEmail($email);
        $usuario->setPassword($rand);
        $usuario->setIsActive(1);
        $usuario->setActivado(1);
        $usuario->setRoles($role);

        $this->em->persist($usuario);

        $password = $this->encoder->setUserPassword($usuario, $rand);
        $usuario->setPassword($password);

        $this->em->flush();
        $message = \Swift_Message::newInstance()
          ->setContentType("text/html")
          ->setSubject('Registro plataforma')
          ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))
          ->setTo($usuario->getEmail())
          ->setBody($this->twig->render(
            "ACL/registroPlataformaSoap.html.twig", array(
              'usuario' => $usuario,
              'password'=> $rand,
            )));

        //echo $message;

        $this->mailer->send($message);

        $this->mailer->send($message);

        return $usuario->getId();
      }

      return $usuario->getId();
    }

    public function registroUsuarioCurso($usuario, $sku)
    {

      $usuario = $this->em->getRepository("AppBundle:ACL\Usuarios")->find($usuario);
      $curso = $this->em->getRepository("AppBundle:Admin\Cursos\Cursos")->findOneBySku($sku);

      if(!$curso){
        return "El curso no existe. Revise el SKU";
      }

      $cursoUsuario = $this->em->getRepository("AppBundle:Admin\Cursos\CursoUsuarios")
        ->findCursoUsuario($curso->getId(), $usuario->getId());

      if(!$cursoUsuario){

        $cursoUsuario = new CursoUsuarios();
        $cursoUsuario->setCurso($curso);
        $cursoUsuario->setUsuario($usuario);

        $this->em->persist($cursoUsuario);
        $this->em->flush();

        $message = \Swift_Message::newInstance()
          ->setContentType("text/html")
          ->setSubject('Registro curso: '.$curso->getCurso())
          ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))
          ->setTo('cristianangulonova@hotmail.com')
          ->setBody($this->twig->render(
            "ACL/registroCursoSoap.html.twig", array(
              'usuario' => $usuario,
              'curso' => $curso->getCurso()
            )));

        $this->mailer->send($message);

        return true;
      }

      return true;
    }
}

 ?>
