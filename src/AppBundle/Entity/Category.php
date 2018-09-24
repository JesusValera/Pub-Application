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

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picture.
     *
     * @param string $picture
     *
     * @return Category
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return null|File
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(File $pictureFile)
    {
        $this->pictureFile = $pictureFile;
    }

    /**
     * Add tapa
     *
     * @param Tapa $tapa
     *
     * @return Category
     */
    public function addTapa(Tapa $tapa)
    {
        $this->tapas[] = $tapa;

        return $this;
    }

    /**
     * Remove tapa
     *
     * @param Tapa $tapa
     */
    public function removeTapa(Tapa $tapa)
    {
        $this->tapas->removeElement($tapa);
    }

    /**
     * Get tapas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTapas()
    {
        return $this->tapas;
    }

    public function __toString()
    {
        return "$this->name";
    }

}
