<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioQuizOpciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\UsuarioQuizOpcionesRepository")
 */
class UsuarioQuizOpciones
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
     * @ORM\ManyToOne(targetEntity="Elearn\ElearnBundle\Entity\Cursos", inversedBy="calificacion")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     */

    private $curso;

    /**
     * @ORM\ManyToOne(targetEntity="Elearn\ElearnBundle\Entity\Modulos", inversedBy="calificacion")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     */

    private $modulo;

    /**
     * @ORM\ManyToOne(targetEntity="Elearn\ElearnBundle\Entity\Secciones", inversedBy="calificacion")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="calificacion")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @ORM\ManyToOne(targetEntity="Opciones", inversedBy="calificacion")
     * @ORM\JoinColumn(name="opcion_id", referencedColumnName="id")
     */

    private $opcion;

    /**
     * @var boolean
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
     * @return UsuarioQuizOpciones
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
     * Set curso
     *
     * @param \Elearn\ElearnBundle\Entity\Cursos $curso
     * @return UsuarioQuizOpciones
     */
    public function setCurso(\Elearn\ElearnBundle\Entity\Cursos $curso = null)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \Elearn\ElearnBundle\Entity\Cursos 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set modulo
     *
     * @param \Elearn\ElearnBundle\Entity\Modulos $modulo
     * @return UsuarioQuizOpciones
     */
    public function setModulo(\Elearn\ElearnBundle\Entity\Modulos $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \Elearn\ElearnBundle\Entity\Modulos 
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set item
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $item
     * @return UsuarioQuizOpciones
     */
    public function setItem(\Elearn\ElearnBundle\Entity\Secciones $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Elearn\ElearnBundle\Entity\Secciones 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set quiz
     *
     * @param \Quiz\QuizBundle\Entity\Quiz $quiz
     * @return UsuarioQuizOpciones
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
     * Set opcion
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opcion
     * @return UsuarioQuizOpciones
     */
    public function setOpcion(\Quiz\QuizBundle\Entity\Opciones $opcion = null)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return \Quiz\QuizBundle\Entity\Opciones 
     */
    public function getOpcion()
    {
        return $this->opcion;
    }
}
