<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComentariosItems
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\ComentariosItemsRepository")
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
     * @ORM\ManyToOne(targetEntity="ACL\ACLBundle\Entity\Usuarios", inversedBy="usuariocomentarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     **/
    private $usuarios;

    /**
     * @ORM\ManyToOne(targetEntity="Cursos", inversedBy="cursocomentarios")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     **/
    private $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="Modulos", inversedBy="modulocomentarios")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     **/
    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="Secciones", inversedBy="itemscomentarios")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     **/
    private $items;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text")
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
     * Set usuarioId
     *
     * @param integer $usuarioId
     * @return ComentariosItems
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return integer
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set cursoId
     *
     * @param integer $cursoId
     * @return ComentariosItems
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
     * @return ComentariosItems
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
     * Set itemId
     *
     * @param integer $itemId
     * @return ComentariosItems
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
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
     * @param \ACL\ACLBundle\Entity\Usuarios $usuarios
     * @return ComentariosItems
     */
    public function setUsuarios(\ACL\ACLBundle\Entity\Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \Elearn\ElearnBundle\Entity\Usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set cursos
     *
     * @param \Elearn\ElearnBundle\Entity\Cursos $cursos
     * @return ComentariosItems
     */
    public function setCursos(\Elearn\ElearnBundle\Entity\Cursos $cursos = null)
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
     * @return ComentariosItems
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

    /**
     * Set items
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $items
     * @return ComentariosItems
     */
    public function setItems(\Elearn\ElearnBundle\Entity\Secciones $items = null)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \Elearn\ElearnBundle\Entity\Items
     */
    public function getItems()
    {
        return $this->items;
    }
}
