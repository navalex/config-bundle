<?php

namespace Navalex\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fieldset
 *
 * @ORM\Table(name="navalex__config__fieldset")
 * @ORM\Entity(repositoryClass="Navalex\ConfigBundle\Repository\FieldsetRepository")
 */
class Fieldset
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
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="`order`", type="integer")
     */
    private $order;

    /**
     * @ORM\OneToMany(targetEntity="Navalex\ConfigBundle\Entity\Configuration", cascade={"remove"}, mappedBy="fieldset")
     */
    private $configurations;

    /**
     * @ORM\ManyToOne(targetEntity="Navalex\ConfigBundle\Entity\Category", inversedBy="fieldsets")
     * @Assert\NotBlank()
     */
    private $category;


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Fieldset
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->configurations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Fieldset
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add configuration
     *
     * @param \Navalex\ConfigBundle\Entity\Configuration $configuration
     *
     * @return Fieldset
     */
    public function addConfiguration(\Navalex\ConfigBundle\Entity\Configuration $configuration)
    {
        $this->configurations[] = $configuration;

        return $this;
    }

    /**
     * Remove configuration
     *
     * @param \Navalex\ConfigBundle\Entity\Configuration $configuration
     */
    public function removeConfiguration(\Navalex\ConfigBundle\Entity\Configuration $configuration)
    {
        $this->configurations->removeElement($configuration);
    }

    /**
     * Get configurations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }

    /**
     * Set category
     *
     * @param \Navalex\ConfigBundle\Entity\Category $category
     *
     * @return Fieldset
     */
    public function setCategory(\Navalex\ConfigBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Navalex\ConfigBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
