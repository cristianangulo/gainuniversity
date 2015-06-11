<?php

namespace AppBundle\Entity\Admin\Modulos;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ModuloSecciones
 *
 * @ORM\Table(name="ModuloSecciones")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Modulos\ModuloItemsRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Modulos\Modulos", inversedBy="items")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Items\Items", inversedBy="modulos")
     * @ORM\JoinColumn(name="seccion_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Seleccione un Ítem")
     **/

    private $items;

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
     * @param integer $posicion
     *
     * @return ModuloItems
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
     * Set modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\Modulos $modulos
     *
     * @return ModuloItems
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
     * Set items
     *
     * @param \AppBundle\Entity\Admin\Items\Items $items
     *
     * @return ModuloItems
     */
    public function setItems(\AppBundle\Entity\Admin\Items\Items $items = null)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \AppBundle\Entity\Admin\Items\Items
     */
    public function getItems()
    {
        return $this->items;
    }
}
