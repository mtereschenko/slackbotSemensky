<?php

namespace app\utils;

class ConfigFactory
{
    private static $instance = null;

    private function __construct()
    {
        $configFile = './config/app.php';

        $this->loadConfig($configFile);
    }

    private function __clone()
    {
    }

    public static function getFactory()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function loadConfig($fullFileName)
    {
        if (!file_exists($fullFileName)) {
            throw new \FileNotFoundException("Whoops))) File {$fullFileName} not found. Create config file first ;)");
        }

        $config = require_once $fullFileName;

        $this->setConfig($config);
    }

    public function setConfig($config, $propertyPart = [])
    {
        foreach ($config as $property => $value) {
            if (is_array($value)) {
                $propertyPart[$property] = ucfirst($property);
                $this->setConfig($value, $propertyPart);
                $propertyPart = [];
            } else {
                $propertyPart[$property] = ucfirst($property);
                $finalPropertyname = implode('', $propertyPart);
                $formatedPropertyName = lcfirst($finalPropertyname);
                $this->$formatedPropertyName = $value;
                // явный костыль чтобы не накапливать уровни переменных
                unset($propertyPart[$property]);
            }
        }
    }

    public function get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
