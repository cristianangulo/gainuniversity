<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoSeccion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\TipoSeccionRepository")
 */
class TipoSeccion
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
     * @ORM\Column(name="tipo_seccion", type="string", length=100)
     */
    private $tipoSeccion;

    /**
     * @var string
     *
     * @ORM\Column(name="svg_seccion", type="string", length=20)
     */
    private $svgSeccion;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=100)
     */
    private $color;


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
     * Set tipoSeccion
     *
     * @param string $tipoSeccion
     * @return TipoSeccion
     */
    public function setTipoSeccion($tipoSeccion)
    {
        $this->tipoSeccion = $tipoSeccion;

        return $this;
    }

    /**
     * Get tipoSeccion
     *
     * @return string
     */
    public function getTipoSeccion()
    {
        return $this->tipoSeccion;
    }

    /**
     * Set svgSeccion
     *
     * @param string $svgSeccion
     * @return TipoSeccion
     */
    public function setSvgSeccion($svgSeccion)
    {
        $this->svgSeccion = $svgSeccion;

        return $this;
    }

    /**
     * Get svgSeccion
     *
     * @return string
     */
    public function getSvgSeccion()
    {
        return $this->svgSeccion;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return TipoSeccion
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
