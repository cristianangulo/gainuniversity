<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\QuizRepository")
 */
class Quiz
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
     * @ORM\Column(name="quiz", type="string", length=255)
     */
    private $quiz;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;


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
     * Set quiz
     *
     * @param string $quiz
     * @return Quiz
     */
    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return string
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Quiz
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
     * Add opciones
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opciones
     * @return Quiz
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
     * @ORM\OneToMany(targetEntity="Opciones", mappedBy="quiz")
     */

    protected $opciones;

    public function __construct()
    {
      $this->opciones = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set opciones
     *
     */
    public function setOpciones(Opciones $opciones = null)
    {
        $this->opciones =  $opciones;
    }
}
