<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizOpciones
 *
 * @ORM\Table(name="Opciones")
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\OpcionesRepository")
 */
class Opciones
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
     * @ORM\Column(name="opcion", type="string", length=255)
     */
    private $opcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="boolean")
     */
    private $valor;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="opciones")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     **/

    private $quiz;


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
     * Set opcion
     *
     * @param string $opcion
     * @return QuizOpciones
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return string
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return QuizOpciones
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }


    /**
     * Set quiz
     *
     * @param \Quiz\QuizBundle\Entity\Quiz $quiz
     * @return Opciones
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
}
