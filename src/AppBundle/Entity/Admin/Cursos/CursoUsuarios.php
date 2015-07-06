<?php

namespace AppBundle\Entity\Admin\Cursos;

use Doctrine\ORM\Mapping as ORM;

/**
 * CursoUsuarios
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Cursos\CursoUsuariosRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Cursos\Cursos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ACL\Usuarios", inversedBy="cursoUsuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $usuarios;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_diploma", type="datetime")
     */
    private $fechaDiploma;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="text")
     */
    private $nombre;

    public function __construct()
    {
        $this->fechaRegistro = new \DateTime();
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
     * @param \DateTime $fechaRegistro
     * @return CursoUsuarios
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }


    /**
     * Set cursos
     *
     * @param \AppBundle\Entity\Admin\Cursos\Cursos $cursos
     *
     * @return CursoUsuarios
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
     * Set usuarios
     *
     * @param \AppBundle\Entity\ACL\Usuarios $usuarios
     *
     * @return CursoUsuarios
     */
    public function setUsuarios(\AppBundle\Entity\ACL\Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \AppBundle\Entity\ACL\Usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CursoUsuarios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set fechaDiploma
     *
     * @param \DateTime $fechaDiploma
     *
     * @return CursoUsuarios
     */
    public function setFechaDiploma($fechaDiploma)
    {
        $this->fechaDiploma = $fechaDiploma;

        return $this;
    }

    /**
     * Get fechaDiploma
     *
     * @return \DateTime
     */
    public function getFechaDiploma()
    {
        return $this->fechaDiploma;
    }
}
