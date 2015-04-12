<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MSNRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MSNRepository extends EntityRepository
{
  public function MSNNoContestados()
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT m FROM ElearnBundle:MSN m where m.estado = 0 '
      )
      ->getResult();
  }

  public function MSNNoContestadosUsuario($id)
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT m FROM ElearnBundle:MSN m where m.estado = 0 AND m.usuarios = :usuario'
      )
      ->setParameter('usuario', $id)
      ->getResult();
  }

  public function MSNContestados()
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT m FROM ElearnBundle:MSN m where m.estado = 1 '
      )
      ->getResult();
  }

  public function findMensajesUsuario($id)
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT m FROM ElearnBundle:MSN m where m.usuarios = :usuario '
      )
      ->setParameter('usuario', $id)
      ->getResult();
  }
}
