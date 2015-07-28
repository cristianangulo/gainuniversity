<?php

namespace AppBundle\Utils;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use AppBundle\Utils\UserEntityService;
use AppBundle\Model\ACL\UsuariosModel;


class UserProvider extends Controller implements UserProviderInterface
{
    private $usuarios;

    public function __construct(UsuariosModel $usuarios)
    {
        $this->usuarios = $usuarios;
    }

    public function loadUserByUsername($username)
    {

        try{
            $user = $this->usuarios->byUsernameOrEmail($username);
        }catch (NoResultException $e){
            throw new UsernameNotFoundException(sprintf('"%s" no existe', $username));
        }

        $id = $user->getId();
        $password = $user->getPassword();
        $salt = $user->getSalt();
        $roles = array($user->getRoles()->getRole());
        $isActive = $user->getIsActive();

        if($user->getIsActive()==0){
            $roles = array("ROLE_NO_ACTIVADO");
        }

        $img = $user->getPath();

        $userEntityService = new UserEntityService($id, $username, $password, $salt, $roles, $isActive, $img);
        
        return $userEntityService;
    }

public function refreshUser(UserInterface $user)
{

  // echo "<pre>";print_r($user);
  // exit();
  if (!$user instanceof UserEntityService) {
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
