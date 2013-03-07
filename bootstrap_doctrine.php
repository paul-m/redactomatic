<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$dbParams = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/database/redacted.sqlite',
);

if (isset($_SERVER['PLATFORM']) && ($_SERVER['PLATFORM'] == 'PAGODABOX')) {
  $dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => $_SERVER['DB1_USER'],
    'password' => $_SERVER['DB1_PASS'],
    'dbname' => $_SERVER['DB1_NAME'],
    'host' => $_SERVER['DB1_HOST']
  );
}

$paths = array('Src/Redacted/Entities/');
$isDevMode = TRUE;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

