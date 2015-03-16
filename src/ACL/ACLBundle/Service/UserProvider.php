<?php

namespace ACL\ACLBundle\Service;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use ACL\ACLBundle\Service;

class UserProvider extends Controller implements UserProviderInterface
{
  public function loadUserByUsername($username)
  {

    $repositorio = $this->getDoctrine()->getRepository("ACLBundle:Usuarios");

    $query = $repositorio
    ->createQueryBuilder('u')
    ->select('u, r')
    ->leftJoin('u.roles', 'r')
    ->where('u.username = :username OR u.email = :email')
    ->setParameter('username', $username)
    ->setParameter('email', $username)
    ->getQuery();

    try {
      // The Query::getSingleResult() method throws an exception
      // if there is no record matching the criteria.
      $user = $query->getSingleResult();
    } catch (NoResultException $e) {
      throw new UsernameNotFoundException(sprintf('Unable to find an active admin ACLBundle:Usuarios object identified by "%s".', $username), null, 0, $e);
    }

    $id = $user->getId();
    $password = $user->getPassword();
    $salt = $user->getSalt();
    $roles = $user->getRoles();

    return new Service\UserEntityService($id, $username, $password, $salt, $roles);
}

public function refreshUser(UserInterface $user)
{

  // echo "<pre>";print_r($user);
  // exit();
  if (!$user instanceof Service\UserEntityService) {
    throw new UnsupportedUserException(
    sprintf('Instances of "%s" are not supported.', get_class($user))
    );
  }

return $this->loadUserByUsername($user->getUsername());
}

public function supportsClass($class)
{
  return $class === 'ACL\ACLBundle\Service\UserEntityService';
}
}

?>
