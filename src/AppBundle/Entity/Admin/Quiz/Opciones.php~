<?php

namespace AppBundle\Entity\Admin\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizOpciones
 *
 * @ORM\Table(name="Opciones")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Quiz\OpcionesRepository")
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
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\Preguntas", inversedBy="opciones")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     **/

    private $preguntas;

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
     * @return Opciones
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
     * @param boolean $valor
     * @return Opciones
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return boolean 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Opciones
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
     * Set preguntas
     *
     * @param \AppBundle\Entity\Admin\Quiz\Preguntas $preguntas
     * @return Opciones
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
}
