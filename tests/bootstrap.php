<?php

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!is_readable($autoloadFile)) {
    throw new RuntimeException('Autoloader not found, did you run composer install?');
}

include_once $autoloadFile;
