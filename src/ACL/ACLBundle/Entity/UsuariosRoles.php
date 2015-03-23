<?php

namespace ACL\ACLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuariosRoles
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ACL\ACLBundle\Entity\UsuariosRolesRepository")
 */
class UsuariosRoles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_id", type="integer")
     */
    private $usuarioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="roles_id", type="integer")
     */
    private $rolesId;


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
     * Set usuarioId
     *
     * @param integer $usuarioId
     * @return UsuariosRoles
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return integer
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set rolesId
     *
     * @param integer $rolesId
     * @return UsuariosRoles
     */
    public function setRolesId($rolesId)
    {
        $this->rolesId = $rolesId;

        return $this;
    }

    /**
     * Get rolesId
     *
     * @return integer
     */
    public function getRolesId()
    {
        return $this->rolesId;
    }
}
