<?php

namespace AppBundle\Entity\Admin\Modulos;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Modulos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\ModulosRepository")
 */
class Modulos
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
     * @ORM\Column(name="modulo", type="string", length=50)
     */
    private $modulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Modulos\ModuloItems", mappedBy="modulos", cascade={"persist"})
     * @ORM\OrderBy({"posicion" = "ASC"})
     **/

    private $secciones;
    // ...

    public function __construct() {
        $this->secciones = new ArrayCollection();
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
     * Set modulo
     *
     * @param string $modulo
     * @return Modulos
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return string
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Modulos
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
     * Add secciones
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $secciones
     * @return Modulos
     */
    public function addSeccione(\AppBundle\Entity\Admin\Modulos\ModuloItems $secciones)
    {
        $this->secciones[] = $secciones;

        return $this;
    }

    /**
     * Remove secciones
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $secciones
     */
    public function removeSeccione(\AppBundle\Entity\Admin\Modulos\ModuloItems $secciones)
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
}
