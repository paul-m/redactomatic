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
    'user' => 'DB1_USER',
    'password' => 'DB1_PASS',
    'dbname' => 'DB1_NAME',
    'host' => 'DB1_HOST'
  );
}

$paths = array('Src/Redacted/Entities/');
$isDevMode = TRUE;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

