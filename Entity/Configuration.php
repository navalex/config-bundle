<?php

namespace Navalex\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Configuration
 *
 * @ORM\Table(name="navalex__config__configuration")
 * @ORM\Entity(repositoryClass="Navalex\ConfigBundle\Repository\ConfigurationRepository")
 */
class Configuration
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="helper", type="text", nullable=true)
     */
    private $helper;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Navalex\ConfigBundle\Entity\Fieldset", inversedBy="configurations")
     * @Assert\NotBlank()
     */
    private $fieldset;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     */
    private $translation;


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
     * @return Configuration
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
     * Set description
     *
     * @param string $description
     *
     * @return Configuration
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set helper
     *
     * @param string $helper
     *
     * @return Configuration
     */
    public function setHelper($helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Get helper
     *
     * @return string
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Configuration
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set category
     *
     * @param integer $category
     *
     * @return Configuration
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set field
     *
     * @param string $field
     *
     * @return Configuration
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set fieldset
     *
     * @param \Navalex\ConfigBundle\Entity\Fieldset $fieldset
     *
     * @return Configuration
     */
    public function setFieldset(\Navalex\ConfigBundle\Entity\Fieldset $fieldset = null)
    {
        $this->fieldset = $fieldset;

        return $this;
    }

    /**
     * Get fieldset
     *
     * @return \Navalex\ConfigBundle\Entity\Fieldset
     */
    public function getFieldset()
    {
        return $this->fieldset;
    }

    /**
     * Set translation
     *
     * @param string $translation
     *
     * @return Configuration
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }
}
