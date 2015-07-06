<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\ACL\Usuarios;
use Doctrine\ORM\EntityRepository;

class CursosUsuarioController extends Controller
{
  public function cursosAction()
  {
    $em = $this->getDoctrine()->getManager();

    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($this->getUser()->getId());

    $usuarioCursos = $this->get('app.reporte_cursos_usuarios')->fechaLiberarDiplomaCurso($usuario);

    $cursos = $em->getRepository("AppBundle:Admin\Cursos\Cursos")->findCursosPublicados();

    return $this->render('Front/tus-cursos.html.twig', array(
      'usuario' => $usuario,
      'usuarioCursos' => $usuarioCursos,
      'cursos'  => $cursos
    ));
  }

    public function datosDiplomaAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $cursoUsuario = $this->get('app.model.usuarios')->cursoUsuario($id, $this->getUser()->getId());

        if($cursoUsuario->getNombre() != ""){

            $fecha = $this->get('app.fecha_diploma')->fecha($cursoUsuario->getFechaDiploma());

            return $this->descargarDiploma($cursoUsuario->getNombre(), $fecha, $cursoUsuario->getCursos()->getCurso());
        }

        $usuariosForm = $this->usuarioForm($cursoUsuario->getUsuarios()->getNombre());

        $usuariosForm->handleRequest($request);

        if($usuariosForm->isValid()){

            $this->get('app.model.usuarios')->nombreDiploma($cursoUsuario, $usuariosForm);

            $this->get('app.mensajero')->add('info','Descargando diploma');

            return $this->redirect($this->generateUrl('perfil_diplomas', array('id' => $cursoUsuario->getCursos()->getId())));

        }

        return $this->render('Front/datos-diploma.html.twig', array(
            'usuarios_form' => $usuariosForm->createView()
        ));
    }

    public function usuarioForm($nombre)
    {
        $form = $this->createFormBuilder()
            ->add('nombre', 'text', array(
                'data' => $nombre,
                'mapped' => false
            ))
            ->getForm();

        return $form;
    }

    public function descargarDiploma($nombre, $fecha, $curso)
    {
        require_once($this->get('kernel')->getRootDir().'/config/dompdf_config.inc.php');

        $html = $this->renderView('Front/diploma.html.twig', array(
            'nombre' => $nombre,
            'fecha'  => $fecha,
            'curso'  => $curso
        ));

        //return $html;

        $dompdf = new \DOMPDF();
        $dompdf->set_paper('a4', 'landscape');
        $dompdf->load_html($html);

        $dompdf->render();
        $dompdf->stream($nombre.".pdf");
        // return new Response($dompdf->output(), 200, array(
        //     'Content-Type' => 'application/pdf'
        // ));
    }
}
