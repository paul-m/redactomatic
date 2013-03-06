<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$dbParams = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/database/redacted.sqlite',
);

$paths = array('Src/Redacted/Entities/');
$isDevMode = TRUE;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

