<?php

namespace AppBundle\Utils;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class UserEntityService implements UserInterface, \Serializable
{

  private $id;
  private $username;
  private $password;
  private $salt;
  private $roles;
  private $isActive;

  public function __construct($id, $username, $password, $salt, array $roles, $isActive)
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->salt = $salt;
    $this->roles = $roles;
    $this->isActive = $isActive;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getRoles()
  {
    return $this->roles;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getSalt()
  {
    return $this->salt;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function getIsActive()
  {
    return $this->isActive;
  }

  /**
  * @inheritDoc
  */
  public function eraseCredentials()
  {
  }

  /**
  * @see \Serializable::serialize()
  */
  public function serialize()
  {
    return serialize(array(
      $this->id,
      $this->username,
      $this->password,
      // see section on salt below
      // $this->salt,
    ));
  }

  /**
  * @see \Serializable::unserialize()
  */
  public function unserialize($serialized)
  {
    list (
    $this->id,
    $this->username,
    $this->password,
    // see section on salt below
    // $this->salt
    ) = unserialize($serialized);
  }

  public function isEqualTo(UserInterface $user)
  {
    if (!$user instanceof WebserviceUser) {
      return false;
    }

    if ($this->password !== $user->getPassword()) {
      return false;
    }

    if ($this->salt !== $user->getSalt()) {
      return false;
    }

    if ($this->username !== $user->getUsername()) {
      return false;
    }

    if ($this->isActive !== $user->getIsActive()) {
      return false;
    }

    return true;
  }

}

?>
