<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuloSecciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\ModuloSeccionesRepository")
 */
class ModuloSecciones
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
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    /**
     * @ORM\ManyToOne(targetEntity="Modulos", inversedBy="modulosecciones")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="Secciones", inversedBy="seccionesmodulo")
     * @ORM\JoinColumn(name="seccion_id", referencedColumnName="id")
     **/

    private $secciones;

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
     * Set posicion
     *
     * @param string $posicion
     * @return ModuloSecciones
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return string
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set modulos
     *
     * @param \Elearn\ElearnBundle\Entity\Modulos $modulos
     * @return ModuloSecciones
     */
    public function setModulos(\Elearn\ElearnBundle\Entity\Modulos $modulos = null)
    {
        $this->modulos = $modulos;

        return $this;
    }

    /**
     * Get modulos
     *
     * @return \Elearn\ElearnBundle\Entity\Modulos
     */
    public function getModulos()
    {
        return $this->modulos;
    }

    /**
     * Set secciones
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $secciones
     * @return ModuloSecciones
     */
    public function setSecciones(\Elearn\ElearnBundle\Entity\Secciones $secciones = null)
    {
        $this->secciones = $secciones;

        return $this;
    }

    /**
     * Get secciones
     *
     * @return \Elearn\ElearnBundle\Entity\Secciones
     */
    public function getSecciones()
    {
        return $this->secciones;
    }
}
