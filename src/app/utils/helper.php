<?php

if (!function_exists('config')) {

    function config($propertyNeme)
    {
        $config = new app\utils\ConfigFactory();

        return $config->get($propertyNeme);
    }

}
