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
    /**
     * @var App\Data\Config|\App\Data\ConfigLocal
     */
    public $config;

    /**
     * @return Application
     */
    public static function getApp()
    {
        if (empty(static::$app)) {
            static::$app = new Static();
        }
        return static::$app;
    }


    private function __construct()
    {
        if (class_exists("Data\\ConfigLocal")) {
            $this->config = Data\ConfigLocal::Class;
        } else {
            $this->config = Data\Config::Class;
        }
    }

    public function runApp()
    {

    }

}