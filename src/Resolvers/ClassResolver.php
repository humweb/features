<?php

namespace Humweb\Features\Resolvers;

/**
 * ClassResolver.
 */
class ClassResolver
{
    protected $namespace = '';
    protected $suffix = '';


    /**
     * @param string $class
     *
     * @return string
     */
    public function resolve($class)
    {
        $assembledClass = '\\'.trim($this->getNamespace(), '\\').'\\'.ucfirst($class).$this->getSuffix();

        if (class_exists($assembledClass)) {
            return $assembledClass;
        }

        if (class_exists($class)) {
            return $class;
        }

        throw new \InvalidArgumentException('Unable to resolve class: '.$class);
    }


    /**
     * @param mixed $namespace
     *
     * @return ClassResolver
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }


    /**
     * @param string $suffix
     *
     * @return ClassResolver
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }


    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }
}
