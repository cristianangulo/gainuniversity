<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MensajesRespuestas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\MensajesRespuestasRepository")
 */
class MensajesRespuestas
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
     * @ORM\ManyToOne(targetEntity="MSN", inversedBy="mensajes")
     * @ORM\JoinColumn(name="mensaje_id", referencedColumnName="id")
     */

    private $mensajes;

    /**
     * @ORM\ManyToOne(targetEntity="MSN", inversedBy="mensajesRespuestas")
     * @ORM\JoinColumn(name="respuesta_id", referencedColumnName="id")
     */

    private $respuestas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado", type="datetime")
     */
    private $creado;

    public function __construct()
    {
      $this->creado = new \Datetime('now');
      //$this->respuestas = new ArrayCollection();
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
     * Set creado
     *
     * @param \DateTime $creado
     * @return MensajesRespuestas
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
     * Set mensajes
     *
     * @param \Elearn\ElearnBundle\Entity\MSN $mensajes
     * @return MensajesRespuestas
     */
    public function setMensajes(\Elearn\ElearnBundle\Entity\MSN $mensajes = null)
    {
        $this->mensajes = $mensajes;

        return $this;
    }

    /**
     * Get mensajes
     *
     * @return \Elearn\ElearnBundle\Entity\MSN
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    /**
     * Set respuestas
     *
     * @param \Elearn\ElearnBundle\Entity\MSN $respuestas
     * @return MensajesRespuestas
     */
    public function setRespuestas(\Elearn\ElearnBundle\Entity\MSN $respuestas = null)
    {
        $this->respuestas = $respuestas;

        return $this;
    }

    /**
     * Get respuestas
     *
     * @return \Elearn\ElearnBundle\Entity\MSN
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }
}
