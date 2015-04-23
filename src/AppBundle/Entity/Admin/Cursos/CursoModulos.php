<?php

namespace AppBundle\Entity\Admin\Cursos;

use Doctrine\ORM\Mapping as ORM;

/**
 * CursoModulos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Cursos\CursoModulosRepository")
 */
class CursoModulos
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Cursos\Cursos", inversedBy="cursomodulos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Modulos\Modulos", inversedBy="moduloscurso")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/
    private $modulos;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

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
     * @return CursoModulos
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
     * Set cursos
     *
     * @param \AppBundle\Entity\Admin\Cursos\Cursos $cursos
     * @return CursoModulos
     */
    public function setCursos(\AppBundle\Entity\Admin\Cursos\Cursos $cursos = null)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return \AppBundle\Entity\Admin\Cursos\Cursos
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\Modulos $modulos
     * @return CursoModulos
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
}
