<?php

namespace Navalex\ConfigBundle\Services;

class ConfigTwig extends \Twig_Extension
{
    protected $configs;

    public function __construct(Config $config)
    {
        $this->configs = $config;
    }

    public function get($name)
    {
        return $this->configs->get($name);
    }

    public function getCategories()
    {
        return $this->configs->getCategories();
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getConfig', array($this, 'get')),
            new \Twig_SimpleFunction('getConfigCategories', array($this, 'getCategories'))
        );
    }

    public function getName()
    {
        return 'NavalexConfig';
    }
}