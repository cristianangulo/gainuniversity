<?php

namespace ACL\ACLBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Table(name="Roles")
* @ORM\Entity()
*/
class Roles implements RoleInterface
{
  /**
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id()
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\Column(name="role", type="string", length=30)
  */
  private $role;

  /**
  * @ORM\Column(name="role_key", type="string", length=20, unique=true)
  */
  private $role_key;

  // ... getters and setters for each property

  /**
  * @see RoleInterface
  */

  /**
   * @ORM\OneToMany(targetEntity="Usuarios", mappedBy="roles")
   */

  protected $usuarios;

  public function __construct()
  {
    $this->usuarios = new ArrayCollection();
  }

  public function getRole()
  {
    return $this->role;
  }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Grupos
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Grupos
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add usuarios
     *
     * @param \ACL\ACLBundle\Entity\Usuarios $usuarios
     * @return Grupos
     */
    public function addUsuario(\ACL\ACLBundle\Entity\Usuarios $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \ACL\ACLBundle\Entity\Usuarios $usuarios
     */
    public function removeUsuario(\ACL\ACLBundle\Entity\Usuarios $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set role_key
     *
     * @param string $roleKey
     * @return Roles
     */
    public function setRoleKey($roleKey)
    {
        $this->role_key = $roleKey;

        return $this;
    }

    /**
     * Get role_key
     *
     * @return string
     */
    public function getRoleKey()
    {
        return $this->role_key;
    }
}
