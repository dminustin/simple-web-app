<?php

namespace App\Core;

/**
 * Base Application class
 * You may extend this
 * Class Application
 *
 * Use it as singleton, run Application::getApp() to get the Application object
 *
 * @package App\Core
 */
class Application
{
    protected static $app;

    public static function getApp()
    {
        if (empty(static::$app)) {
            static::$app = new Static();
        }
        return static::$app;
    }


    private function __construct()
    {
        
    }
}