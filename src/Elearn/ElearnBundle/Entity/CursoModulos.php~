<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CursoModulos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\CursoModulosRepository")
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
     * @ORM\ManyToOne(targetEntity="Cursos", inversedBy="cursomodulos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="Modulos", inversedBy="moduloscurso")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/
    private $modulos;

    /**
     * @var string
     *
     * @ORM\Column(name="posicion", type="string", length=255)
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
     * Set cursoId
     *
     * @param integer $cursoId
     * @return CursoModulos
     */
    public function setCursoId($cursoId)
    {
        $this->cursoId = $cursoId;

        return $this;
    }

    /**
     * Get cursoId
     *
     * @return integer
     */
    public function getCursoId()
    {
        return $this->cursoId;
    }

    /**
     * Set moduloId
     *
     * @param integer $moduloId
     * @return CursoModulos
     */
    public function setModuloId($moduloId)
    {
        $this->moduloId = $moduloId;

        return $this;
    }

    /**
     * Get moduloId
     *
     * @return integer
     */
    public function getModuloId()
    {
        return $this->moduloId;
    }

    /**
     * Set posicion
     *
     * @param string $posicion
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
     * @return string
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set cursos
     *
     * @param \Elearn\ElearnBundle\Entity\Cursos $cursos
     * @return CursoModulos
     */
    public function setCursos($cursos)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return \Elearn\ElearnBundle\Entity\Cursos
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set modulos
     *
     * @param \Elearn\ElearnBundle\Entity\Modulos $modulos
     * @return CursoModulos
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
}
