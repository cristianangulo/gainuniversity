<?php

namespace Elearn\ElearnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Secciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elearn\ElearnBundle\Entity\SeccionesRepository")
 */
class Secciones
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
     * @ORM\Column(name="seccion", type="string", length=50)
     */
    private $seccion;

    /**
    * @var string
    *
    * @ORM\Column(name="multimedia", type="string", length=255, nullable=true)
    */
    private $multimedia;

    /**
     * @Assert\File(maxSize="600000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="ModuloSecciones", mappedBy="secciones")
     **/

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="TipoSeccion", inversedBy="secciones")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz\QuizBundle\Entity\Quiz", inversedBy="secciones")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    protected $quiz;

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
     * Set seccion
     *
     * @param string $seccion
     * @return Secciones
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Secciones
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Secciones
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
     * Set activo
     *
     * @param integer $activo
     * @return Secciones
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set enlace
     *
     * @param string $enlace
     * @return Secciones
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;

        return $this;
    }

    /**
     * Get enlace
     *
     * @return string
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Add seccionesmodulo
     *
     * @param \Elearn\ElearnBundle\Entity\ModuloSecciones $seccionesmodulo
     * @return Secciones
     */
    public function addSeccionesmodulo(\Elearn\ElearnBundle\Entity\ModuloSecciones $seccionesmodulo)
    {
        $this->seccionesmodulo[] = $seccionesmodulo;

        return $this;
    }

    /**
     * Remove seccionesmodulo
     *
     * @param \Elearn\ElearnBundle\Entity\ModuloSecciones $seccionesmodulo
     */
    public function removeSeccionesmodulo(\Elearn\ElearnBundle\Entity\ModuloSecciones $seccionesmodulo)
    {
        $this->seccionesmodulo->removeElement($seccionesmodulo);
    }

    /**
     * Get seccionesmodulo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeccionesmodulo()
    {
        return $this->seccionesmodulo;
    }

    /**
     * Add modulos
     *
     * @param \Elearn\ElearnBundle\Entity\ModuloSecciones $modulos
     * @return Secciones
     */
    public function addModulo(\Elearn\ElearnBundle\Entity\ModuloSecciones $modulos)
    {
        $this->modulos[] = $modulos;

        return $this;
    }

    /**
     * Remove modulos
     *
     * @param \Elearn\ElearnBundle\Entity\ModuloSecciones $modulos
     */
    public function removeModulo(\Elearn\ElearnBundle\Entity\ModuloSecciones $modulos)
    {
        $this->modulos->removeElement($modulos);
    }

    /**
     * Get modulos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModulos()
    {
        return $this->modulos;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modulos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tipo
     *
     * @param \Elearn\ElearnBundle\Entity\TipoSeccion $tipo
     * @return Secciones
     */
    public function setTipo(\Elearn\ElearnBundle\Entity\TipoSeccion $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Elearn\ElearnBundle\Entity\TiposSecciones
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set multimedia
     *
     * @param string $multimedia
     * @return Secciones
     */
    public function setMultimedia($multimedia)
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    /**
     * Get multimedia
     *
     * @return string
     */
    public function getMultimedia()
    {
        return $this->multimedia;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Secciones
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set quiz
     *
     * @param \Quiz\QuizBundle\Entity\Quiz $quiz
     * @return Secciones
     */
    public function setQuiz(\Quiz\QuizBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \Quiz\QuizBundle\Entity\Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}
