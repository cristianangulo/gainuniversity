<?php

namespace AppBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MSN
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\MSNRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ACL\Usuarios", inversedBy="msn");
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */

    private $usuarios;

    /**
     * @var text
     *
     * @ORM\Column(name="mensaje", type="text")
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

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\MensajesRespuestas", mappedBy="respuestas")
     */

    private $mensajesRespuestas;

    public function __construct()
    {
      $this->creado = new \Datetime('now');
      $this->estado = 0;
      $this->mensajesRespuestas = new ArrayCollection();
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
    public function setEstado($estado)
    {
        $this->estado = $estado;

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
     * Set usuarios
     *
     * @param \AppBundle\Entity\ACL\Usuarios $usuarios
     * @return MSN
     */
    public function setUsuarios(\AppBundle\Entity\ACL\Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \AppBundle\Entity\ACL\Usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Add mensajesRespuestas
     *
     * @param \AppBundle\Entity\Admin\MensajesRespuestas $mensajesRespuestas
     * @return MSN
     */
    public function addMensajesRespuesta(\AppBundle\Entity\Admin\MensajesRespuestas $mensajesRespuestas)
    {
        $this->mensajesRespuestas[] = $mensajesRespuestas;

        return $this;
    }

    /**
     * Remove mensajesRespuestas
     *
     * @param \AppBundle\Entity\Admin\MensajesRespuestas $mensajesRespuestas
     */
    public function removeMensajesRespuesta(\AppBundle\Entity\Admin\MensajesRespuestas $mensajesRespuestas)
    {
        $this->mensajesRespuestas->removeElement($mensajesRespuestas);
    }

    /**
     * Get mensajesRespuestas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMensajesRespuestas()
    {
        return $this->mensajesRespuestas;
    }
}
