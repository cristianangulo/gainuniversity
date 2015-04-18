<?php

namespace AppBundle\Entity\Admin\Cursos;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ACL\ACLBundle\Entity\Usuarios;
/**
 * Cursos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Cursos\CursosRepository")
 */
class Cursos
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
     * @ORM\Column(name="curso", type="string", length=50)
     */
    private $curso;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_publicacion", type="datetime")
     */
    private $fechaPublicacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="temporalidad", type="integer")
     */

    private $temporalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=100)
     */
    private $sku;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Cursos\CursoModulos", mappedBy="cursos", cascade={"persist"})
    * @ORM\OrderBy({"posicion" = "ASC"})
    */
    private $modulos;

    public function __construct()
    {
      $this->modulos = new ArrayCollection();
      $this->fechaPublicacion = new \DateTime('now');
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
     * Get curso
     *
     * @return string
     */
    public function getCurso()
    {
        return $this->curso;
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
     * @param \Elearn\ElearnBundle\Entity\CursoModulos $modulos
     * @return Cursos
     */
    public function addModulo(\Elearn\ElearnBundle\Entity\CursoModulos $modulos)
    {
        $this->modulos[] = $modulos;

        return $this;
    }

    /**
     * Remove modulos
     *
     * @param \Elearn\ElearnBundle\Entity\CursoModulos $modulos
     */
    public function removeModulo(\Elearn\ElearnBundle\Entity\CursoModulos $modulos)
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
