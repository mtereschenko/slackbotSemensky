<?php

if (!function_exists('config')) {

    function config($propertyNeme)
    {
        $config = app\utils\ConfigFactory::getFactory();

        return $config->get($propertyNeme);
    }

}
