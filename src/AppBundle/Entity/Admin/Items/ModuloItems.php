<?php

namespace AppBundle\Entity\Admin\Items;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuloSecciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\ModuloItemsRepository")
 */
class ModuloItems
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Modulos\Modulos", inversedBy="modulosecciones")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Items\Items", inversedBy="seccionesmodulo")
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
     * @param \AppBundle\Entity\Admin\Modulos\Modulos $modulos
     * @return ModuloSecciones
     */
    public function setModulos(\AppBundle\Entity\Admin\Modulos\Modulos $modulos = null)
    {
        $this->modulos = $modulos;

        return $this;
    }

    /**
     * Get modulos
     *
     * @return \AppBundle\Entity\Admin\Modulos\Modulos
     */
    public function getModulos()
    {
        return $this->modulos;
    }

    /**
     * Set secciones
     *
     * @param \AppBundle\Entity\Admin\Items\Items $secciones
     * @return ModuloSecciones
     */
    public function setSecciones(\AppBundle\Entity\Admin\Items\Items $secciones = null)
    {
        $this->secciones = $secciones;

        return $this;
    }

    /**
     * Get secciones
     *
     * @return \AppBundle\Entity\Admin\Items\Items
     */
    public function getSecciones()
    {
        return $this->secciones;
    }
}
