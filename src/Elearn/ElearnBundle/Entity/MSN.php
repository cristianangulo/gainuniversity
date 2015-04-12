<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MSN
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\MSNRepository")
 */
class MSN
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
     * @ORM\ManyToOne(targetEntity="ACL\ACLBundle\Entity\Usuarios", inversedBy="msn");
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */

    private $usuarios;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="text", length=255)
     */
    private $mensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado", type="datetime")
     */
    private $creado;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer")
     */
    private $estado;

    public function __construct()
    {
      $this->creado = new \Datetime('now');
      $this->estado = 0;
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
     * Set mensaje
     *
     * @param string $mensaje
     * @return MSN
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return MSN
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return MSN
     */
    public function setEstado($estado = null)
    {
        if($estado != null){
          $this->estado = $estado;
        }

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add usuarios
     *
     * @param \ACL\ACLBundle\Entity\Usuarios $usuarios
     * @return MSN
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
     * Set usuarios
     *
     * @param \ACL\ACLBundle\Entity\Usuarios $usuarios
     * @return MSN
     */
    public function setUsuarios(\ACL\ACLBundle\Entity\Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }
}
