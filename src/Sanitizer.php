<?php

namespace TeaTracker;

class Sanitizer
{
    private array $collection;

    public function __construct(array $collection = [])
    {
        if (!isset($collection['general'])) {
            $collection['general'] = [];
        }
        $this->collection = $collection;
    }

    /**
     * Filter a parameter value using given settings in configuration files
     * The `$name` is to be formatted as such: "{route}.{parameter}"
     * 
     * @param string $name Name of the parameter to be filtered
     * @param mixed $value Value of parameter
     * 
     * @return mixed
     */
    public function filter(string $name, mixed $value)
    {
        $route = '';
        $paramName = $name;
        if (strpos($name, '.') !== false) {
            list($route, $paramName) = explode('.', $name, 2);
        }

        // Is parameter generally valid or is route-param constellation allowed?
        $config = [];
        if (
            array_key_exists($route, $this->collection)
            && array_key_exists($paramName, $this->collection[$route])
        ) {
            $config = $this->collection[$route][$paramName];
        } elseif (isset($this->collection['general'][$paramName])) {
            $config = $this->collection['general'][$paramName];
        }

        if ($config === []) {
            return false;
        }

        return filter_var($value, $config['filter'], $config['options'] ?? []);
    }
}

