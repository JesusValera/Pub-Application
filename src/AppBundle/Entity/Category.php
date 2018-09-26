<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * CategoryTapa
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var $pictureFile File
     */
    private $pictureFile;

    /**
     * @ORM\OneToMany(targetEntity="Tapa", mappedBy="category")
     */
    private $tapas;

    public function __construct()
    {
        $this->tapas = new ArrayCollection();
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPictureFile(File $pictureFile)
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function addTapa(Tapa $tapa)
    {
        $this->tapas[] = $tapa;

        return $this;
    }

    public function removeTapa(Tapa $tapa)
    {
        $this->tapas->removeElement($tapa);
    }

    public function getTapas()
    {
        return $this->tapas;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
