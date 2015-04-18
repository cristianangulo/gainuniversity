<?php

namespace AppBundle\Entity\Admin\Modulos;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursos
 */
class Cursos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $curso;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fechaPublicacion;

    /**
     * @var integer
     */
    private $temporalidad;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $modulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modulos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set curso
     *
     * @param string $curso
     * @return Cursos
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return string 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Cursos
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
     * Set fechaPublicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return Cursos
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * Get fechaPublicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * Set temporalidad
     *
     * @param integer $temporalidad
     * @return Cursos
     */
    public function setTemporalidad($temporalidad)
    {
        $this->temporalidad = $temporalidad;

        return $this;
    }

    /**
     * Get temporalidad
     *
     * @return integer 
     */
    public function getTemporalidad()
    {
        return $this->temporalidad;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Cursos
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Add modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\CursoModulos $modulos
     * @return Cursos
     */
    public function addModulo(\AppBundle\Entity\Admin\Modulos\CursoModulos $modulos)
    {
        $this->modulos[] = $modulos;

        return $this;
    }

    /**
     * Remove modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\CursoModulos $modulos
     */
    public function removeModulo(\AppBundle\Entity\Admin\Modulos\CursoModulos $modulos)
    {
        $this->modulos->removeElement($modulos);
    }

    /**
     * Get modulos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModulos()
    {
        return $this->modulos;
    }
}
