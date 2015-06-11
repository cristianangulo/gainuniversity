<?php

namespace AppBundle\Entity\Front;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ComentariosItems
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Front\ComentariosItemsRepository")
 */
class ComentariosItems
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ACL\Usuarios", inversedBy="usuariocomentarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     **/
    private $usuarios;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Cursos\Cursos", inversedBy="cursocomentarios")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Modulos\Modulos", inversedBy="modulocomentarios")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/
    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Items\Items", inversedBy="itemscomentarios")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     **/
    private $items;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text")
     * @Assert\NotBlank(message="El nombre del Curso es obligatorio")
     */
    private $comentario;

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
     * Set comentario
     *
     * @param string $comentario
     * @return ComentariosItems
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set usuarios
     *
     * @param \AppBundle\Entity\ACL\Usuarios $usuarios
     * @return ComentariosItems
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
     * Set cursos
     *
     * @param \AppBundle\Entity\Admin\Cursos\Cursos $cursos
     * @return ComentariosItems
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
     * @return ComentariosItems
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
     * @return ComentariosItems
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
