<?php
/**
 * Take care of unit tests' autoloading
 */

if (!is_file(__DIR__ . '/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

$autoloader = require_once __DIR__ . '/../vendor/autoload.php';
