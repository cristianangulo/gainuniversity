<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioQuizOpciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\QuizUsuarioDetalleRepository")
 */
class QuizUsuarioDetalle
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
     * @ORM\ManyToOne(targetEntity="QuizUsuario", inversedBy="calificacion")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */

    private $quizes;

    /**
     * @ORM\ManyToOne(targetEntity="Preguntas", inversedBy="calificacion")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     */

    private $preguntas;

    /**
     * @ORM\ManyToOne(targetEntity="Opciones", inversedBy="calificacion")
     * @ORM\JoinColumn(name="opcion_id", referencedColumnName="id")
     */

    private $opciones;

    /**
     * @var string
     *
     * @ORM\Column(name="calificacion", type="boolean")
     */
    private $calificacion;

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
     * Set calificacion
     *
     * @param boolean $calificacion
     * @return QuizUsuarioDetalle
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return boolean 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set quizes
     *
     * @param \Quiz\QuizBundle\Entity\QuizUsuario $quizes
     * @return QuizUsuarioDetalle
     */
    public function setQuizes(\Quiz\QuizBundle\Entity\QuizUsuario $quizes = null)
    {
        $this->quizes = $quizes;

        return $this;
    }

    /**
     * Get quizes
     *
     * @return \Quiz\QuizBundle\Entity\QuizUsuario 
     */
    public function getQuizes()
    {
        return $this->quizes;
    }

    /**
     * Set preguntas
     *
     * @param \Quiz\QuizBundle\Entity\Preguntas $preguntas
     * @return QuizUsuarioDetalle
     */
    public function setPreguntas(\Quiz\QuizBundle\Entity\Preguntas $preguntas = null)
    {
        $this->preguntas = $preguntas;

        return $this;
    }

    /**
     * Get preguntas
     *
     * @return \Quiz\QuizBundle\Entity\Preguntas 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set opciones
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opciones
     * @return QuizUsuarioDetalle
     */
    public function setOpciones(\Quiz\QuizBundle\Entity\Opciones $opciones = null)
    {
        $this->opciones = $opciones;

        return $this;
    }

    /**
     * Get opciones
     *
     * @return \Quiz\QuizBundle\Entity\Opciones 
     */
    public function getOpciones()
    {
        return $this->opciones;
    }
}
