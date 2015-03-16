<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CursoUsuarios
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CursoUsuarios
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
     * @ORM\ManyToOne(targetEntity="Cursos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $curso;

    /**
     * @ORM\ManyToOne(targetEntity="ACL\ACLBundle\Entity\Usuarios", inversedBy="usuarioscurso")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     **/
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fechaRegistro;

    public function __construct()
    {
        $this->fechaRegistro = new \DateTime();
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
     * Set fechaRegistro
     *
     * @param string $fechaRegistro
     * @return CursosUsuarios
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return string
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set curso
     *
     * @param \Elearn\ElearnBundle\Entity\Cursos $curso
     * @return CursoUsuarios
     */
    public function setCurso(\Elearn\ElearnBundle\Entity\Cursos $curso = null)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \Elearn\ElearnBundle\Entity\Cursos
     */
    public function getCursos()
    {
        return $this->curso;
    }

    /**
     * Set usuario
     *
     * @param \ACL\ACLBundle\Entity\Usuarios $usuario
     * @return CursoUsuarios
     */
    public function setUsuario(\ACL\ACLBundle\Entity\Usuarios $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \ACL\ACLBundle\Entity\Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Get curso
     *
     * @return \Elearn\ElearnBundle\Entity\Cursos 
     */
    public function getCurso()
    {
        return $this->curso;
    }
}
