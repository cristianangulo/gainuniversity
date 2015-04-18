<?php

namespace AppBundle\Entity\Admin\Items;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Secciones
 *
 * @ORM\Table(name="Secciones")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Admin\Items\ItemsRepository")
 */
class Items
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Admin\Modulos\ModuloItems", mappedBy="items")
     **/

    private $modulos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Items\TipoItem", inversedBy="items")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Quiz\Quiz", inversedBy="items")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    protected $quiz;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modulos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Items
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
     * Set multimedia
     *
     * @param string $multimedia
     * @return Items
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Items
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
     * Add modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $modulos
     * @return Items
     */
    public function addModulo(\AppBundle\Entity\Admin\Modulos\ModuloItems $modulos)
    {
        $this->modulos[] = $modulos;

        return $this;
    }

    /**
     * Remove modulos
     *
     * @param \AppBundle\Entity\Admin\Modulos\ModuloItems $modulos
     */
    public function removeModulo(\AppBundle\Entity\Admin\Modulos\ModuloItems $modulos)
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
     * Set tipo
     *
     * @param \AppBundle\Entity\Admin\Items\TipoItem $tipo
     * @return Items
     */
    public function setTipo(\AppBundle\Entity\Admin\Items\TipoItem $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Admin\Items\TipoItem 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set quiz
     *
     * @param \AppBundle\Entity\Admin\Quiz\Quiz $quiz
     * @return Items
     */
    public function setQuiz(\AppBundle\Entity\Admin\Quiz\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \AppBundle\Entity\Admin\Quiz\Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}
