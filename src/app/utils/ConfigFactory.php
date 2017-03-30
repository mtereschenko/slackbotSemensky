<?php

namespace app\utils;

class ConfigFactory
{

    private static $instance = null;

    private function __construct()
    {
        $onfigFile = './config/app.php';

        $this->loadConfig($onfigFile);
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
            throw new \FileNotFoundException("Whoops))) File {$fullFileName} not found ;)");
        }

        $config = require_once $fullFileName;

        $this->setConfig($config);
    }

    public function setConfig($config, $propertyPart = [])
    {
        foreach ($config as $property => $value) {
            if (is_array($value)) {
                $propertyPart[] = $property;
                $this->setConfig($value, $propertyPart);
                $propertyPart = [];
            } else {
                $propertyPart[] = $property;
                $finalPropertyname = implode('_', $propertyPart);
                $this->$finalPropertyname = $value;
            }
        }
    }

    public function get($property)
    {
        if (property_exists($this, $property)) {
            $property = $this->$property;
        } else {
            $property = NULL;
        }

        return $property;
    }

}
