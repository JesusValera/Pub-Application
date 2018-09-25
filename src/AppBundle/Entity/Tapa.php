<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Tapa
 *
 * @ORM\Table(name="tapa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TapaRepository")
 */
class Tapa
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var Ingredient $ingredients
     *
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @ORM\JoinTable(name="ingredients_tapas",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ingredients", referencedColumnName="id")}
     *      )
     */
    private $ingredients;

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
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetimetz")
     */
    private $creationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="top", type="boolean")
     */
    private $top;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tapas")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    public function getTop()
    {
        return $this->top;
    }

    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient)
    {
        return $this->ingredients->removeElement($ingredient);
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

}
