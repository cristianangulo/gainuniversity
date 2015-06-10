<?php

namespace AppBundle\Entity\Admin\Modulos;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Modulos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Modulos\ModulosRepository")
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
     * @Assert\NotBlank(message="El nombre del módulo es obligatorio")
     */
    private $modulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     * @Assert\NotBlank(message="Es obligatorio")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Modulos\ModuloItems", mappedBy="modulos", cascade={"persist"})
     * @ORM\OrderBy({"posicion" = "ASC"})
     * @Assert\NotBlank(message="Es obligatorio")
     **/

    private $items;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Cursos\CursoModulos", mappedBy="modulos")
    * @ORM\OrderBy({"posicion" = "ASC"})
    */
    private $cursos;

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
     *
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
     *
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
     * Add item
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $item
     *
     * @return Modulos
     */
    public function addItem(\AppBundle\Entity\Admin\Modulos\ModuloItems $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $item
     */
    public function removeItem(\AppBundle\Entity\Admin\Modulos\ModuloItems $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add curso
     *
     * @param \AppBundle\Entity\Admin\Cursos\CursoModulos $curso
     *
     * @return Modulos
     */
    public function addCurso(\AppBundle\Entity\Admin\Cursos\CursoModulos $curso)
    {
        $this->cursos[] = $curso;

        return $this;
    }

    /**
     * Remove curso
     *
     * @param \AppBundle\Entity\Admin\Cursos\CursoModulos $curso
     */
    public function removeCurso(\AppBundle\Entity\Admin\Cursos\CursoModulos $curso)
    {
        $this->cursos->removeElement($curso);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCursos()
    {
        return $this->cursos;
    }
}
