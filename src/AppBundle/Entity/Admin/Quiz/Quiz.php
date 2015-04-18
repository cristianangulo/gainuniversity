<?php

namespace AppBundle\Entity\Admin\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Quiz\QuizRepository")
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Quiz\Preguntas", mappedBy="quiz", cascade={"persist"})
     * @ORM\OrderBy({"posicion" = "ASC"})
     */

    private $preguntas;

    public function __construct()
    {
      $this->secciones = new \Doctrine\Common\Collections\ArrayCollection();
      $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add preguntas
     *
     * @param \AppBundle\Entity\Admin\Quiz\Preguntas $preguntas
     * @return Quiz
     */
    public function addPregunta(\AppBundle\Entity\Admin\Quiz\Preguntas $preguntas)
    {
        $this->preguntas[] = $preguntas;

        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \AppBundle\Entity\Admin\Quiz\Preguntas $preguntas
     */
    public function removePregunta(\AppBundle\Entity\Admin\Quiz\Preguntas $preguntas)
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
}
