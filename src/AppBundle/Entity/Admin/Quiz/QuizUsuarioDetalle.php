<?php

namespace AppBundle\Entity\Admin\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioQuizOpciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Quiz\QuizUsuarioDetalleRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\QuizUsuario", inversedBy="calificacion")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */

    private $quizes;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\Preguntas", inversedBy="calificacion")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     */

    private $preguntas;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\Opciones", inversedBy="calificacion")
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
     * @param \AppBundle\Entity\Admin\Quiz\QuizUsuario $quizes
     * @return QuizUsuarioDetalle
     */
    public function setQuizes(\AppBundle\Entity\Admin\Quiz\QuizUsuario $quizes = null)
    {
        $this->quizes = $quizes;

        return $this;
    }

    /**
     * Get quizes
     *
     * @return \AppBundle\Entity\Admin\Quiz\QuizUsuario 
     */
    public function getQuizes()
    {
        return $this->quizes;
    }

    /**
     * Set preguntas
     *
     * @param \AppBundle\Entity\Admin\Quiz\Preguntas $preguntas
     * @return QuizUsuarioDetalle
     */
    public function setPreguntas(\AppBundle\Entity\Admin\Quiz\Preguntas $preguntas = null)
    {
        $this->preguntas = $preguntas;

        return $this;
    }

    /**
     * Get preguntas
     *
     * @return \AppBundle\Entity\Admin\Quiz\Preguntas 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set opciones
     *
     * @param \AppBundle\Entity\Admin\Quiz\Opciones $opciones
     * @return QuizUsuarioDetalle
     */
    public function setOpciones(\AppBundle\Entity\Admin\Quiz\Opciones $opciones = null)
    {
        $this->opciones = $opciones;

        return $this;
    }

    /**
     * Get opciones
     *
     * @return \AppBundle\Entity\Admin\Quiz\Opciones 
     */
    public function getOpciones()
    {
        return $this->opciones;
    }
}
