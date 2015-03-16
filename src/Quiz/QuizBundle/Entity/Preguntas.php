<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Preguntas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\PreguntasRepository")
 */
class Preguntas
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
     * @var string
     *
     * @ORM\Column(name="pregunta", type="string", length=255)
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Respuestas", mappedBy="preguntas")
     */

    private $respuestas;

    public function __construct()
    {
      $this->respuestas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set pregunta
     *
     * @param string $pregunta
     * @return Preguntas
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Preguntas
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add respuestas
     *
     * @param \Quiz\QuizBundle\Entity\Respuestas $respuestas
     * @return Preguntas
     */
    public function addRespuesta(\Quiz\QuizBundle\Entity\Respuestas $respuestas)
    {
        $this->respuestas[] = $respuestas;

        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \Quiz\QuizBundle\Entity\Respuestas $respuestas
     */
    public function removeRespuesta(\Quiz\QuizBundle\Entity\Respuestas $respuestas)
    {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }
}
