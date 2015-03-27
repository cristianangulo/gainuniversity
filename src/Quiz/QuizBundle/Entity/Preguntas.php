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
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="preguntas")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */

     protected $quiz;

     /**
      * @ORM\OneToMany(targetEntity="Opciones", mappedBy="preguntas")
      */

     private $opciones;

     public function __construct()
     {
       $this->secciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set posicion
     *
     * @param integer $posicion
     * @return Preguntas
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set quiz
     *
     * @param \Quiz\QuizBundle\Entity\Quiz $quiz
     * @return Preguntas
     */
    public function setQuiz(\Quiz\QuizBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \Quiz\QuizBundle\Entity\Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Add opciones
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opciones
     * @return Preguntas
     */
    public function addOpcione(\Quiz\QuizBundle\Entity\Opciones $opciones)
    {
        $this->opciones[] = $opciones;

        return $this;
    }

    /**
     * Remove opciones
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opciones
     */
    public function removeOpcione(\Quiz\QuizBundle\Entity\Opciones $opciones)
    {
        $this->opciones->removeElement($opciones);
    }

    /**
     * Get opciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpciones()
    {
        return $this->opciones;
    }
}
