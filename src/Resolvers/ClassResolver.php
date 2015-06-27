<?php

namespace Humweb\Features\Resolvers;

/**
 * ClassResolver.
 */
class ClassResolver
{
    protected $namespace = '';
    protected $suffix    = '';


    /**
     * @param string $class
     *
     * @return string
     */
    public function resolve($class)
    {
        $class = $this->formatClassName($class);

        $assembledClass = '\\'.trim($this->getNamespace(), '\\').'\\'.$class.$this->getSuffix();

        if (class_exists($assembledClass)) {
            return $assembledClass;
        }

        if (class_exists($class)) {
            return $class;
        }

        throw new \InvalidArgumentException('Unable to resolve class: '.$class.' or '.$assembledClass);
    }


    /**
     * Format class name to "studly case"
     *
     * @param string $name
     *
     * @return string
     */
    protected function formatClassName($name)
    {
        $name = ucwords(str_replace(['-', '_'], ' ', $name));

        return str_replace(' ', '', $name);
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
