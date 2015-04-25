<?php

namespace AppBundle\Utils;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Utils\Encoder;

class RegistroSoap
{
    private $passWS;
    private $userWS;
    private $em;
    private $encoder;
    private $mailer;

    public function __construct(EntityManager $em, Encoder $encoder, \Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->passWS = "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==";
        $this->userWS = 'gain';
        $this->em = $em;
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->twig = $twig;

    }

    public function registroSoap($name)
    {
      return $this->registrar($name);
    }

    public function registrar($datos)
    {
      $datos = explode(',',$datos);

      $userWS    = $datos[0];
      $passWS    = $datos[1];
      $nombre    = $datos[2];
      $mail      = $datos[3];
      $sku       = $datos[4];

      if($this->userWS != $userWS || $this->passWS != $passWS){
        return null;
      }

      $usuario = $this->em->getRepository("AppBundle:ACL\Usuarios")->findOneByEmail($mail);
      $role = $this->em->getRepository("AppBundle:ACL\Roles")->find(2);

      if(!$usuario){

        $rand = rand(1,9999);
        // Se registra el usuario
        $usuario = new Usuarios();
        $usuario->setNombre($nombre);
        $usuario->setUsername($mail);
        $usuario->setEmail($mail);
        $usuario->setPassword(1234);
        $usuario->setIsActive(1);
        $usuario->setActivado(1);
        $usuario->setRoles($role);

        $this->em->persist($usuario);

        $password = $this->encoder->setUserPassword($usuario, $rand);
        $usuario->setPassword($password);

        $this->em->flush();
      }

      // $message = \Swift_Message::newInstance()
      //   ->setContentType("text/html")
      //   ->setSubject('Registro a curso')
      //   ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))
      //   //->setTo($entity->getEmail())
      //   ->setTo('cristianangulonova@hotmail.com')
      //   ->setBody($this->twig->render(
      //     "Front/soapRegistro.html.twig", array(
      //       'usuario' => $usuario
      //     ))
      //   );

      $message = \Swift_Message::newInstance()
                                ->setTo('cristianangulonova@hotmail.com')
                                ->setSubject('Hello Service')
                                ->setBody($usuario->getNombre() . ' says hi!');

      $this->mailer->send($message);

      return $usuario->getId();

    }
}

 ?>
