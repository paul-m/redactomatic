<?php

/**
 * @file
 * This file is used by the doctrine command line tool.
 */

require_once "bootstrap_doctrine.php";

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));

