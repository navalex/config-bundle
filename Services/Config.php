<?php

namespace Navalex\ConfigBundle\Services;

use Doctrine\ORM\EntityManager;
use Navalex\ConfigBundle\Entity\Category;
use Navalex\ConfigBundle\Entity\Configuration;
use Navalex\ConfigBundle\Entity\Fieldset;

class Config
{
    protected $repo;
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('NavalexConfigBundle:Configuration');

    }

    /**
     * Return value of the config by $name
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        $value = $this->repo->findOneBy([
            'name' => $name
        ]);

        return (is_null($value)) ? "No value for: $name" : $value->getValue();
    }

    public function getCategories()
    {
        return $this->em->getRepository('NavalexConfigBundle:Category')->findAll();
    }

    public function add($translate, $name, $field, $value, $description, Fieldset $fieldset, $helper = null) {
        $config = new Configuration();

        $config
            ->setTranslation($translate)
            ->setName($name)
            ->setField($field)
            ->setValue($value)
            ->setDescription($description)
            ->setFieldset($fieldset)
            ->setHelper($helper)
        ;

        $this->em->persist($config);
        $this->em->flush();
    }

    public function addCategory($name) {
        $category = new Category();

        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    public function addFieldset($name, $category, $order = 1) {
        $fieldset = new Fieldset();

        $fieldset
            ->setName($name)
            ->setOrder($order)
            ->setCategory($category)
        ;

        $this->em->persist($category);
        $this->em->persist($fieldset);
        $this->em->flush();

        return $fieldset;
    }
}