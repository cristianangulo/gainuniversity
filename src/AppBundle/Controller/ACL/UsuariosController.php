<?php

namespace AppBundle\Controller\ACL;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\ACL\Usuarios;

use AppBundle\Form\ACL\UsuariosType;
use AppBundle\Form\ACL\UsuariosPasswordType;

/**
 * Usuarios controller.
 *
 */
class UsuariosController extends Controller
{

    /**
     * Lists all Usuarios entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ACL\Usuarios')->findAll();

        return $this->render('ACL/Usuarios/index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new Usuarios entity.
     *
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuarios();
        $usuarioForm = $this->createForm(new UsuariosType(), $usuario);

        $usuarioForm->handleRequest($request);

        if($usuarioForm->isValid()){

            $em = $this->getDoctrine()->getManager();

            $password = $usuarioForm->getData()->getPassword()->getPassword();

            if(false == $password){

              $password = $this->get('app.valor_random')->getValor();
              $encoder = $this->get('encoder')->setUserPassword($usuario, $password);
              $usuario->setPassword($encoder);
            }

            $encoder = $this->get('encoder')->setUserPassword($usuario, $password);
            $usuario->setPassword($encoder);

            $em->persist($usuario);
            $em->flush();

            $sendEmail = $usuarioForm->get('sendMail')->getData();

            if(true === $sendEmail){

              $body = $this->renderView('ACL/registro-usuario.html.twig', array(
                'usuario' => $usuario,
                'password'=> $password,
              ));

              $this->get('app.cartero')->msn($usuario->getEmail(), $body, 'Cuenta creada');
            }

            $this->get('app.mensajero')->add('info', 'El usuario ha sido creado');

            return $this->redirect($this->generateUrl('usuarios_edit', array('id' => $usuario->getId())));

        }

        return $this->render('ACL/Usuarios/new.html.twig', array(
            'entity' => $usuario,
            'usuario_form'   => $usuarioForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('AppBundle:ACL\Usuarios')->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

        $usuarioForm = $this->createForm(new UsuariosType(), $usuario);

        $usuarioForm->handleRequest($request);

        if($usuarioForm->isValid()){

            $em->flush();
            $this->get('app.mensajero')->add('info', 'Los datos del usuario han sido actualizados');
            return $this->redirect($this->generateUrl('usuarios_edit', array('id' => $usuario->getId())));

        }

        $deleteForm = $this->createDeleteForm($id);

        $usuarioFormPassword = $this->createForm(new UsuariosPasswordType(), $usuario);

        $usuarioFormPassword->handleRequest($request);

        if($usuarioFormPassword->isValid()){

          $password = $usuarioFormPassword->getData()->getPassword();

          $encoder = $this->get('encoder')->setUserPassword($usuario, $password);

          $usuario->setPassword($encoder);
          $em->persist($usuario);
          $em->flush();

          $this->get('app.mensajero')->add('info', 'La contraseña ha sido actualizada');

          return $this->redirect($this->generateUrl('usuarios_edit', array('id' => $usuario->getId())));
        }

        return $this->render('ACL/Usuarios/edit.html.twig', array(
            'usuario'      => $usuario,
            'usuario_form'   => $usuarioForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario_password_form' => $usuarioFormPassword->createView()
        ));
    }

    /**
     * Deletes a Usuarios entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ACL\Usuarios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuarios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('app.mensajero')->add('warning', 'El usuario ha sido eliminado');
        return $this->redirect($this->generateUrl('usuarios'));
    }

    /**
     * Creates a form to delete a Usuarios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
