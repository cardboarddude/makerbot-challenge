<?php

class Config {
    private static $environment;
    private static $configuration;

    public static function __init() {
        spl_autoload_register(function($class_name) {
            if (!empty($class_name)) {
                $class_subfolder = self::get('PATH_CLASS');
                include_once $class_subfolder[$class_name] . $class_name.'.php';
            }
        });
    }

    private static function getPath($file_name) {
        // TODO: parse class name to determine path. Ex: RegistrationController contains "Controller" subtring so
        //       path is PATH_CONTROLLER
    }

    public static function get($config_key) {
        if (!isset(self::$configuration)) {
            self::$environment = self::getEnv();
            $config_file = 'config.'.self::$environment.'.php';

            if (!file_exists($config_file)) {
                return false;
            }

            self::$configuration = require_once($config_file);
        }

        return self::$configuration[$config_key];
    }

    private static function autoloadClass($class_name) {
        if (!empty($class_name)) {
            $class_subfolder = self::get('PATH_CLASS');

            return self::get('URI').$class_subfolder[$class_name] . $class_name.'.php';
        }

        return "";
    }

    private static function getEnv() {
        return $_ENV['APPLICATION_ENV'];
    }
}