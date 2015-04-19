<?php

namespace AppBundle\Entity\Admin\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizUsuario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Quiz\QuizUsuarioRepository")
 */
class QuizUsuario
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Cursos\Cursos", inversedBy="calificacion")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     */

    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Modulos\Modulos", inversedBy="calificacion")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     */

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Items\Items", inversedBy="calificacion")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\Quiz", inversedBy="calificacion")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quizes;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ACL\Usuarios", inversedBy="calificacion")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuarios;

    /**
     * @var string
     *
     * @ORM\Column(name="calificacion", type="string", length=255)
     */
    private $calificacion;


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
     * Set calificacion
     *
     * @param string $calificacion
     * @return QuizUsuario
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return string 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set cursos
     *
     * @param \AppBundle\Entity\Admin\Cursos\Cursos $cursos
     * @return QuizUsuario
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
     * @return QuizUsuario
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
     * @return QuizUsuario
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

    /**
     * Set quizes
     *
     * @param \AppBundle\Entity\Admin\Quiz\Quiz $quizes
     * @return QuizUsuario
     */
    public function setQuizes(\AppBundle\Entity\Admin\Quiz\Quiz $quizes = null)
    {
        $this->quizes = $quizes;

        return $this;
    }

    /**
     * Get quizes
     *
     * @return \AppBundle\Entity\Admin\Quiz\Quiz 
     */
    public function getQuizes()
    {
        return $this->quizes;
    }

    /**
     * Set usuarios
     *
     * @param \AppBundle\Entity\ACL\Usuarios $usuarios
     * @return QuizUsuario
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
}
