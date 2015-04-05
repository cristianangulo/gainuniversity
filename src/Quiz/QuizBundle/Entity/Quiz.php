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
     * @ORM\OneToMany(targetEntity="Elearn\ElearnBundle\Entity\Secciones", mappedBy="quiz")
     */

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
     * @ORM\OneToMany(targetEntity="Preguntas", mappedBy="quiz", cascade={"persist"})
     * @ORM\OrderBy({"posicion" = "ASC"})
     */

    private $preguntas;

    public function __construct()
    {
      $this->secciones = new \Doctrine\Common\Collections\ArrayCollection();
      $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add secciones
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $secciones
     * @return Quiz
     */
    public function addSeccione(\Elearn\ElearnBundle\Entity\Secciones $secciones)
    {
        $this->secciones[] = $secciones;

        return $this;
    }

    /**
     * Remove secciones
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $secciones
     */
    public function removeSeccione(\Elearn\ElearnBundle\Entity\Secciones $secciones)
    {
        $this->secciones->removeElement($secciones);
    }

    /**
     * Get secciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSecciones()
    {
        return $this->secciones;
    }

    /**
     * Add preguntas
     *
     * @param \Quiz\QuizBundle\Entity\Preguntas $preguntas
     * @return Quiz
     */
    public function addPregunta(\Quiz\QuizBundle\Entity\Preguntas $preguntas)
    {
        $this->preguntas[] = $preguntas;

        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \Quiz\QuizBundle\Entity\Preguntas $preguntas
     */
    public function removePregunta(\Quiz\QuizBundle\Entity\Preguntas $preguntas)
    {
        $this->preguntas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    public function __toString()
    {
       return $this->id;
    }
}
